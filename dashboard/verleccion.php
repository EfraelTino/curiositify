<?php
$title = "Lecciones";
include "../conexion/Cursos.php";

include('./page-master/head.php');
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {

    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
$operations = new Cursos();

if (!isset($_GET['leccion']) || !isset($_GET['orden']) || !isset($_GET['curso'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../dashboard");
    }
    exit();
}

$leccion = $_GET['leccion'];
$orden = $_GET['orden'];
$curso = $_GET['curso'];

/// primero buscamos si el curso coincide con la leccion
$searchleccion = $operations->findLeccionExist($curso, $leccion);
if (!$searchleccion) {
    header("Location: ../dashboard");
}
$searchEnrollment = $operations->getLeccionCondicion($id_user, $curso, $leccion);

if (!$searchEnrollment) {
    $camposdb = "user_id, course_id, ultima_leccion_vista_id";
    $valores = "?, ?, ?";
    $bind = "iii";
    $data_camp = array($id_user, $curso, $leccion);
    $crear_cuenta = $operations->postInsert('enrollments', $camposdb, $valores, $bind, $data_camp);
}

?>


<body>
    <div style="
        width: 100vw;
        min-height: 100vh;
        position: fixed;
        top: 0px;
        z-index: 1;
        display: flex;
        justify-content: center;
        padding: 120px 24px 160px;
        pointer-events: none;
      ">
        <div style="
          content: '';
          z-index: 1;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          opacity: 0.5;
          filter: invert(1);
        "></div>
    </div>
    <p hidden id="cursoid"> <?php echo $curso ?></p>
    <p hidden id="userid"> <?php echo $id_user ?></p>
    <p hidden id="leccionid"> <?php echo $leccion ?></p>
    <main class="flex">
        <?php
        include "./components/sidebar.php";
        ?>
        <section class="w-full">
            <div class="">
                <?php
                include('./components/menu.php');
                ?>

            </div>
            <div class="!bg-white z-10 px-4 py-2 mb-20 md:mb-0">
                <div class="col-12 m-0 p-0">
                    <div class="row m-0 p-0">
                        <div class="col-12 m-0 p-0">
                            <div class="row m-0 p-0 ">
                                <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2 order-lg-1   p-auto ">
                                    <div class="rounded-lg border bg-white   py-4 bg-white">
                                        <div class="row m-0 p-0">
                                            <h1 class="text-xl font-semibold leading-none tracking-tight text-black">Lecciones:</h1>
                                        </div>

                                        <div class="!visible transition-opacity duration-150 bg-background text-foreground !opacity-100" style="visibility:hidden;opacity:0">
                                            <div class="max-w-md mx-auto px-4 pt-4">
                                                <ol id="leccionescnt" class="relative border-l-2  ">
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1 order-lg-2" id="renderclase">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include('./page-master/js.php');

    ?>
    <script src="./js/lecciondata.js"></script>

</body>