<?php
$title = "Editar lección";
include('./page-master/head.php');
include "../conexion/Cursos.php";

session_start();

$operations = new Cursos();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
    if (!isset($_GET['idl']) || empty($_GET['idl'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $idlecicon = $_GET['idl'];
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
            <div>
            <p user-id="<?php echo $id_user ?>" id="userIdHtml" style="color:black;" hidden>
                <?php echo $id_user ?>
            </p>
            <p curso-id="<?php echo $idlecicon ?>" hidden id="idleccionhtml" style="color:black;">
                <?php echo $idlecicon ?>
            </p>
            <div class="mt-4   flex justify-center w-full">
                <div class="row   bg- mb-4 p-2">
                    <div class="col-12">
                        <div class="grid items-center grid-cols-2">

                            <div class="col-span-1">

                                <?php include('./components/profile.php'); ?>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-center">
                            <div class="col-span-12 md:col-span-8 bg-white rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                                <h2 class="text-2xl font-semibold leading-none text-black tracking-tight text-center">
                                    Editar lección</h2>
                                <form enctype="multipart/form-data">
                                    <?php
                                    $tabla = "lecciones";
                                    $data = $operations->getCamposConCondicion($tabla, 'id_leccion', $idlecicon);
                                    try {
                                        if (!empty($data)) {
                                            foreach ($data as $fila) {
                                    ?>
                                                <div class="space-y-2 mb-3">
                                                    <label for="previmg" class="text-2xl font-semibold leading-none tracking-tight text-black">Portada </label>
                                                    <img id="previmg" class="object-cover rounded"
                                                        src="./assets/img_leccion/<?php echo $fila['img_leccion']; ?>"
                                                        alt="<?php echo $fila['titulo']; ?>" style="width:320px">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nuevafoto" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Foto del curso
                                                        recomendado: <strong class="text-danger">720*720px </strong> ||
                                                        Extensiones <strong class="text-danger">.JPG - .JPEG - .WEBP
                                                        </strong></label>
                                                    <input type="file" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nuevafoto" name="nuevafoto"
                                                        accept=".jpg, .jpeg, .png, .webp" required>
                                                </div>

                                                <div class="space-y-2 mb-3">
                                                    <label for="nombreleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre de la Lecicón</label>
                                                    <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombreleccion"
                                                        value="<?php echo $fila['titulo'] ?>" name="nombreleccion" required>
                                                </div>
                                                <div class="space-y-2 mb-3">
                                                    <label for="nombreleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre de la Lecicón</label>
                                             
                                                        <textarea type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="descripcion" name="descripcion"
                                                        required
                                                        > <?php echo $fila['descripcion'] ?></textarea>
                                                </div>
                                                <div class="space-y-2 mb-3">
                                                    <label for="urlleccion" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70 font-bold">Url de
                                                        video</label>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9"><input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                                id="urlleccion" value="<?php echo $fila['video_url'] ?>"
                                                                name="urlleccion" required></div>
                                                        <div class="col-3"><a target="_blank" class="text-[#15803d] bg-[#22c55e1a] flex items-center border !border-[#15803d] rounded py-1 px-2  text-[0.75rem]  gap-2 flex" href="<?php echo $fila['video_url'] ?>">Ver lección  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                                fill="#15803d" class="bi bi-eye" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z">
                                                                </path>
                                                                <path
                                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0">
                                                                </path>
                                                            </svg></a>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-2 mb-3">
                                                    <label for="nombrecurso" class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nombre del curso</label>
                                                    <p hidden id="cursoidhtml"><?php echo $fila['id_curso']; ?></p>
                                                    <?php
                                                    // SELECT * FROM usuarios WHERE is_admin ='1';
                                                    $get_crs = $operations->getCamposConCondicion('cursos', 'id', $idlecicon);
                                                    if (!empty($get_crs)) {
                                                        foreach ($get_crs as $curso_name) {
                                                    ?>
                                                            <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombrecurso"
                                                                value="<?php echo $curso_name['titulo_curso'] ?>" disabled name="nombrecurso"
                                                                required readonly>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex justify-between">
                                                    <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F3C623] text-black hover:bg-opacity-80 h-10 px-4 py-2"
                                                        href="./cursos">Atrás

                                                    </a>
                                                    <button type="button" onclick="updateLeccion();"
                                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black text-white hover:bg-opacity-50 h-10 px-4 py-2">GUARDAR
                                                        LECCIÓN</button>
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
        
            </div></section>
    </main>
    <?php
    include('./page-master/js.php');

    ?>
    <script src="./js/lecciones.js"></script>
</body>