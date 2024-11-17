<?php
$title = "Principal";
include('./page-master/head.php');
include "../conexion/Cursos.php";
$operations = new Cursos();
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    $get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
    $suscripcion = $get_user[0]['is_premium'];
}


$item1 = "border bg-gray-200";
$item2 = "";
$item3 = "";
$item4 = "";

?>


<body class="">
    <!-- Section: Design Block -->
   
    <div class="flex">
        <?php
        include('./components/sidebar.php');
        ?>
        <section class="z-[0] w-full">
            <div>
                <?php

                include('./components/menu.php');
                ?>
            </div>
            <section class="!bg-white  px-4 py-2">
                <p user-id="<?php echo trim($id_user) ?>" id="userIdHtml" hidden><?php echo trim($id_user) ?></p>
                <p user-id="<?php echo trim($id_user) ?>" id="suscrupcion" hidden><?php echo trim($suscripcion) ?></p>
                <div class="">
                    <div class="grid grid-cols-12 gap-4 py-8">
                        <!-- MENU -->
                        <div class="col-span-12">
                            <div class="">
                                <h2 class="text-2xl font-semibold mb-6 text-black">Cursos recomendados para ti</h2>
                                <div class="">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6 justify-center" id="data_cursos">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-span-12 lg:col-span-4 space-y-6 ">
                    <?php
                    //include('./components/profile.php'); 
                    ?>

                    <?php
                    // include('./components/dataCurso.php'); 
                    ?>

                    <?php
                    //include('./components/telegram.php'); 
                    ?>

                </div> -->
                    </div>
                </div>
            </section>
        </section>
    </div>


    <?php
    include_once('./page-master/js.php');
    ?>