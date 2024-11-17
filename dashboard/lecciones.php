<?php
$title = "Lecciones";

include "./page-master/head.php";

include "../conexion/Cursos.php";

session_start();

$operations = new Cursos();
if (empty($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
}

$id_user = $_SESSION['idusuario'];

$id_curso = $_GET['idcr'] ?? null;
if (empty($id_curso)) {
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../dashboard'));
    exit;
}

$getcurso = $operations->findCourse($id_curso);
if (!$getcurso) {
    header("Location: ../dashboard");
    exit;
}

$item1 = "";
$item2 = "";
$item3 = "";
$item4 = "";
?>
<?php
include('./page-master/js.php');

?>
<script src="./js/index.js"></script>

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
    <div class="flex">
        <?php
        include "./components/sidebar.php";
        ?>
        <section class="w-full">
            <div class="">
                <?php
                include('./components/menu.php');
                ?>
            </div>
            <div class="!bg-white z-10 px-4 py-4 mb-20 md:mb-0">


                <div id="leccionescnt" class="space-y-4">

                </div>
            </div>
        </section>
        <p hidden id="cursoid"> <?php echo $id_curso ?></p>
        <p hidden id="userid"> <?php echo $id_user ?></p>
    </div>
    <script src="./js/leccion.js"></script>
    <?php
    include('./page-master/js.php');
    ?>

</body>