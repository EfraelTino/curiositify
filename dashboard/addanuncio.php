<?php
$title = "Nuevo anuncio ";
include('./page-master/head.php');
include "../conexion/Cursos.php";
session_start();

$operations = new Cursos();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
$item1 = "";
$item2 = "active";
$item3 = "";
$item4 = "";
$sql = $operations->getCamposConCondicion('usuarios', 'id', $id_user);
$statu_user = $sql[0]['is_admin'];
if (!$statu_user == 1 || !$statu_user == '1') {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
<style>
    .modal-backdrop {
        z-index: 11;
    }
</style>

<body>
    <!-- Section: Design Block -->
    
    <main class="relative z-10">
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
      "></div>
    <div style="
          content: '';
          background-image: url('https://assets.dub.co/misc/grid.svg');
          z-index: 1;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          opacity: 0.5;
          filter: invert(1);
        "></div>
        <div class="row m-0 p-0">
            <!-- MENU -->
            <?php
            include('./components/menu.php');
            ?>
            <!-- END MENU -->
        </div>

        <section class="container relative   z-10">
            <p user-id="<?php echo $id_user ?>" id="userIdHtml" style="color:black;" hidden>
                <?php echo $id_user ?>
            </p>
            <div class="row  h-100 p-3">
                <div class="col-12">
                    <div class="row w-100  bg- mb-4 p-2">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="text-2xl font-semibold leading-none text-black tracking-tight">
                                        Nuevo anuncio</h2>
                                </div>
                                <div class="col-6">
                                    <div class="flex justify-end relative z-10  px-3 mb-0">

                                        <a href="./cursos.php"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2 relative z-20   ">Regresar

                                        </a>
                                    </div>
                                    <?php include('./components/profile.php'); ?>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3 gap-5 w-full">

                                <div class="col-span-12 bg-white md:col-span-8 rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                                    <form enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2" onclick="addImage();">Incluir
                                                imagen</button>
                                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#15803d] text-white hover:bg-opacity-90 h-10 px-4 py-2" onclick="notImage();">Omitir imagen</button>
                                        </div>
                                        <div id="formdara">

                                        </div>
                                    </form>
                                </div>
                                <div class="col-span-12   bg-white  md:col-span-4 ">
                                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                                        <h2 class="text-2xl font-semibold leading-none text-black tracking-tight ">
                                            Anuncio actual</h2>
                                        <div class="border-alpha-400 bg-black relative rounded-xl border shadow-lg transition-colors p-3 mt-4">
                                            <?php
                                            $search_user = $operations->getCamposConCondicion("anuncio", "estado", "1 ORDER BY id DESC LIMIT 1");
                                            if (!empty($search_user)) {
                                            ?>
                                                <div class="row m-0">
                                                    <!-- MOSTRAR PERFIL USUARIO -->
                                                    <!-- FECHA -->
                                                    <div class="col-12 m-0 p-0">
                                                        <div class="row">
                                                            <?php
                                                            $id_int = $search_user[0]['id_user'];
                                                            $search_data = $operations->getCamposConCondicion("usuarios", "id", $id_int);
                                                            if (!empty($search_data)) {
                                                            ?>
                                                                <div class="col-3"><img src="./assets/users/<?php echo $search_data[0]['imagen_profile'] ?>" alt="Perfil"
                                                                        class="rounded-circle bg-prirncipal-s object-fit-cover foto-profile p-2 w-100" style="height:70px;">
                                                                </div>
                                                                <div class="col-9 d-flex flex-column justify-content-center">
                                                                    <div class="col-12 m-0 p-0">
                                                                        <small>
                                                                            <strong>
                                                                                <?php

                                                                                echo $search_data[0]["nombre"] . " " . $search_data[0]['apellido'];

                                                                                ?>
                                                                            </strong>
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-12 m-0">
                                                                        <small>
                                                                            <strong>Publicado: </strong> <?php echo $search_user[0]['fecha']; ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            } else {
                                                                echo "No se encontraron datos de usuarios para el ID especificado.";
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="row m-0">
                                                            <?php
                                                            if ($search_user[0]['imagen'] == '') {
                                                            ?>
                                                                <div class="col-12 m-0 p-0">
                                                                    <p>
                                                                        <strong class="text-danger">¡Anuncio!</strong>
                                                                    </p>
                                                                    <h3 class="fw-bolder">
                                                                        <?php echo $search_user[0]['titulo']; ?>
                                                                    </h3>
                                                                    <?php
                                                                    if ($search_user[0]['descripcion'] != '') {
                                                                        echo '<p>' . $search_user[0]["descripcion"] . '</p>';
                                                                    }
                                                                    ?>

                                                                </div>
                                                            <?php } else if ($search_user[0]['imagen'] != '') { ?>
                                                                <div class="col-12 m-0 p-0">
                                                                    <p>
                                                                        <strong class="text-danger">¡Anuncio!</strong>
                                                                    </p>
                                                                    <h3 class="fw-bold fs-4">
                                                                        <?php echo $search_user[0]['titulo']; ?>
                                                                    </h3>
                                                                </div>
                                                                <div class="col-6">
                                                                    <img src="./assets/anuncio/<?php echo $search_user[0]['imagen'] ?>"
                                                                        alt="Icono Usuario">
                                                                </div>

                                                            <?php
                                                                if ($search_user[0]['descripcion'] != '') {
                                                                    echo '<div class="col-6"><p><small>' . $search_user[0]["descripcion"] . '</small></p></div>';
                                                                }
                                                            }
                                                            ?>


                                                        </div>
                                                        <?php
                                                        if ($search_user[0]['enlace'] != '') {
                                                        ?>
                                                            <div class="row my-2 mt-4 m-0">
                                                                <a href="<?php echo $search_user[0]['enlace'] ?>"
                                                                    class="btn btn-warning" target="_blank">
                                                                    Ver más <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="black" class="bi bi-chevron-right"
                                                                        viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p class="m-0 text-center">
                                                    <strong class="text-danger ">Pronto nuevos anuncios...</strong>
                                                </p>
                                            <?php }
                                            ?>

                                        </div>
                                    </div>
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
    <script src="./js/students.js"></script>
</body>