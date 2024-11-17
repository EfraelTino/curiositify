<?php
session_start();
$title = "Todos los cursos";
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {

    header("Location: ../login");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}



include('./page-master/head.php');
include "../conexion/Cursos.php";

$operations = new Cursos();
$item1 = "";
$item2 = "border bg-gray-200";
$item3 = "";
$item4 = "";
$sql = $operations->getCamposConCondicion('usuarios', 'id', $id_user);
$statu_user = $sql[0]['is_admin'];
if ($statu_user == 1 || $statu_user == '1') {
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
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
            <div class="!bg-white z-10 px-4 py-2">
                <p user-id="<?php echo $id_user ?>" id="userIdHtml" style="color:black;" hidden>
                    <?php echo $id_user ?>
                </p>
                <div class="row  h-100">
                    <div class="col-12">
                        <div class="row w-100  bg- mb-4 p-2">
                            <div class="col-12 m-0 p-0">
                                <div class="row m-0 p-0">
                                <div class="col-12 col-md-6">
                                        <h2 class="text-2xl font-bold mb-2 text-center md:!text-start md:mb-5 text-black">
                                            Cursos registrados</h2>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="flex flex-col md:flex-row  justify-end gap-4 mb-0">

                                                <a class="inline-flex bg-black text-white  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2"
                                                    href="./addcurso">Nuevo curso
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="white" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                        <path
                                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                    </svg>
                                                </a>
                                        </div>
                                        <?php include('./components/profile.php'); ?>
                                    </div>
                                    
                                </div>
                                <div class="grid grid-cols-1 mt-3 border rounded-lg bg-white">
                                    <div class="relative w-full overflow-auto col-span-1">
                                        <table class="w-full caption-bottom text-sm">
                                            <thead class="[&_tr]:border-b">
                                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">#</th>
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Portada</th>
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Nombre del curso</th>
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Estado</th>
                                                    <!-- <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Encargado</th> -->
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Lecciones</th>
                                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tabla = "cursos";
                                                $data = $operations->getData($tabla);
                                                try {
                                                    if (!empty($data)) {
                                                        $pos = 0;
                                                        foreach ($data as $fila) {
                                                            $pos++
                                                ?>
                                                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                                <th class="px-4  py-2 align-middle text-black font-medium">
                                                                    <?php echo $pos; ?>
                                                                </th>
                                                                <td class="px-4  py-2 align-middle text-black font-medium">
                                                                    <figure class="p- align-middle text-black">
                                                                        <img class="card-img object-fit-cover rounded-bottom-0"
                                                                            src="./assets/img/<?php echo $fila['imagen_curso']; ?>"
                                                                            style="width:50px; height:50px"
                                                                            alt="<?php echo $fila['titulo_curso']; ?>">
                                                                    </figure>
                                                                </td>
                                                                <td class="px-4  py-2 align-middle text-black font-medium">
                                                                    <p class="titulo-curso p- align-middle text-black">
                                                                        <?php echo $fila['titulo_curso']; ?>
                                                                    </p>

                                                                </td>
                                                                <td class="px-4  py-2 align-middle text-black font-medium">
                                                                    <p class="p- align-middle text-black" id="estadoCurso-<?php echo $fila['id'] ?>">
                                                                        <?php echo $fila['activo'] == '1' ? 'Activo' : 'Desactivo';
                                                                        ?>
                                                                    </p>
                                                                </td>
                                                                <!-- <td class="px-4  py-2 align-middle text-black font-medium">
                                                                    <?php

                                                                    echo $fila['id_instructor']; ?>
                                                                </td> -->
                                                                <td class="px-4  py-2 align-middle text-black font-medium">
                                                                    <div class="flex justify-between ">
                                                                        <a class="text-[#15803d] bg-[#22c55e1a] flex items-center border !border-[#15803d] rounded py-1 px-2  text-[0.75rem]  gap-2"
                                                                            href="./seelecciones?<?php echo 'idcr=' . $fila['id']; ?>">Ver
                                                                            lecciones <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                height="16" fill="#15803d" class="bi bi-eye"
                                                                                viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                                <path
                                                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                            </svg></a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="row container">
                                                                        <div class="col-6 d-flex justify-content-center p-1">
                                                                            <a class="text-black bg-green-400 p-2 rounded "
                                                                                href="./editcurso?idcr=<?php echo $fila['id'] ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                    height="16" fill="black"
                                                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                                                </svg>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-6 d-flex justify-content-center p-1"
                                                                            id="item_close-<?php echo $fila['id']; ?>">
                                                                            <?php echo $fila['activo'] == '1' ? '<button onclick="powerCourse(' . $fila['id'] . ',' . $fila['activo'] . ')" class="p-2 rounded  bg-amber-400 border-amber-400 text-black" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z" />
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
            </svg>
        </button>' : '<button onclick="powerCourse(' . $fila['id'] . ',' . $fila['activo'] . ')" class=" p-2 rounded bg-amber-200 text-black border-amber-200" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z" />
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
            </svg>
        </button>' ?>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                <?php
                                                        }
                                                        echo "  </tbody>
                                                    </table>
                                                </div>";
                                                    } else {
                                                        echo '<h3 class="font-semibold text-black text-xl text-center" style="right: 30px; top:10px">
                                    No se han encontrado cursos
                                         </h3>';
                                                    }
                                                } catch (\Throwable $th) {
                                                    echo $th;
                                                }
                                                ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </section>

        </main>
        <script src="./js/courses.js"></script>
</body>

<?php
include('./page-master/js.php');

?>