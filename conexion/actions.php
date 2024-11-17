<?php
header('Content-Type: application/json');
include "./Cursos.php";
$actions = new Cursos();

if (isset($_POST['action']) && $_POST['action'] == "crearcuenta") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    if ($password != $repeat_password) {
        $response = array(
            "success" => false,
            "message"  => "Las contraseñas no coinciden intenta de nuevo",
        );
    } else {
        $buscar_email = $actions->getData("usuarios");
        $correo_indb = false;
        foreach ($buscar_email as $usuario) {
            if ($usuario['email'] === $correo) {
                $correo_indb = true;
                break;
            }
        }
        if ($correo_indb) {
            $response = array(
                "success" => false,
                "message" => "Este usuario ya se encuentra registrado, si olvidaste  tu contraseña lo puedes recuperar"
            );
        } else {


            // Hashear ambas contraseñas
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_repeat_password = password_hash($repeat_password, PASSWORD_DEFAULT);
            // pasamos los params a la funcion crear cuenta
            $camposdb = "nombre, apellido, email, password, repeat_password";
            $valores = "?, ?, ?, ?, ?";
            $bind = "sssss";
            $data_camp = array($nombre, $apellidos, $correo, $hashed_password, $hashed_repeat_password);
            $crear_cuenta = $actions->postInsert('usuarios', $camposdb, $valores, $bind, $data_camp);
            $response = array(
                "success" => true,
                "message" => $crear_cuenta
            );
            $response = array(
                "success" => true,
                "message" => "Registro satisfactorio"
            );
        }
    }
    $json_res = json_encode($response);
    echo $json_res;
}
if (isset($_POST['action']) && $_POST['action'] == "login") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $tabla = "usuarios";
    $campos = "id, email, password";
    $usuarios = $actions->getCamposSinCondicion($campos, $tabla);

    if (!$usuarios) {
        $response = array(
            "success" => false,
            "message" => "Error de inicio de sesión. Por favor, inténtalo de nuevo más tarde."
        );
    } else {
        $usuarioEncontrado = false;
        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                $usuarioEncontrado = true;
                $id_user= $usuario['id'];
                if (password_verify($pass, $usuario['password'])) {
                    session_start();
                    $_SESSION['usuario_autenticado'] = true;
                    $_SESSION['idusuario'] = $id_user;
                    $response = array(
                        "success" => true,
                        "message" => "¡Bienvenido a nuestra plataforma!"
                    );
                } else {
                    $response = array(
                        "success" => false,
                        "message" => "La contraseña ingresada es incorrecta."
                    );
                }
                break; // Sal del bucle una vez que se haya encontrado el usuario
            }
        }
        if (!$usuarioEncontrado) {
            $response = array(
                "success" => false,
                "message" => "No se encontró ningún usuario con la dirección de correo electrónico proporcionada."
            );
        }
    }

    $json_res = json_encode($response);
    echo $json_res;
}
