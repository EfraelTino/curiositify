<?php
header('Content-Type: application/json');
require_once "../../conexion/Cursos.php";
date_default_timezone_set('America/Bogota');
$fechau = date('d M Y');
$actions = new Cursos();
if (isset($_POST["action"]) && $_POST["action"] == "getstudents") {
    $response = [
        'success' => false,
        'error' => ''
    ];
    try {
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        if ($page < 1)
            $page = 1;
        $records_by_page = isset($_POST['amount_show']) ? (int) $_POST['amount_show'] : 10;
        if ($records_by_page < 10)
            $records_by_page = 10;

        $limit_from = ($page - 1) * $records_by_page;

        // Obtenemos el total de registros
        $info = $actions->executeQuery("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc();
        $response['total_records'] = $info['total'];

        // Obtenemos los registros para la "pagina actual"
        $stmt = $actions->prepare("SELECT id, apellido, nombre, fecha, email, imagen_profile, is_premium, sexo, telf FROM usuarios ORDER BY id DESC LIMIT ?, ?");
        $stmt->bind_param('ii', $limit_from, $records_by_page);
        $stmt->execute();
        $result = $stmt->get_result();

        $response['records'] = $result->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }
    echo json_encode($response);
}
// activar estudiante
if (isset($_POST['action']) && $_POST['action'] == 'activarusuario') {
    $idusuario = $_POST['idusuario'];
    try {
        // Actualizar el estado del curso
        $datas = array(
            'is_premium' => '1',
            'fecha' => $fechau,
        );
        $activar = $actions->updateDataFun('usuarios', $datas, 'id', $idusuario);

        // Comprobar si se ha actualizado correctamente
        if ($activar) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'Usuario premium');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo cambiar la suscripción del usuario');
        }
    } catch (\Throwable $th) {
        // Construir la respuesta de error en caso de excepción
        $response = array('success' => false, 'message' => 'Error al ejecutar activar usuario: ' . $th->getMessage());
    }

    // Enviar la respuesta al frontend en formato JSON
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'desactivarusuario') {
    $idusuario = $_POST['iduser'];
    try {
        // Actualizar el estado del curso
        $activar = $actions->updateData('usuarios', 'is_premium="0"', 'id', $idusuario);

        // Comprobar si se ha actualizado correctamente
        if ($activar) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'Estado del usuario Free');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo cambiar de suscripción al usuario');
        }
    } catch (\Throwable $th) {
        // Construir la respuesta de error en caso de excepción
        $response = array('success' => false, 'message' => 'Error al ejecutar activar curso: ' . $th->getMessage());
    }

    // Enviar la respuesta al frontend en formato JSON
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'updateprofile') {
    $name = $_POST["name"];
    $apellido = $_POST["apellido"];
    $telf = $_POST["telf"];
    $pass = $_POST["pass"];
    $passr = $_POST["passr"];
    $id = $_POST["id"];
    if ($pass != $passr) {
        $response = array(
            "success" => false,
            "message" => "Las contraseñas no coinciden intenta de nuevo",
        );
    } else {
        // actualizar datos where id
        // cifro las passwords
        $hd_pas1 = password_hash($pass, PASSWORD_DEFAULT);
        $hd_pas2 = password_hash($passr, PASSWORD_DEFAULT);
        $datas = array(
            "nombre" => $name,
            "apellido" => $apellido,
            "telf" => $telf,
            "password" => $hd_pas1,
            "repeat_password" => $hd_pas2
        );
        $actualizar = $actions->updateDataFun('usuarios', $datas, 'id', $id);
        if ($actualizar) {
            $response = array('success' => true, 'message' => 'Datos actualizados');
        } else {
            $response = array('success' => false, 'message' => 'Error al actualizar los datos');
        }

    }
    echo json_encode($response);
}

// update profile
if (isset($_POST['action']) && $_POST['action'] == 'updatefoto') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $id_user = $_POST['id'];
        try {
            $uploadedFile = $_FILES['imagen'];
            $fileName = $uploadedFile['name'];
            $fileTmpName = $uploadedFile['tmp_name'];
            $fileSize = $uploadedFile['size'];
            $fileType = $uploadedFile['type'];
            $extension_permitida = ['jpg', 'jpeg', 'png', 'webp'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $extension_permitida)) {
                $fecha_actual = date('YmdHis');
                $nuevo_nombre = 'IMGWSR' . $fecha_actual . '.' . $fileExtension;

                // Ruta de destino con el nuevo nombre
                $destino = '../assets/users/' . $nuevo_nombre;
                if (move_uploaded_file($fileTmpName, $destino)) {
                    //update here
                    $coms = array(
                        'imagen_profile' => $nuevo_nombre,
                    );
                    $actualizar = $actions->updateDataFun('usuarios', $coms, 'id', $id_user);
                    if ($actualizar) {
                        $response = array('success' => true, 'message' => 'Datos actualizados');
                    } else {
                        $response = array('success' => false, 'message' => 'Error al actualizar los datos');
                    }
                } else {
                    $response = array('success' => true, 'message' => 'No hemos podido mover el archivo');
                }
            } else {
                $response = array('success' => true, 'message' => 'Extensión no permitida');

            }
        } catch (\Throwable $th) {
            $response = array('success' => false, 'message' => 'No se ha cargado un archivo válido');
        }
    } else {
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido');
    }
    echo json_encode($response);
}
// anuncio con foto
if (isset($_POST['action']) && $_POST['action'] == 'newanuncio1') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $enlace = $_POST['enlace'];
        $userIdHtml = $_POST['userIdHtml'];
        try {
            $uploadedFile = $_FILES['imagen'];
            $fileName = $uploadedFile['name'];
            $fileTmpName = $uploadedFile['tmp_name'];
            $fileSize = $uploadedFile['size'];
            $fileType = $uploadedFile['type'];
            $extension_permitida = ['jpg', 'jpeg', 'png', 'webp'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $extension_permitida)) {
                $fecha_actual = date('YmdHis');
                $nuevo_nombre = 'IMGWSR' . $fecha_actual . '.' . $fileExtension;
                $fechadb = date('Y-m-d');
                // Ruta de destino con el nuevo nombre
                $destino = '../assets/anuncio/' . $nuevo_nombre;
                if (move_uploaded_file($fileTmpName, $destino)) {
                    //update here
                    $camposdb = 'imagen, titulo, descripcion, estado, enlace, id_user, fecha';
                    $val = "?, ?, ?, ?, ?, ?, ?";
                    $bind = "sssisis";
                    // insertdata
                    $data = array($nuevo_nombre, $titulo, $descripcion, $estado, $enlace, $userIdHtml, $fechadb);
                    $insert = $actions->postInsert('anuncio', $camposdb, $val, $bind, $data);
                    if ($insert) {
                        $response = array('success' => true, 'message' => 'Se a creado un nuevo anuncio');
                    } else {
                        $response = array('success' => false, 'message' => 'Error al crear anuncio');
                    }
                } else {
                    $response = array('success' => true, 'message' => 'No hemos podido mover el archivo');
                }
            } else {
                $response = array('success' => true, 'message' => 'Extensión no permitida');

            }
        } catch (\Throwable $th) {
            $response = array('success' => false, 'message' => 'No se ha cargado un archivo válido');
        }
    } else {
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido');
    }
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'newanuncio2') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $enlace = $_POST['enlace'];
    $userIdHtml = $_POST['userIdHtml'];
    try {
        $fecha_actual = date('YmdHis');
        $fechadb = date('Y-m-d');
        //update here
        $camposdb = ' titulo, descripcion, estado, enlace, id_user, fecha';
        $val = "?, ?, ?, ?, ?, ?";
        $bind = "ssisis";
        // insertdata
        $data = array($titulo, $descripcion, $estado, $enlace, $userIdHtml, $fechadb);
        $insert = $actions->postInsert('anuncio', $camposdb, $val, $bind, $data);
        if ($insert) {
            $response = array('success' => true, 'message' => 'Se a creado un nuevo anuncio');
        } else {
            $response = array('success' => false, 'message' => 'Error al crear anuncio');
        }
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'No se ha cargado un archivo válido');
    }

    echo json_encode($response);
}