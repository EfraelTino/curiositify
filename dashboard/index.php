<?php
$title = "Principal";
include('./page-master/head.php');
include "./conexion/Pow.php";
$operations = new Pow();
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    $get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
    $suscripcion = $get_user[0]['is_premium'];
}


$item1 = "active";
$item2 = "";
$item3 = "";
$item4 = "";

?>


<body class="">
    <!-- Section: Design Block -->
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
          background-image: url('https://assets.dub.co/misc/grid.svg');
          z-index: 1;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          opacity: 0.5;
          filter: invert(1);
        "></div>
  </div>
    <div class="row m-0 p-0">
        <?php
        include('./components/menu.php');
        ?>
    </div>
    <section class="">
        <p user-id="<?php echo trim($id_user) ?>" id="userIdHtml" hidden><?php echo trim($id_user) ?></p>
        <p user-id="<?php echo trim($id_user) ?>" id="suscrupcion" hidden><?php echo trim($suscripcion) ?></p>
        <div class="container">
            <div class="grid grid-cols-12 gap-4 py-8">
                <!-- MENU -->
                <div class="col-span-12 lg:col-span-8 ">
                    <div class="">
                        <h2 class="text-3xl font-bold mb-6 text-black">Disponibles</h2>
                        <div class="">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6 justify-center">

                                <?php

                                try {
                                    if ($suscripcion == 1 || $suscripcion == '1') {
                                        $tabla = "cursos";
                                        $data = $operations->getDataByOrderDescCu($tabla);

                                        if (!empty($data)) {
                                            foreach ($data as $fila) {
                                                // echo $id_user;
                                                $estado = $fila['activo'];
                                                if ($estado == 1 || $estado == '1') {
                                ?>
                                                    <a class="col-span-1 h-full"
                                                        href="./lecciones.php?idcr=<?php echo $fila['id'] ?>">


                                                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm flex flex-col">
                                                            <div class="flex flex-col space-y-1.5 p-6 relative z-10 bg-background-subtle bg-white rounded-lg">
                                                                <img class="object-cover w-full md:w-[70px] md:[50px]"
                                                                    src="./assets/img/<?php echo $fila['imagen_curso']; ?>"
                                                                    alt="CUARTO CURSO DE PRUEBA" >
                                                                <div class="card-body ">
                                                                    <h5 class="text-2xl font-semibold leading-none tracking-tight text-black">
                                                                        <?php echo $fila['titulo_curso'] ?>
                                                                    </h5>
                                                                    <p class="m-0 p-0">
                                                                        <?php
                                                                        $tabla = "usuarios";
                                                                        $cond = "id";
                                                                        $data = $fila['id_instructor'];
                                                                        $getInstructor = $operations->getCamposConCondicion($tabla, $cond, $data);
                                                                        if (!empty($getInstructor)) {
                                                                            foreach ($getInstructor as $filai) {
                                                                                echo "<span class='text-sm text-muted-foreground'>" . $filai['nombre'] . " " . $filai['apellido'] . "</span>";
                                                                            }
                                                                        } else {
                                                                            echo "<p class='text-sm text-muted-foreground'>No se encontró Instructor</p>";
                                                                        }
                                                                        ?>
                                                                    </p>
                                                                    <!-- <p class="card-text">Some quick example text to build on the card title
                                                                    and
                                                                    make
                                                                    up
                                                                    the bulk of the card's content.</p> -->

                                                                    <div class="inline-flex mt-6 bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full">Explorar</div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>

                                                <?php
                                                }
                                            }
                                        } else {
                                            echo "
                                            <h3 class='text-red-500 font-semibold text-center'>No hay cursos disponibles</h3>
                                            ";
                                        }
                                    } else {
                                        // mostrar solo cursos free
                                        $table = "cursos";
                                        $cursos = $operations->getDataByOrderDescCuFree($table);
                                        // var_dump($cursos);
                                        if (!empty($cursos)) {
                                            foreach ($cursos as $free) {
                                                $estado = $free['activo'];
                                                if ($estado == 1 || $estado == '1') {
                                                ?>
                                                    <a class="col-span-1 h-full"
                                                        href="./lecciones.php?idcr=<?php echo $free['id'] ?>">


                                                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm flex flex-col">
                                                            <div class="flex flex-col space-y-1.5 p-6 relative z-10 bg-background-subtle rounded-lg bg-white">
                                                                <img class="object-cover w-full md:w-[70px] md:[50px]"
                                                                    src="./assets/img/<?php echo $free['imagen_curso']; ?>"
                                                                    alt="CUARTO CURSO DE PRUEBA" >
                                                                <div class="card-body ">
                                                                    <h5 class="text-2xl font-semibold leading-none tracking-tight text-black">
                                                                        <?php echo $free['titulo_curso'] ?>
                                                                    </h5>
                                                                    <p class="m-0 p-0">
                                                                        <?php
                                                                        $tabla = "usuarios";
                                                                        $cond = "id";
                                                                        $data = $free['id_instructor'];
                                                                        $getInstructor = $operations->getCamposConCondicion($tabla, $cond, $data);
                                                                        if (!empty($getInstructor)) {
                                                                            foreach ($getInstructor as $filai) {
                                                                                echo "<span class='text-sm text-muted-foreground'>" . $filai['nombre'] . " " . $filai['apellido'] . "</span>";
                                                                            }
                                                                        } else {
                                                                            echo "<p class='text-sm text-muted-foreground'>No se encontró Instructor</p>";
                                                                        }
                                                                        ?>
                                                                    </p>

                                                                    <div class="inline-flex mt-6 bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full">Explorar</div>



                                                                </div>
                                                            </div>

                                                        </div>


                                                    </a>
                                <?php
                                                } else {
                                                    echo "
                                            <h3 class='text-red-500 font-semibold text-center'>No hay cursos disponibles</h3>
                                            ";
                                                }
                                            }
                                        } else {
                                            echo "
                                            <h3 class='text-red-500 font-semibold text-center'>No hay cursos disponibles</h3>
                                            ";
                                        }
                                    }
                                } catch (\Throwable $th) {
                                    echo $th;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0">
                        <div class="col-12">
                            <h2 class="my-2">Mis cursos</h2>
                        </div>
                        <div class="col-12">
                            <div class="flex justify-between md:justify-start gap-2">
                                <div class="col-auto">
                                    <button type="button" id="traerCursosBtn"
                                        class="inline-flex bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50   hover:bg-opacity-60 h-10 px-4 py-2 w-full text-white shadow-lg"
                                        data-id_user="<?php echo $id_user ?>"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="white" class="bi bi-check-square" fill="currentColor"
                                            viewBox="0 0 16 16" class="text-black">
                                            <path
                                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                            <path
                                                d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                        </svg>Todos </button>
                                </div>
                                <div class="col-auto"><button type="button"
                                id="favItem"
                                        onclick="traerCursoFav(<?php echo $id_user; ?>)"
                                        class="inline-flex w-full bg-white relative z-10 text-black shadow-lg border  w-full items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                                            class="bi bi-star" viewBox="0 0 16 16">
                                            <path
                                                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                                        </svg>
                                        Favoritos</button>
                                </div>
                 
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-4" id="cursosMostrar">
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-4 space-y-6 ">
                    <?php include('./components/profile.php'); ?>

                    <?php include('./components/dataCurso.php'); ?>

                    <?php include('./components/telegram.php'); ?>

                </div>
            </div>
        </div>
    </section>

    <?php
    include_once('./page-master/js.php');
    ?>