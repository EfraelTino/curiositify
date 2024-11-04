<?php
$title = "Lecciones";
include("./conexion/Pow.php");
include('./page-master/head.php');
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {

    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
$operations = new Pow();
// asd->idleciion
// eda->idcurso

// en el lado izquierdo mostrar las lecciones actualizados
// verificar que el id de la leccion coincida con uno de la base de datos y si no coincide ya mostramos una ventana de felicitaciones 
// si el id coincide actualizar la tabla de enrollments con un registro más
// comprar el id del usuario y el id de la lección destén en la misma fila
$next_leccion = null;
$prev_leccion = null;
if (!isset($_GET['asd']) || !empty($_GET['asd'])) {
    if (isset($_GET['eda']) && !empty($_GET['eda'])) {
        $id_lecion = $_GET['asd'];
        $id_curso = $_GET['eda'];
        $orden_cr = $_GET['ord'];
        // echo $orden_cr;
        // echo "ID DE LA LECION: " . $id_lecion;
        // echo "ID DE LA CURSO: " . $id_curso;
        //VALIDAR SI  
        // verificamos si este id leccio e id usuario están en enrollments
        $verificardata = $operations->getLeccionCondicion($id_user, $id_curso, $id_lecion);
        // para evitar hacer doble insercion comparar que el id generado no este en la base de datos
        if (count($verificardata) <= 0) {
            // validar que si no se encuentran campos se tiene que hacer un insert
            // echo "No se encontró a este usuario registrado a esta lección";
            $campos = 'user_id, course_id, ultima_leccion_vista_id';
            $valores = '?, ?, ?';
            $bind = 'iii';
            $datacamp = array((int) $id_user, (int) $id_curso, (int) $id_lecion);
            $insert_enrrollments = $operations->postInsert('enrollments', $campos, $valores, $bind, $datacamp);
        }
        $tabla1 = "lecciones";
        $tabla2 = "cursos";
        $prepare = 'i';
        $condicion_tb1 = "id_curso";
        $condicion_tb2 = "id";
        $condicion = $id_curso;
        $get_curso = $operations->getJoinCamps($tabla1, $tabla2, $condicion, $prepare, $condicion_tb1, $condicion_tb2);
        foreach ($get_curso as $curso_encontrad) {
            $orden = $curso_encontrad["orden"];
            $estadocurso = $curso_encontrad['active'];
            // Si el estado del curso es 1, pasa al curso previo si la lección es anterior a la actual y el orden es menor que el actual.
            if ($estadocurso == 1 && $curso_encontrad['id_leccion'] < $id_lecion && $orden < $orden_cr) {
                $prev_leccion = $curso_encontrad;
                $prev_orden = $orden;
            }

            // Si el estado del curso es 0, continúa con el siguiente curso.
            if ($estadocurso == 0)
                continue;

            // Si el estado del curso es 1, pasa al siguiente curso si la lección es posterior a la actual y el orden es mayor que el actual.
            if ($estadocurso == 1 && $curso_encontrad['id_leccion'] > $id_lecion && $orden > $orden_cr) {
                $next_leccion = $curso_encontrad;
                $next_orden = $orden;
                break;
            }
        }
    } else {
        echo "no hay curso";
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


<body class="bg-white">
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
        <section class="container flex justify-center">
            <div class="row mt-8">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="row ">
                                <!-- lista de cursos -->

                                <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2 order-lg-1   p-auto ">
                                    <div class="rounded-lg border bg-white text-card-foreground shadow-sm mb-4 py-4 bg-white">
                                        <div class="row m-0 p-0">
                                            <h1 class="text-2xl font-semibold leading-none tracking-tight text-black">Lecciones:</h1>
                                        </div>
                                        <?php
                                        try {
                                            foreach ($get_curso as $leccion) {
                                                $estado = $leccion['active'];
                                                if ($estado == '0' || $estado == 0) {
                                                    // return;
                                                } else {
                                        ?>
                                                    <div class="row  m-0 p-0">
                                                        <div class="col-12 my-1">
                                                            <div class="rounded-lg grid grid-cols-8 border bg-card text-card-foreground shadow-sm">
                                                                <div class="col-span-2  m-0 p-0">
                                                                    <div>
                                                                        <img src="./assets/img_leccion/<?php echo $leccion['img_leccion']; ?>"
                                                                            alt="<?php echo $leccion['titulo_curso']; ?>"
                                                                            class="h-[80px] w-[80px] object-cover rounded">
                                                                    </div>
                                                                </div>
                                                                <div class="col-span-6 d-flex align-items-center">
                                                                    <div class="row m-0 p-0">
                                                                        <div class="col-12 d-flex align-items-center">
                                                                            <h3 class="text-lg font-semibold leading-none tracking-tight text-black">
                                                                                <?php echo $leccion['titulo']; ?>
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        <?php }
                                            }
                                        } catch (Exception $e) {
                                            echo $operations->getDbConnect() . "<p>Ocurrió un error:</p>" . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- video actual -->
                                <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1 order-lg-2  ">
                                    <div class="rounded-lg border bg-white text-card-foreground shadow-sm mb-4">
                                        <div class="">
                                            <?php
                                            foreach ($get_curso as $leccion) {

                                                if ($id_lecion == $leccion['id_leccion']) {
                                            ?>
                                                    <div class="col-12">
                                                        <div class="row m-0 p-0 ">
                                                            <div class="relative rounded-xl overflow-auto p-2 md:p-4">
                                                                <?php
                                                                $video_url = $leccion['video_url'];

                                                                if (strpos($video_url, 'watch?v=') !== false) {
                                                                    parse_str(parse_url($video_url, PHP_URL_QUERY), $query);
                                                                    $video_id = $query['v'];
                                                                    $embed_url = "https://www.youtube.com/embed/" . $video_id;
                                                                } else {
                                                                    $embed_url = $video_url;
                                                                }
                                                                ?>

                                                                <iframe class="w-full aspect-video rounded-md"
                                                                    src="<?php echo $embed_url; ?>"
                                                                    frameborder="0"
                                                                    allow="autoplay; fullscreen"
                                                                    allowfullscreen></iframe>

                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="grid grid-cols-12 px-2 md:px-4 pb-4 pt-2">
                                            <div class="col-span-12 md:col-span-6 mt-3 d-flex align-items-center">
                                                <h3 class="text-lg md:text-2xl font-bold text-black">
                                                    <?php
                                                    foreach ($get_curso as $leccion2) {
                                                        if ($id_lecion == $leccion2['id_leccion']) {
                                                            echo $leccion2['titulo'];
                                                        }
                                                    }
                                                    ?>
                                                </h3>
                                            </div>
                                            <div class="col-span-12 md:col-span-6 mt-3">
                                                <div class="row m-0 p-0">
                                                    <?php
                                                    if ($prev_leccion !== null) {
                                                        echo '<div class="col-6 m-0 p-0 justify-content-start">';
                                                        echo "<a class='inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#15803d] text-white hover:bg-opacity-90 h-10 px-4 py-2' href='./verleccion.php?asd=" . $prev_leccion['id_leccion'] . "&eda=" . $prev_leccion['id_curso'] . "&ord=" . $prev_orden . "'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' class='bi bi-chevron-left' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0'/>
                                                  </svg> <span class='text-white hidden md:flex'> Anterior</span></a>";
                                                        if ($prev_leccion['id_leccion'] === $id_lecion) {
                                                            echo "<a class='btn btn-warning' href='./verleccion.php?asd=" . $prev_leccion['id_leccion'] . "&eda=" . $prev_leccion['id_curso'] . "&ord=" . $prev_orden . "'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-chevron-left' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0'/>
                                                      </svg> <span class='text-black hidden md:flex'>Anterior</span> </a>";
                                                        }

                                                        echo '</div>';
                                                    }
                                                    if ($prev_leccion === null) {
                                                        echo "<div class='col-12 m-0 p-0 d-flex justify-content-between'>
                                                    <p class='inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black cursor-not-allowed	 bg-opacity-50 h-10 px-4 py-2' disabled href='#'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-chevron-left' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0'></path>
                                                  </svg>
                                                        <span class='hidden md:flex text-black'>Anterior</span>
                                                        </p> 
                                                        <a class='inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2' href='./verleccion.php?asd=" . $next_leccion['id_leccion'] . "&eda=" . $next_leccion['id_curso'] . "&ord=" . $next_orden . "'> <span class='hidden md:flex text-black'>Siguiente</span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-chevron-right' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708'/>
                                                        </svg></a></div>
                                                        ";
                                                    } else if ($next_leccion !== null) {
                                                        echo '<div class="col-6 m-0 p-0 d-flex justify-content-end">';
                                                        echo "<a class='inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2' href='./verleccion.php?asd=" . $next_leccion['id_leccion'] . "&eda=" . $next_leccion['id_curso'] . "&ord=" . $next_orden . "'> <span class='hidden md:flex text-black'>Siguiente</span> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-chevron-right' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708'/>
                                                    </svg></a></div>";
                                                    } else {
                                                        echo "<div class='col-6 m-0 p-0 d-flex justify-content-end'><a class='inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2' href='./felicitaciones.php?idc=" . $id_curso . "'><span class='hidden md:flex text-black'>Siguiente</span>  <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-chevron-right' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708'/>
                                                    </svg></a> <div>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
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
    <script src="./js/index.js"></script>

</body>