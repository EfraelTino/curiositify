<?php
session_start();
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: ../");
    exit;
} else {
    $id_user = $_SESSION['idusuario'];
}
$title = "Configuración";

include "./page-master/head.php";
include "../conexion/Cursos.php";

$operations = new Cursos();
$item1 = "";
$item2 = "";
$item3 = "";
$item4 = "border bg-gray-200";
$get_user = $operations->getCamposConCondicion("usuarios", "id", $id_user);
$data_user = array();
foreach ($get_user as $data) {
    $data_user[] = $data;
}
// var_dump($data_user);
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
            <section class="!bg-white z-10 px-4 py-2 flex justify-center">
                <div class="  rounded-lg border shadow-sm w-full max-w-6xl mb-20 md:my-10 p-4">
                    <p id="userid" hidden><?php echo $id_user ?></p>



                    <!-- PHOTO PROFILE -->
                    <div class="col-12 m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="row space-y-2">
                                        <div class="col-12 m-0 p-0 col-md-6 col-lg-4 rounded-circle">
                                            <img src="./assets/users/<?php echo $data_user[0]['imagen_profile'] == '' ? 'carpintero.webp' : $data_user[0]['imagen_profile'] ?>" alt="Foto de perfil"
                                                class="rounded-full object-cover w-[250px] h-[250px]">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 align-items-center" id="choose-item">
                                            <div class="flex flex-col space-y-2">
                                                <div>
                                                    <h3 class="font-semibold tracking-tight text-2xl text-black"><?php echo $data_user[0]['nombre']. ' ' .$data_user[0]['apellido']; ?></h3>
                                                    <p class="text-muted-foreground"><strong class="text-black">Tipo de suscripción: </strong>
                                                        <?php echo $data_user[0]['is_premium'] == 0 ? 'Free' : 'Premium'; ?>
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-muted-foreground"><strong class="text-black">Email: </strong>
                                                        <?php echo $data_user[0]['email']; ?>
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-muted-foreground"><strong class="text-black">Telf: </strong>
                                                        <?php echo $data_user[0]['telf'] == '' ? 'Sin especificar' : $data_user[0]['telf']; ?>
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-muted-foreground"><strong class="text-black">Fecha Suscripción: </strong>
                                                        <?php echo $data_user[0]['fecha'] == '' ? 'Sin suscripción' : $data_user[0]['fecha']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black  text-white hover:bg-opacity-50 h-10 px-4 py-2" onclick="chooseProfile()">
                                                    Cambiar foto de perfil<svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="white"
                                                        class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z">
                                                        </path>
                                                        <path
                                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-8" id="save_options">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                    </div>

                    <div class=" mt-3 mb-2">
                        <h2 class="text-lg font-semibold mb-2 text-black">
                            Datos Personales
                        </h2>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <form enctype="multipart/form-data" class="grid grid-cols-12 gap-2">
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="nombre" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Nombres</label>
                                    <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombre"
                                        value="<?php echo $data_user[0]['nombre'] ?>" name="nombre" required>
                                </div>
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="apellido" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Apellidos</label>
                                    <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="apellido" name="apellido" required
                                        value="<?php echo $data_user[0]['nombre'] ?>">
                                </div>
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Email</label>
                                    <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="email" required
                                        disabled value="<?php echo $data_user[0]['email'] ?>">
                                </div>
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="telf" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Teléfono</label>
                                    <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="telf" name="telf" required
                                        value="<?php echo $data_user[0]['telf'] ?>">
                                </div>
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="pass" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Contraseña</label>
                                    <input type="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="pass" name="pass" required
                                        placeholder="******">
                                </div>
                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <label for="passr" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-black">Reperir contraseña</label>
                                    <input type="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="passr" name="passr" required
                                        placeholder="******">
                                </div>

                                <div class="mb-3 col-span-12 md:col-span-6 space-y-2">
                                    <button type="button" onclick="updatedatas();" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black  text-white hover:bg-opacity-50 h-10 px-4 py-2">ACTUALIZAR
                                        DATOS</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END PHOTO PROFILE -->

                </div>
    </div>
    </section>
    </section>
    </div>


    <?php
    //include('./components/profile.php');
    include_once('./page-master/js.php');
    ?>
    <script src="./js/setting.js"></script>
</body>