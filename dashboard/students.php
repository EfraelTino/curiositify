<?php
$title = "Lista de Estudiantes";
include "../conexion/Cursos.php";

include "./page-master/head.php";
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
$operations = new Cursos();
$item1 = "";
$item2 = "";
$item3 = "border bg-gray-200";
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
            <div class="!bg-white z-10 px-4 py-2">
                <div class=" mx-auto" data-id="1">
                    <h1 class="text-2xl font-bold mb-2 text-black" data-id="2">Estudiantes registrados</h1>
                    <div class="row my-3">

                        <label class="text-black">
                            Visualizar
                            <select class=" h-10 rounded-md border border-input bg-background  px-1 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="amount_show"
                                name="amount_show">
                                <option class="text-black" value="10" selected="">10</option>
                                <option class="text-black" value="25">25</option>
                                <option class="text-black" value="50">50</option>
                                <option class="text-black" value="100">100</option>
                            </select>
                            Registros
                        </label>
                    </div>
                    <div class="relative w-full overflow-auto rounded-lg bg-white border bg-card text-card-foreground shadow-sm p-4">
                        <table class="w-full caption-bottom text-sm" data-id="6">
                            <caption class="mt-4 text-sm text-muted-foreground" id="data-cantidad">Lista de estudiantes inscritos en la plataforma</caption>
                            <thead class="[&amp;_tr]:border-b" data-id="8">
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-id="9">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600"># </th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Nombres </th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Nombre de estudiante</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Email</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Teléfono</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Suscripción </th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Fecha inicio </th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-600">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-insert">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    // include('./components/profile.php');
    include_once('./page-master/js.php');
    ?>
    <script src="./js/students.js"></script>