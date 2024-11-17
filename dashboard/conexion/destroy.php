<?php
session_start();

// Establecer variables de sesión
$_SESSION['usuario_autenticado'] = true;
$_SESSION['idusuario'] = $id_user;

// Destruir la sesión
session_destroy();

// Redirigir o realizar otras acciones después de destruir la sesión
// Por ejemplo, redirigir a otra página
header("Location: ../../");
exit(); // Asegura que el script se detenga después de la redirección
?>