<?php
$title = "Felicitaciones";

include('./page-master/head.php');
include "../conexion/Cursos.php";
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
if (isset($_GET['idc']) || !empty($_GET['idc'])) {
    $id_curso = $_GET['idc'];
} else {
     header("Location: " . $_SERVER['HTTP_REFERER']);

    exit();
}

$operations = new Cursos();
$get_completed = $operations->getData("completed");
$get_course = $operations->findCourseExist($id_curso);
if (!$get_course) {
    header("Location: ../dashboard");
}
$cursoTerminado = false; // Variable para verificar si el curso ya está terminado

// primero verificar si ese curso ya está en terminados 
// si no se encuentra lo insertamos
if (!empty($get_completed)) {
    foreach ($get_completed as $compleado) {
        $idCuCompletado = $compleado["id_curso"];
        $idUserCompletado = $compleado["id_usuario"];

        // Verifica si el curso ya está terminado para este usuario
        if ($idCuCompletado == $id_curso && $idUserCompletado == $id_user) {
            $cursoTerminado = true;
            break; // Sal del bucle si el curso ya está terminado para este usuario
        }
    }
}

// Si el curso no está terminado para este usuario, realiza la inserción
if (!$cursoTerminado) {
?>

    <body class="bg-white">
        <div class="container d-flex justify-content-center align-items-center h-100 ">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                <div class="row d-flex justify-content-center m-2 m-sm-4 m-md-5">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="./assets/img/3649568.png" alt="Imagen felicitaciones" loading="lazy" style="max-width: 220px;">
                    </div>
                    <div class="col-12 mt-4">
                        <h2 class="font-medium text-black text-center">¡Felicitaciones!</h3>
                    </div>
                    <div class="col-12">
                        <h4 class="text-2xl font-bold text-black text-center">
                            <?php
                            $get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
                            $data = $get_user[0]['nombre'] . " " . $get_user[0]['apellido'];
                            echo $data;
                            ?>
                        </h4>
                    </div>
                    <div class="col-12">
                        <p class="text-center text-black ">Nuestros cursos <strong class="text-black">se actualizan regularmente para mantenerte al día</strong>. Con tu membresía mensual, tendrás acceso completo a todos los cursos actualizados. Sabemos que el camino hacia el éxito puede ser desafiante, pero estamos aquí para apoyarte en cada paso del camino.</p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-base  font-normal ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py- 2" href="../dashboard">Continuar aprendiendo <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black"
                                    class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                    <path
                                        d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php
    $camposdb = "id_curso, id_usuario ";
    $val = "?, ?";
    $bind = "ii";
    $data = array($id_curso, $id_user);
    $completed_curso = $operations->postInsert("completed", $camposdb, $val, $bind, $data);
} else { ?>

    <body class="bg-white">
        <div class="container d-flex justify-content-center align-items-center h-100 ">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                <div class="row d-flex justify-content-center m-2 m-sm-4 m-md-5">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="./assets/img/3649568.png" alt="Imagen felicitaciones" loading="lazy" style="max-width: 220px;">
                    </div>
                    <div class="col-12 mt-4">
                        <h2 class="font-medium text-black text-center">¡Felicitaciones!</h3>
                    </div>
                    <div class="col-12">
                        <h4 class="text-2xl font-bold text-black text-center">
                            <?php
                            $get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
                            $data = $get_user[0]['nombre'] . " " . $get_user[0]['apellido'];
                            echo $data;
                            ?>
                        </h4>
                    </div>
                    <div class="col-12">
                        <p class="text-center text-black ">Nuestros cursos <strong class="text-black">se actualizan regularmente para mantenerte al día</strong>. Con tu membresía mensual, tendrás acceso completo a todos los cursos actualizados. Sabemos que el camino hacia el éxito puede ser desafiante, pero estamos aquí para apoyarte en cada paso del camino.</p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-base  font-normal ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py- 2" href="../dashboard">Continuar aprendiendo <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black"
                                    class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                    <path
                                        d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php }
