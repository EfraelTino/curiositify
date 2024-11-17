<?php
$title = "Agregar lección";
include('./page-master/head.php');

include "../conexion/Cursos.php";

session_start();

$operations = new Cursos();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    if (isset($_GET['idcr']) || !empty($_GET['idcr'])) {
        $id_curso_g = $_GET['idcr'];
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
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

<body >
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
            <p user-id="<?php echo $id_curso_g ?>" id="cursoIdHtml" style="color:black;" hidden>
                <?php echo $id_curso_g ?>
            </p>
            <div class="row  h-100 p-3">
                <div class="col-12 m-0 p-0">
                    <div class="row w-100 m-0 p-0  bg- mb-4 p-2">
                        <div class="col-12 flex justify-start gap-4  m-0 p-0 flex-col items-center">
                            <div class="grid grid-cols-12 mb-4 m-0 p-0">

                            </div>
                            <div class="rounded-lg border bg-card text-card-foreground bg-white shadow-sm max-w-xl w-full p-6">
                                <div class="col-12 m-0 p-0 ">
                                    <h2 class="text-2xl font-semibold leading-none text-black tracking-tight text-center pb-6">
                                        Registra una nueva lección</h2>
                                    <form enctype="multipart/form-data">
                                        <div class="space-y-2 mb-3">
                                            <label for="nuevafoto" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Foto de la lección
                                                recomendado: <strong class="text-danger">720*720px </strong> ||
                                                Extensiones <strong class="text-danger">.JPG - .JPEG - .WEBP
                                                </strong></label>
                                            <input type="file" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nuevafoto" name="nuevafoto"
                                                accept=".jpg, .jpeg, .png, .webp" required>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="nombreleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre de la lección</label>
                                            <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 " id="nombreleccion" name="nombreleccion"
                                                required>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="video_url" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"><strong
                                                    class="text-red-500">URL VIDEO</strong> de la lección</label>
                                            <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="video_url" name="video_url"
                                                required>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="ordenleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Orden de la Lección</label>
                                            <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="ordenleccion" name="ordenleccion"
                                                required>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="nombrecurso" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre del curso</label>
                                            <?php
                                            $get_user = $operations->getCamposConCondicion('cursos', 'id', $id_curso_g);
                                            if (!empty($get_user)) {
                                                foreach ($get_user as $admin) {

                                                    echo '<input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombrecurso" name="nombrecurso"
                                                        value="' . $admin['titulo_curso'] . '" readonly>';

                                            ?>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="estado" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Estado de la lección</label>
                                            <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" aria-label="Default select example" id="estado"
                                                required name="estado">
                                                <option class="text-black" value="1">
                                                    Activo
                                                </option>
                                                <option class="text-black" value="0">
                                                    Desactivo
                                                </option>
                                            </select>
                                        </div>
                                        <div class="space-y-2 mb-3">
                                            <label for="ordenleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Descripción del curso</label>
                                            <textarea type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="descripcion" name="descripcion"
                                                required> </textarea>
                                        </div>
                                        <div class="flex justify-between">
                                            <a href="./seelecciones.php?idcr=<?php echo $id_curso_g ?>"
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2">Atrás

                                            </a>
                                            <button type="button" onclick="addLeccion();"
                                                class="text-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black  text-white hover:bg-opacity-50 h-10 px-4 py-2">Guardar
                                                lección</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
           </div>
        </section>
    </div>.
    <?php
    include('./page-master/js.php');

    ?>
    <script src="./js/lecciones.js"></script>
</body>