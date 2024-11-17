<?php
header('Content-Type: application/json');
include "../../conexion/Cursos.php";
$actions = new Cursos();

if (isset($_POST["action"]) && $_POST["action"] == "searchcouser") {
    $dataUrl = $_POST["searchData"];
    $getCurso = $actions->searchCurso($dataUrl);

    if (!$getCurso) {
        $response = array("success" => false, "message" => "No se ha encontrado ningún curso");
    } else {
        $cursos = array();
        foreach ($getCurso as $curso) {
            $cursoObjeto = array(
                "id" => $curso["id"],
                "titulo_curso" => $curso["titulo_curso"],
                "imagen_curso" => $curso["imagen_curso"]
            );
            $cursos[] = $cursoObjeto;
        }
        $response = array("success" => true, "message" => $cursos);
    }

    echo json_encode($response);
}

if (isset($_POST["action"]) && $_POST["action"] == "traercursos") {
    $table = 'cursos';
    $seeCursos = $actions->getDataByOrderDescCu($table);
    if (!$seeCursos) {
        $response = array("success" => false, "message" => "No se ha encontrado ningún cursos");
    } else {
        $cursos = array();
        foreach ($seeCursos as $curso) {
            $cursoObjeto = array(
                "id" => $curso["id"],
                "titulo_curso" => $curso["titulo_curso"],
                "imagen_curso" => $curso["imagen_curso"],
            );
            $cursos[] = $cursoObjeto;
        }
        $response = array("success" => true, "message" => $cursos);
    }
    echo json_encode($response);
}
if (isset($_POST["action"]) && $_POST["action"] == "traercursosfree") {
    $table = 'cursos';
    $seeCursos = $actions->getDataByOrderDescCuFree($table);
    if (!$seeCursos) {
        $response = array("success" => false, "message" => "No se ha encontrado ningún cursos");
    } else {
        $cursos = array();
        foreach ($seeCursos as $curso) {
            $cursoObjeto = array(
                "id" => $curso["id"],
                "titulo_curso" => $curso["titulo_curso"],
                "imagen_curso" => $curso["imagen_curso"],
            );
            $cursos[] = $cursoObjeto;
        }
        $response = array("success" => true, "message" => $cursos);
    }
    echo json_encode($response);
}

if (isset($_POST["action"]) && $_POST["action"] == "cursofav") {
    $id_user = $_POST['idUser'];
    $cursos = array();
    try {
        $get_fav = $actions->getCursoFav($id_user);
        if (!$get_fav) {
            $response = array('success' => false, 'message' => 'Aún no tienes cursos favoritos');
        } else {
            $cursos = array();

            foreach ($get_fav as $curso) {
                $cursoObjeto = array(
                    "id" => $curso["id"],
                    "titulo_curso" => $curso["titulo_curso"],
                    "imagen_curso" => $curso["imagen_curso"],
                    "idCurso" => $curso["id_curso"],
                );
                $cursos[] = $cursoObjeto;
            }
        }
        $response = array('success' => true, "message" => $cursos);
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al obtener los cursos favoritos: ' . $th->getMessage());
        echo json_encode($response);
    }
}
if (isset($_POST['action']) && $_POST['action'] == "addfav") {
    $id_curso = $_POST['idCurso'];
    $id_user = $_POST['idUser'];
    try {
        $camposdb = "id_curso, id_usuario";
        $valores = "?, ?";
        $bid = "ii";
        $data = array($id_curso, $id_user);
        $insert_curso = $actions->postInsert('fav', $camposdb, $valores, $bid, $data);
        $response = array(
            "success" => true,
            "message" => ($insert_curso) ? "El curso se a agregado a favoritos" : "Error al insertar el curso favorito"
        );
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al obtener los cursos favoritos: ' . $th->getMessage());
        echo json_encode($response);
    }
}



// cursos terminados
if (isset($_POST['action']) && $_POST['action'] == 'getcompletedcurso') {
    $iduser = $_POST['iduser'];
    $cursos = array();
    try {
        $tabla = "completed";
        $condicion = "id_usuario";
        $data = $iduser;
        $get_completed = $actions->getCamposConCondicion($tabla, $condicion, $data);
        if (!$get_completed) {
            $response = array('success' => false, 'message' => 'No tienes cursos completos');
        } else {
            foreach ($get_completed as $curso) {
                $cursoObjeto = array(
                    "id" => $curso["id"]
                );
                $cursos[] = $cursoObjeto;
            }
        }
        $response = array("success" => true, "message" => $cursos);
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al obtener cursos completados: ' . $th->getMessage());
        echo json_encode($response);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'activarCurso') {
    $idcurso = $_POST['idCurso'];
    try {
        // Actualizar el estado del curso
        $activar = $actions->updateData('cursos', 'activo="1"', 'id', $idcurso);

        // Comprobar si se ha actualizado correctamente
        if ($activar) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'El curso se activó correctamente');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo activar el curso');
        }
    } catch (\Throwable $th) {
        // Construir la respuesta de error en caso de excepción
        $response = array('success' => false, 'message' => 'Error al  activar curso: ' . $th->getMessage());
    }

    // Enviar la respuesta al frontend en formato JSON
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'activarleccion') {
    $id_leccion = $_POST['idleccion'];
    try {
        $activ_leccion = $actions->updateData('lecciones', 'active="1"', 'id_leccion ', $id_leccion);
        // Comprobar si se ha actualizado correctamente
        if ($activ_leccion) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'La lección se activó correctamente');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo activar la lección');
        }
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al activar lección: ' . $th->getMessage());
        echo json_encode($response);
    }
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'desactivarCurso') {
    $idcurso = $_POST['idCurso'];
    try {
        // Actualizar el estado del curso
        $activar = $actions->updateData('cursos', 'activo="0"', 'id', $idcurso);

        // Comprobar si se ha actualizado correctamente
        if ($activar) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'El curso se activó correctamente');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo activar el curso');
        }
    } catch (\Throwable $th) {
        // Construir la respuesta de error en caso de excepción
        $response = array('success' => false, 'message' => 'Error al ejecutar activar curso: ' . $th->getMessage());
    }

    // Enviar la respuesta al frontend en formato JSON
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'desactivarleccion') {
    $idleccion = $_POST['idleccion'];
    try {
        // Actualizar el estado del curso
        $activar = $actions->updateData('lecciones', 'active="0"', 'id_leccion', $idleccion);

        // Comprobar si se ha actualizado correctamente
        if ($activar) {
            // Construir la respuesta exitosa
            $response = array('success' => true, 'message' => 'La lección se activó correctamente');
        } else {
            // Construir la respuesta de error
            $response = array('success' => false, 'message' => 'No se pudo activar la lección');
        }
    } catch (\Throwable $th) {
        // Construir la respuesta de error en caso de excepción
        $response = array('success' => false, 'message' => 'Error al ejecutar activar lección: ' . $th->getMessage());
    }

    // Enviar la respuesta al frontend en formato JSON
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'updatecourse') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Se ha enviado un archivo y no hay errores en la subida
        $imagen = $_FILES['imagen'];
        $nombre = $_POST['nombre'];
        $instructor = $_POST['instructor'];
        $idcurso = $_POST['idcurso'];
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
                // Concatenar el prefijo, la fecha actual y la extensión del archivo
                $nuevo_nombre = 'IMGWSR' . $fecha_actual . '.' . $fileExtension;
                // Ruta de destino con el nuevo nombre
                $destino = '../assets/img/' . $nuevo_nombre;
                if (move_uploaded_file($fileTmpName, $destino)) {
                    $update_curso = $actions->updateCurso($nombre, $nuevo_nombre, $instructor, $idcurso);
                    if ($update_curso) {
                        $response = array('success' => true, 'message' => 'El curso se a actualizado correctamente');
                    } else {
                        $response = array('success' => false, 'message' => 'Error al actualizar el curso');
                    }
                } else {
                    $response = array('success' => true, 'message' => 'No hemos podido mover el archivo');
                }
            } else {
                $response = array('success' => true, 'message' => 'Extensión no permitida');
            }
        } catch (\Throwable $th) {
            $response = array('success' => false, 'message' => 'Error al ejecutar activar curso: ' . $th->getMessage());
        }
        echo json_encode($response);
    } else {
        // No se ha enviado un archivo o hay errores en la subida
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido');
        echo json_encode($response);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'newcurso') {
    try {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
            $nombre = $_POST['nombre'];
            $instructor = $_POST['instructor'];
            $tipo = $_POST['tipo'];
            $estado = $_POST['estado'];
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
                    // Concatenar el prefijo, la fecha actual y la extensión del archivo
                    $nuevo_nombre = 'IMGWSR' . $fecha_actual . '.' . $fileExtension;
                    $fechadb = date('Y-m-d');
    
                    // Ruta de destino con el nuevo nombre
                    $destino = '../assets/img/' . $nuevo_nombre;
                    if (move_uploaded_file($fileTmpName, $destino)) {
                        // insertar acá{
                        $camposdb = 'titulo_curso, imagen_curso, id_instructor, fecha_creacion, activo, is_free';
                        $val = "?, ?, ?, ?, ?, ?";
                        $bind = "ssisii";
                        $data = array($nombre, $nuevo_nombre, $instructor, $fechadb, $estado, $tipo);
                        $insert = $actions->postInsert('cursos', $camposdb, $val, $bind, $data);
                        $response = array(
                            "success" => true,
                            "message" => ($insert) ? "El curso  se a creado satisfacctoriamente" : "Error al crear el curso"
                        );
                    } else {
                        $response = array('success' => true, 'message' => 'No hemos podido mover el archivo');
                    }
                } else {
                    $response = array('success' => true, 'message' => 'Extensión no permitida');
                }
            } catch (\Throwable $th) {
                $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido'. $th);
            }
        } else {
            // No se ha enviado un archivo o hay errores en la subida
            $response = array('success' => false, 'message' => 'No se ha enviado un archivo válidoo');
        }
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => $th);

    }
    echo json_encode($response);

}
if (isset($_POST['action']) && $_POST['action'] == 'newleccion') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $id_curso = $_POST['idcurso'];
        $orden = $_POST['ordenleccion'];
        $imagen = $_FILES['imagen'];
        $nombre = $_POST['nombre'];
        $video_url = $_POST['video_url'];
        $estado = $_POST['estado'];
        $descripcion = $_POST['descripcion'];
        
        $sql_s_o = $actions->getLeccionOrden($id_curso, $orden);
        
        if (!$sql_s_o) {
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
                    $nuevo_nombre = 'z' . $fecha_actual . '.' . $fileExtension;
                    $fechadb = date('Y-m-d');
                    $destino = '../assets/img_leccion/' . $nuevo_nombre;
                    
                    if (move_uploaded_file($fileTmpName, $destino)) {
                        $camposdb = 'id_curso, titulo, video_url,  orden, active, img_leccion, descripcion	';
                        $val = "?, ?, ?, ?, ?, ?, ?";
                        $bind = "issiiss";
                        $data = array($id_curso, $nombre, $video_url, $orden, $estado, $nuevo_nombre, $descripcion);
                        $insert = $actions->postInsert('lecciones', $camposdb, $val, $bind, $data);
                        
                        $response = array(
                            "success" => true,
                            "message" => ($insert) ? "Se a agregado la lección al curso" : "Error al agregar lección"
                        );
                    } else {
                        $response = array('success' => false, 'message' => 'No hemos podido mover el archivo');
                    }
                } else {
                    $response = array('success' => false, 'message' => 'Extensión no permitida');
                }
            } catch (\Throwable $th) {
                $response = array('success' => false, 'message' => 'Error al procesar el archivo: ' . $th->getMessage());
            }
        } else {
            $response = array('success' => false, 'message' => 'Este número de orden ya se encuentra en uso');
        }
    } else {
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido o hay un error en la subida');
    }
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == 'updateleccion') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Se ha enviado un archivo y no hay errores en la subida

        // primero busqueda de la leccion con orden idleccion y idcurso que si no están en la misma fila no se proceda
        $cursoidhtml = $_POST['idcursohtml'];
        $imagen = $_FILES['imagen'];
        $name = $_POST['nombre'];
        $video_url = $_POST['video_url'];
        $descripcion = $_POST['descripcion'];
        $idleccionhtml = $_POST['idleccionhtml'];
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
                // Concatenar el prefijo, la fecha actual y la extensión del archivo
                $nuevo_nombre = 'IMGWSR' . $fecha_actual . '.' . $fileExtension;
                // Ruta de destino con el nuevo nombre
                $destino = '../assets/img_leccion/' . $nuevo_nombre;
                if (move_uploaded_file($fileTmpName, $destino)) {
                    $update_curso = $actions->updateLeccion($name, $nuevo_nombre, $video_url, $descripcion,$idleccionhtml);
                    if ($update_curso) {
                        $response = array('success' => true, 'message' => 'La lección se a actualizado correctamente');
                    } else {
                        $response = array('success' => false, 'message' => 'Error al actualizar la lección');
                    }
                } else {
                    $response = array('success' => true, 'message' => 'Error al procesar la imagen');
                }
            } else {
                $response = array('success' => true, 'message' => 'Formato no permitido');
            }
        } catch (\Throwable $th) {
            $response = array('success' => false, 'message' => 'Error al actualizar la lección: ' . $th->getMessage());
        }
        echo json_encode($response);
    } else {
        // No se ha enviado un archivo o hay errores en la subida
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido');
        echo json_encode($response);
    }
}
// Aquí comienza el código principal
if (isset($_POST['action']) && $_POST['action'] == 'deleteleccion') {
    $leccionid = $_POST['id'];
    try {
        // Llamada a la función deletedata
        $delete = $actions->deletedata('lecciones', 'id_leccion', $leccionid);
        if ($delete) {
            $response = array('success' => true, 'message' => 'Se ha eliminado la lección');
        } else {
            $response = array('success' => false, 'message' => 'Errors al eliminar la lección');
        }
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al eliminar la lección: ' . $th->getMessage());
        echo json_encode($response);
    }
}
if (isset($_POST["action"]) && $_POST["action"] == "getcomentarios") {
    try {

        $table = 'sugerencia';
        $seeCursos = $actions->getData($table);

        if (!$seeCursos) {
            $response = array("success" => false, "message" => "No se ha encontrado ningún comentario");
        } else {
            $response = array("success" => true, "message" => $seeCursos);
        }
    } catch (\Throwable $th) {
        $response = array("success" => false, "data" => $th);
    }
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == "addcomentario") {
    $id_curso = $_POST['comentario'];
    try {
        $camposdb = "sugerencia";
        $valores = "?";
        $bid = "s";
        $data = array($id_curso);
        $insert_curso = $actions->postInsert('sugerencia', $camposdb, $valores, $bid, $data);
        $response = array(
            "success" => true,
            "message" => ($insert_curso) ? "El curso se a agregado a favoritos" : "Error al insertar el curso favorito"
        );
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = array('success' => false, 'message' => 'Error al obtener los cursos favoritos: ' . $th->getMessage());
        echo json_encode($response);
    }
}
