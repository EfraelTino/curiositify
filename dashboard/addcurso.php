<?php
$title = "Agregar curso";
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
$item2 = "border bg-gray-200";
$item3 = "";
$item4 = "";
$sql = $operations->getCamposConCondicion('usuarios', 'id', $id_user);
$statu_user = $sql[0]['is_admin'];
if (!$statu_user == 1 || !$statu_user == '1') {
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
            <div>
                <p user-id="<?php echo $id_user ?>" id="userIdHtml" style="color:black;" hidden>
                    <?php echo $id_user ?>
                </p>
                <div class="col-12 flex justify-start  mt-12 gap-4 flex-col items-center">

                    <div class="rounded-lg border bg-white relative z-10 text-card-foreground shadow-sm w-[400px] p-6">
                        <div class="">
                            <div class="">
                                <h3 class="text-2xl font-semibold leading-none text-black tracking-tight text-center pb-6">Nuevo curso

                                </h3>
                            </div>
                            <form enctype="multipart/form-data">
                                <div class="space-y-2 mb-3">
                                    <label for="nuevafoto" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Foto del curso
                                        recomendado: <strong class="text-danger">720*720px </strong> ||
                                        Extensiones <strong class="text-danger">.JPG - .JPEG - .WEBP
                                        </strong></label>
                                    <input type="file" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="imagen" name="imagen" accept="image/*" required>
                                </div>
                                <div class="space-y-2 mb-3">
                                    <label for="nombrecurso" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre del
                                        curso</label>
                                    <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombrecurso" name="nombrecurso" placeholder="Ingresa el nombre del curso"
                                        required>
                                </div>
                                <div class="mb-3 space-y-2">
                                    <label for="dictador" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Instructor del
                                        curso</label>
                                    <select class="flex h-10 w-full rounded-md border text-black border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" aria-label="Default select example"
                                        id="instructor" required name="dictador">
                                        <?php
                                        // SELECT * FROM usuarios WHERE is_admin ='1';
                                        $get_admins = $operations->getCamposConCondicion('usuarios', 'is_admin', 1);
                                        if (!empty($get_admins)) {
                                            foreach ($get_admins as $admin) {
                                        ?>
                                                <option class="text-black" value="<?php echo $admin['id']; ?>">
                                                    <?php echo $admin['nombre'] . " " . $admin['apellido']; ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="space-y-2 mb-3">
                                    <label for="estado" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Estado del curso</label>
                                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background text-black placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" aria-label="Default select example text-black"
                                        id="estado" required name="estado">
                                        <option class="text-black" value="1">
                                            Activo
                                        </option>
                                        <option class="text-black" value="0">
                                            Desactivo
                                        </option>
                                    </select>
                                </div>
                                <div class="space-y-2 mb-3">
                                    <label for="tipo" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tipo de curso</label>
                                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" aria-label="Default select example"
                                        id="tipo" required name="tipo">
                                        <option class="text-black" value="1">
                                            Premium
                                        </option>
                                        <option class="text-black" value="0">
                                            Free
                                        </option>
                                    </select>
                                </div>
                                <div class="flex justify-between">
                                    <a href="./cursos.php"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2">

                                        Regresar

                                    </a>
                                    <button type="button" onclick="addCurso();"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black  text-white hover:bg-opacity-50 h-10 px-4 py-2">Guardar curso</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="./js/courses.js"></script>
</body>

<?php
include('./page-master/js.php');

?>