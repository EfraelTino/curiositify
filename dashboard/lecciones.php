<?php
$title = "Lecciones";

include('./page-master/head.php');

include("./conexion/Pow.php");
session_start();
$operations = new Pow();
$ultima_vista = null;
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}


if (isset($_GET['idcr']) || !empty($_GET['idcr'])) {
    // 
    $id_curso = $_GET['idcr'];

    // primero traigo a la tabla enrollments con su campo id_usuario
    $get_enrrollments = $operations->getCamposConCondicion('enrollments', 'user_id', $id_user);

    if (count($get_enrrollments) <= 0) {
        // echo "Este usuario todavia no a visto esta leccion";
        $ultima_vista = 0;
    } else {
        end($get_enrrollments);
        $ultimo_elemento = current($get_enrrollments); // Obtener el último elemento
        $ultima_vista = $ultimo_elemento['ultima_leccion_vista_id'];
    }
    $tabla1 = "lecciones";
    $tabla2 = "cursos";
    $prepare = 'i';
    $condicion_tb1 = "id_curso";
    $condicion_tb2 = "id";
    $condicion = $id_curso;
    $get_curso = $operations->getJoinCamps($tabla1, $tabla2, $condicion, $prepare, $condicion_tb1, $condicion_tb2);
    if ($get_curso) {
        $orden = $get_curso[0]["orden"];
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
$item1 = "";
$item2 = "active";
$item3 = "";
$item4 = "";
?>
<?php
include('./page-master/js.php');

?>
<script src="./js/index.js"></script>

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
    <main class="relative z-10">
        <div class="row m-0 p-0">
            <!-- MENU -->
            <?php
            include('./components/menu.php');
            include('./components/profile.php');
            ?>
            <!-- END MENU -->
        </div>
        <section class="container pb-5">
            <div class="row flex justify-center">

                <div class="col-12 ">
                    <?php
                    if (!empty($get_curso)) {

                        $columnas = array_keys($get_curso[0]);
                        // var_dump($columnas);

                        $pos = 0;
                        foreach ($get_curso as $fila) {
                            $pos++;
                            $id_leccion = (int) $fila['id_leccion'];
                            $orden_es = $fila['orden'];
                            $estado = $fila['active'];
                            if (!$estado == '0' || !$estado == 0) {
                    ?>
                                <div class="row">
                                    <div class="col-12 mt-4">

                                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white">
                                            <div class="row justify-content-between align-items-center p-3">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                                    <div class="card-img w-100" style="overflow: hidden;">
                                                        <img src="./assets/img_leccion/<?php echo $fila['img_leccion'] ?>"
                                                            alt="<?php echo $fila['titulo']; ?>"
                                                            class="w-full md:h-[120px] md:w-[120px] rounded">
                                                    </div>
                                                </div>


                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-12 ">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-2">
                                                                    <h3 class="text-2xl font-semibold leading-none tracking-tight text-black">
                                                                        <?php echo $fila['titulo']; ?>
                                                                    </h3>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex align-items-center justify-content-start">
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
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-3 col-md-3 col-lg-1">
                                                    <?php


                                                    if (isset($ultima_vista)) {
                                                        // echo $ultima_vista;
                                                        $vista_convertida = (int) $ultima_vista;
                                                        $res_comstilta = $vista_convertida == (int) $id_leccion;
                                                        // echo $vista_convertida;
                                                        if ($ultima_vista == 0) {
                                                            $primera_leccion_id = $get_curso[0]['id_leccion'];
                                                            // Si $ultima_vista es 0, habilita solo el enlace de la primera lección
                                                            if ($pos == 1) {
                                                                echo '<p class="m-0 p-0"> <small class="text-[#eab308] bg-[#facc151a] border !border-[#eab308] rounded py-1 px-2  text-[0.75rem]">Pendiente</small> </p>';
                                                            } else {
                                                                echo '<p class="m-0 p-0"> <small class="text-[#eab308] bg-[#facc151a] border !border-[#eab308] rounded py-1 px-2  text-[0.75rem]">Pendiente</small> </p>';
                                                            }
                                                        } else if ($id_leccion <= $vista_convertida) {
                                                            // Recorrer todas las lecciones hasta la última lección vista
                                                            echo '<p class="m-0 p-0"> <small class="text-[#15803d] bg-[#22c55e1a] border !border-[#15803d] rounded py-1 px-2  text-[0.75rem]">Visto</small> </p>';
                                                        } else {
                                                            echo '<small class="text-[#eab308] bg-[#facc151a] border !border-[#eab308] rounded py-1 px-2  text-[0.75rem]">Pendiente</small> </p>';
                                                        }
                                                    }
                                                    ?>
                                                    <!-- <p>Visto</p> -->
                                                </div>

                                                <div class="col-6 col-sm-3 col-md-3 col-lg-2 d-flex justify-content-end">

                                                    <?php
                                                    // echo $pos;
                                                    if (isset($ultima_vista)) {
                                                        // echo $ultima_vista;
                                                        $vista_convertida = (int) $ultima_vista;
                                                        $res_comstilta = $vista_convertida == (int) $id_leccion;
                                                        // echo $vista_convertida;
                                                        if ($ultima_vista == 0) {
                                                            $primera_leccion_id = $get_curso[0]['id_leccion'];
                                                            // Si $ultima_vista es 0, habilita solo el enlace de la primera lección
                                                            if ($pos == 1) {
                                                                echo '<a class="inline-flex bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2  disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2" href="./verleccion.php?asd=' . $primera_leccion_id . '&eda=' . $id_curso . '&ord=' . $orden_es . '">Empezar</a>';
                                                            } else {
                                                                echo '<div class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-[#F3C623] text-black cursor-not-allowed	 bg-opacity-60 h-10 px-4 py-2" disabled>Pendiente</div>';
                                                            }
                                                        } else if ($id_leccion <= $vista_convertida) {
                                                            // Recorrer todas las lecciones hasta la última lección vista
                                                            echo '<a href="./verleccion.php?asd=' . $id_leccion . '&eda=' . $id_curso . '&ord=' . $orden_es . '" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#15803d] text-white hover:bg-opacity-90 h-10 px-4 py-2">Continuar</a>';
                                                        } else {
                                                            echo '<div class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-[#F3C623] text-black cursor-not-allowed bg-opacity-60 h-10 px-4 py-2" disabled>Pendiente</div>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo ' <h3 class="text-red-500 font-semibold text-center">Este curso aún no tiene lecciones</h3>';
                    }
                    ?>

                </div>

            </div>
        </section>
    </main>
    <script src="./js/index.js"></script>
    <?php
    include('./page-master/js.php');
    ?>

</body>