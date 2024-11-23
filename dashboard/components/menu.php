<?php
$tabla = "usuarios";
$condicion = "id";
$params = $id_user;
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$tipo_user = $obtenerUsuario[0]['is_admin'];
?>
<nav class="mx-auto px-4 sm:px-6 lg:px-8 bg-white relative top-0 z-50 border-b ">
    <div class=" mx-auto flex items-center justify-end p-4">

        <div class="md:items-center md:space-x-4 navMenu" id="navbarSupportedContent">
            <div class="relative md:mt-0">
                <div class="dropdown inline-block text-left">
                    <div>
                        <button class="grid grid-cols-2 items-center" id="userDropdown" aria-haspopup="true" aria-expanded="true">
                            <?php if (!empty($obtenerUsuario)) { ?>
                             
<img src="<?php echo './assets/users/'. $obtenerUsuario[0]['imagen_profile'] ?>" alt="profile" class="w-10 h-10 rounded-full bg-gray-200">
                                    <span class="text-sm font-normal border-transparent  hover:border-gray-300 text-zinc-900 transition-sidebar peer relative flex h-8 w-full items-center !justify-start gap-2 overflow-hidden rounded-lg text-right">Cuenta</span>
                          
                            <?php } else {
                                echo "No se encontró ningún usuario con el ID proporcionado.";
                            } ?>

                        </button>
                        <div class="dropdown-menu hidden p-0 absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                            <a class="text-sm font-normal border-transparent  hover:border-gray-300 text-zinc-900 relative flex h-8 w-full items-center  overflow-hidden rounded-t-md text-right px-4  hover:bg-gray-200" href="./setting.php">Cuenta</a>
                            <div class="border-t border-gray-200"></div>
                            <a class="text-sm font-normal border-transparent  hover:border-gray-300 text-zinc-900 relative flex h-8 w-full items-center  overflow-hidden rounded-b-md text-right px-4  hover:bg-gray-200" href="./conexion/destroy.php">Salir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Toggle the dropdown menu
    document.getElementById('userDropdown').addEventListener('click', function() {
        const menu = document.querySelector('.dropdown-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('block');
    });

    // Toggle the navbar
    document.getElementById('navbarToggle').addEventListener('click', function() {
        const navbarContent = document.getElementById('navbarSupportedContent');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        navbarContent.classList.toggle('fixed');
        navbarContent.classList.toggle('top-0');
        navbarContent.classList.toggle('left-0');
        navbarContent.classList.toggle('right-0');
        navbarContent.classList.toggle('!flex');
        navbarContent.classList.toggle('flex-col');
        navbarContent.classList.toggle('bg-gray-100');
        navbarContent.classList.toggle('border-r');
        navbarContent.classList.toggle('h-full');
        navbarContent.classList.toggle('w-[240px]');
        navbarContent.classList.toggle('p-4');

        // Toggle icons
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>