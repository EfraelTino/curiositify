<?php
session_start();
$title = "Cursos";

include('./page-master/head.php');
include "../conexion/Cursos.php";

$operations = new Cursos();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    $get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
    $suscripcion = $get_user[0]['is_premium'];
}

$item1 = "";
$item2 = "border bg-gray-200";
$item3 = "";
$item4 = "";
?>

<body >
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
    <main class="relative z-10>
        <div class="row m-0 p-0">
            <!-- MENU -->
            <?php
            include('./components/menu.php');
            ?>
            <!-- END MENU -->
        </div>
        <section >
            <p user-id="<?php echo $id_user ?>" id="userIdHtml" style="color:black;" hidden>
                <?php echo $id_user ?>
            </p>
            <div class="container">
                <div class="grid grid-cols-12 gap-4 py-8">

                    <div class="col-span-12 lg:col-span-8 ">

                        <div class="">


                            <h2 class="text-3xl font-bold mb-6 text-black">
                                Nuestros cursos </h2>


                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">

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
                                                    <a class="col-span-1"
                                                        href="./lecciones.php?idcr=<?php echo $fila['id'] ?>">


                                                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm flex flex-col">
                                                            <div class="flex flex-col space-y-1.5 p-6 relative z-10 bg-background-subtle rounded-lg bg-white">
                                                                <img class="card-img object-fit-cover rounded img-see titulo-curso mx-3 mt-3"
                                                                    src="./assets/img/<?php echo $fila['imagen_curso']; ?>"
                                                                    alt="CUARTO CURSO DE PRUEBA" style="width: 70px; height:50px;">
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
            <h3 class='text-center my-5 fw-bold text-danger'>No hay cursos disponibles</h3>
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
                                                    <a class="col-span-1"
                                                        href="./lecciones.php?idcr=<?php echo $free['id'] ?>">


                                                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm flex flex-col">
                                                            <div class="flex flex-col space-y-1.5 p-6 relative z-10 bg-background-subtle rounded-lg bg-white">
                                                                <img class="card-img object-fit-cover rounded img-see titulo-curso mx-3 mt-3"
                                                                    src="./assets/img/<?php echo $free['imagen_curso']; ?>"
                                                                    alt="CUARTO CURSO DE PRUEBA" style="width: 70px; height:50px;">
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
            <h3 class='text-center my-5 fw-bold text-danger'>No hay cursos disponibles</h3>
            ";
                                                }
                                            }
                                        } else {
                                            echo "
            <h3 class='text-center my-5 fw-bold text-danger'>No hay cursos disponibles</h3>
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
                    <div class="col-span-12 lg:col-span-4 space-y-4">
                        <?php include('./components/dataCurso.php'); ?>

                        <div class="">
                            <?php
                            if ($tipo_user == 1 || $tipo_user == '1') {
                                echo
                                '
                <div class="row m-0 p-0">
                    <a class="inline-flex mt-6 bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-4 text-white w-full text-xl " href="./cursos.php">Administar cursos
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
</svg>
                  </a>
                </div> 
                
';
                            }
                            ?>
                        </div>
                        <?php include('./components/profile.php'); ?>
                        <div class="">
                        </div>
                        <?php include('./components/telegram.php'); ?>

                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<?php
include('./page-master/js.php');

?>