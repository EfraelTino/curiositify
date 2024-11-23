<?php
$title = "Editar curso";
include('./page-master/head.php');
include "../conexion/Cursos.php";

session_start();

$operations = new Cursos();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    if (!isset($_GET['idcr']) || empty($_GET['idcr'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $idcurso = $_GET['idcr'];
    }
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
<style>
    .modal-backdrop {
        z-index: 11;
    }
</style>

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
    <div class="flex ">
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
                <p user-id="<?php echo $idcurso ?>" hidden id="idcursoHtml" style="color:black;">
                    <?php echo $idcurso ?>
                </p>
                <div class="mt-4 flex justify-center w-full">

                    <div class="row w-100  bg- mb-20 md:mb-0 p-2">
                        <div class="col-12">
                     
                                <div class="col-span-12 md:col-span-8 bg-white rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                                    <div class="col-span-1">
                                        <h2 class="text-2xl font-semibold leading-none  text-center text-black tracking-tight">
                                            Cursos registrados</h2>
                                    </div>
                                    <form enctype="multipart/form-data">
                                        <?php
                                        $tabla = "cursos";
                                        $data = $operations->getCamposConCondicion($tabla, 'id', $idcurso);
                                        try {
                                            if (!empty($data)) {
                                                foreach ($data as $fila) {
                                        ?>
                                                    <div class="space-y-2 mb-3">
                                                        <label for="exampleInputEmail1" class="text-lg md:text-2xl mt-4 md:mt-0 font-semibold leading-none tracking-tight text-black">Portada </label>
                                                        <img id="previmg" class="card-img object-fit-cover rounded-bottom-0"
                                                            src="./assets/img/<?php echo $fila['imagen_curso']; ?>"
                                                            alt="<?php echo $fila['titulo_curso']; ?>" style="width:320px">
                                                    </div>
                                                    <div class="space-y-2 mb-3">
                                                        <label for="nuevafoto" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Foto del curso
                                                            recomendado: <strong class="text-danger">720*720px </strong> ||
                                                            Extensiones <strong class="text-danger">.JPG - .JPEG - .WEBP
                                                            </strong></label>
                                                        <input type="file" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nuevafoto" name="nuevafoto"
                                                            accept=".jpg, .jpeg, .png, .webp" required>

                                                    </div>
                                                    <div class="space-y-2 mb-3">
                                                        <label for="nombrecurso" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre del
                                                            curso</label>
                                                        <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombrecurso"
                                                            value="<?php echo $fila['titulo_curso'] ?>" name="nombrecurso" required>
                                                    </div>
                                                    <div class="space-y-2 mb-3">
                                                        <label for="dictador" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Instructor del
                                                            curso</label>
                                                        <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" aria-label="Default select example"
                                                            id="instructor" required name="dictador">
                                                            <?php
                                                            // SELECT * FROM usuarios WHERE is_admin ='1';
                                                            $get_admins = $operations->getCamposConCondicion('usuarios', 'is_admin', 1);
                                                            if (!empty($get_admins)) {
                                                                foreach ($get_admins as $admin) {
                                                            ?>
                                                                    <option class="text-black" value="<?php echo $admin['id']; ?>" <?php echo $fila['id_instructor'] == $admin['id'] ? 'selected' : ''; ?>>
                                                                        <?php echo $admin['nombre'] . " " . $admin['apellido']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="flex justify-center gap-4">
                                                        <a href="./cursos.php" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2">

                                                            Regresar

                                                        </a>
                                                        <button type="button" onclick="updateCurso();"
                                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black text-white hover:bg-opacity-50 h-10 px-4 py-2">Guardar curso
                                                        </button>

                                                    </div>
                                        <?php
                                                }
                                                echo "  </form>
                                                </div>";
                                            } else {
                                                echo '<h3 class="fw-bold text-black fs-4" style="right: 30px; top:10px">
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

        </section>
        </main>
        <script src="./js/courses.js"></script>
</body>

<?php
include('./page-master/js.php');

?>