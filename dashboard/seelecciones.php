<?php
$title = "Lección";

include('./page-master/head.php');
include "../conexion/Cursos.php";

session_start();
$operations = new Cursos();
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
    $camp = "orden";
    $st = 'ASC';
    $get_curso = $operations->getJoinCampsOrder($tabla1, $tabla2, $condicion, $prepare, $condicion_tb1, $condicion_tb2, $camp, $st);
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
$item1 = "";$item2 = "border bg-gray-200";

$item3 = "";
$item4 = "";
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
            <div class="container py-10 mx-auto">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 md:col-6">
                            <h2 class="text-lg md:text-2xl font-bold mb-2 md:mb-5 text-black">
                                Lecciones registrados
                            </h2>
                        </div>
                        <div class="col-12 md:col-6">
                            <div class="flex justify-end gap-2 items-center  px-3 mb-0">
                                <div>
                                    <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2"
                                        href="./cursos"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"></path>
                                        </svg>Atrás

                                    </a>
                                </div>
                                <div>
                                    <a class="inline-flex bg-black text-white  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2"
                                        href="./addlecion?idcr=<?php echo $id_curso ?>">Nueva lección
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                            <?php include('./components/profile.php'); ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-6">
                            <div class="flex mt-4 items-center gap-2">

                                <label for="num_registros" class="text-black"><strong class="text-black">Mostrar:</strong></label>

                                <select name="num_registros" id="num_registros"
                                    class=" h-10 rounded-md border border-input bg-background  px-1 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-black">
                                    <option class="text-black" value="10" class="text-white">10</option>
                                    <option class="text-black" value="25">25</option>
                                    <option class="text-black" value="50">50</option>
                                </select>


                                <label for="num_registros" class="text-black">Registros</label>

                            </div>
                        </div>
                        <div class="col-span-6">

                        </div>
                    </div>
                    <div class="grid grid-cols-12 bg-white mb-5 mt-3 border rounded-lg shadow-lg">
                        <div class="relative col-span-12 w-full overflow-auto">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&_tr]:border-b">
                                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"></tr>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600 text-center">#</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Imagen</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Nombre de la lección</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Estado</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Encargado</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Orden</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Vista previa</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($get_curso)) {

                                        $columnas = array_keys($get_curso[0]);
                                        $pos = 0;
                                        foreach ($get_curso as $fila) {
                                            $pos++;
                                            $id_leccion = (int) $fila['id_leccion'];
                                    ?>
                                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"></tr>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <p class="text-center text-black font-bold">
                                                    <?php echo $pos; ?>
                                                </p>
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <img class="object-cover rounded"
                                                    src="./assets/img_leccion/<?php echo $fila['img_leccion'] ?>"
                                                    alt="<?php echo $fila['titulo']; ?>" style="width:50px;">
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <p class="text-black">
                                                    <?php echo $fila['titulo']; ?>
                                                </p>
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <p id="estadoleccion-<?php echo $id_leccion ?>" class="text-black">
                                                    <?php echo $fila['active'] == 1 ? 'Activo' : 'Desactivo' ?>
                                                </p>
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <p class="text-black">
                                                    <?php
                                                    $tabla = "usuarios";
                                                    $cond = "id";
                                                    $data = $fila['id_instructor'];
                                                    $getInstructor = $operations->getCamposConCondicion($tabla, $cond, $data);
                                                    if (!empty($getInstructor)) {
                                                        foreach ($getInstructor as $filai) {
                                                            echo $filai['nombre'] . " " . $filai['apellido'];
                                                        }
                                                    } else {
                                                        echo "No se encontró Instructor";
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <p class="text-black">
                                                    <?php echo $fila['orden']; ?>
                                                </p>
                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <a href="<?php echo $fila['video_url'] ?>" target="_blank">
                                                    Ver vídeo
                                                </a>


                                            </td>
                                            <td class="p-4 align-middle text-black font-medium">
                                                <div class="flex justify-start gap-2">
                                                    <div class="flex  items-center">
                                                        <a class="text-black text-2xl p-1 bg-green-400 rounded"
                                                            href="./editleccion?idl=<?php echo $id_leccion ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="black" class="bi bi-pencil-square"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                                                </path>
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="flex  items-center">
                                                        <button class="text-black text-2xl p-1 bg-red-500 rounded " onclick="deleteLeccion(<?php echo  $id_leccion ?>)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3-fill"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="flex  items-center"
                                                        id="item_estado-<?php echo $id_leccion ?>">
                                                        <?php
                                                        echo $fila['active'] == '1' ? '<button onclick="powerLeccion(' . $id_leccion . ',' . $fila['active'] . ')" class="p-1 text-xl rounded bg-amber-400" href="">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                                                                <path d="M7.5 1v7h1V1z" />
                                                                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                                            </svg>
                                                        </button>' : '<button onclick="powerLeccion(' . $id_leccion . ',' . $fila['active'] . ')" class="p-1 text-xl rounded bg-amber-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                                                            <path d="M7.5 1v7h1V1z" />
                                                            <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                                        </svg>
                                                    </button>';
                                                        ?>
                                                    </div>

                                                </div>
                                            </td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>


                    <?php
                                    } else {
                                        echo ' <h3 class="text-center font-semibold text-xl">No se econtraron cursos</h3>';
                                    }
                    ?>

                    </div>

                </div>
            </div>
        </section>
    </main>
    <?php
    include('./page-master/js.php');

    ?>
    <script src="./js/lecciones.js"></script>
</body>