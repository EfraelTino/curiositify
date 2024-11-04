<?php
$tabla = "usuarios";
$condicion = "id";
$params = $id_user;
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$tipo_user = $obtenerUsuario[0]['is_admin'];
?>
<nav class="mx-auto px-4 sm:px-6 lg:px-8 bg-white relative top-0 z-50 shadow-md ">
    <div class="container mx-auto flex items-center justify-between p-4">
        <a href="./" class="flex items-center">
            <img src="../assets/img/curiositify.webp" alt="" class="w-32">
        </a>
        <button class="md:hidden text-black focus:outline-none" type="button" id="navbarToggle">

            <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#ffffff" style="stroke:black">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            
            <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg"class="h-6 w-6 hidden"  fill="black" class="bi bi-x-lg hidden" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
        </button>
        <style>
            .navMenu{
                display: none;
            }
            @media screen and (min-width: 768px) {
 .navMenu{display: flex;}
}
        </style>
        <div class="md:items-center md:space-x-4 navMenu" id="navbarSupportedContent">
            <ul class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 left-10 md:left-0">
                <li>
                    <a href="./" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 <?php echo $item1; ?>" aria-current="page">Principal</a>
                </li>
                <li>
                    <a href="./courses.php" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700  <?php echo $item2; ?>">Cursos</a>
                </li>
                <?php if ($tipo_user == 1 || $tipo_user == '1') { ?>
                    <li>

                        <a href="./students.php" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 <?php echo $item3; ?>">Estudiantes</a>

                    </li>
                <?php } ?>
                <li>
                    <a href="./setting.php" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700  <?php echo $item4; ?>">Ajustes</a>
                </li>
            </ul>
                <!-- <div class="relative mt-2 md:mt-0">
                    <input type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm ring-offset-background placeholder:text-gray-400 text-gray-400 cursor-text focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black cursor focus-visible:ring-offset-2" placeholder="Buscar Curso...." value="Buscar Curso....">
                </div> -->
            <div class="relative mt-2 md:mt-0">
                <div class="dropdown inline-block text-left">
                    <div>
                        <button class="flex items-center gap" id="userDropdown" aria-haspopup="true" aria-expanded="true">
                            <?php if (!empty($obtenerUsuario)) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="stroke: black;" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user h-6 w-6" data-id="15">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>

                                    <span class="text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 ">Cuenta</span>
                                </svg>
                            <?php } else {
                                echo "No se encontró ningún usuario con el ID proporcionado.";
                            } ?>

                        </button>
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="./setting.php">Cuenta</a>
                            <div class="border-t border-gray-200"></div>
                            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="./conexion/destroy.php">Salir</a>
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