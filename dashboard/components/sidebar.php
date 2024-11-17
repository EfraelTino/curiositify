<?php
$tabla = "usuarios";
$condicion = "id";
$params = $id_user;
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$obtenerUsuario = $operations->getCamposConCondicion($tabla, $condicion, $params);
$tipo_user = $obtenerUsuario[0]['is_admin'];
?>
<style>
    #sidebar {
        transition: width 0.3s ease-in-out;
    }

    .data-text {
        transition: opacity 0.3s ease-in-out;
        opacity: 1;
    }
</style>
<aside class=" relative bg-white z-10 sm:flex py [calc(var(--sidebar-width)-theme(spacing.10))] " style="--sidebar-width:231px;--sidebar-width-collapsed:49px" id="sidebar">
    <div
        class="md:collapsed:w-[--sidebar-width-collapsed] transition-sidebar  relative z-10 h-svh md:w-[--sidebar-width] bg-transparent">
    </div>
    <div
        class="hidden-s md:flex bg-white border-alpha-200 md:collapsed:w-[--sidebar-width-collapsed] transition-sidebar fixed inset-y-0 left-0 z-10  h-svh md:w-[--sidebar-width] flex-col overflow-hidden border-r">
        <div class="py-4 flex h-svh w-[--sidebar-width] flex-1 translate-x-[-0.5px] flex-col overflow-hidden">
            <div class="flex items-center p-2 relative pb-1 justify-between" id="logocontainer">
                <div class="flex items-center " id="logo">
                    <a class="" href="/">
                        <img src="../assets/img/curiositify.webp" alt="Logo curiositify" class="w-32">
                    </a>
                </div>

                <div
                    class="transition-sidebar  collapsed:opacity-0 bg-muted  z-10 opacity-100 duration-75 ">
                    <button class="rounded hover:bg-gray-200" id="btnExpanded">
                        <i class="bi bi-layout-sidebar size-4"></i>
                    </button>
                </div>
            </div>
            <div class="transition-sidebar grid w-full min-w-0 p-2">
                <div class="transition-sidebar flex w-full min-w-0 flex-col gap-2">
                    <div class="group relative flex items-center rounded-md">
                        <a href="./" class="<?php echo $item1; ?> group-hover:bg-gray-100 active:bg-gray-150  collapsed:w-8 transition-sidebar peer relative flex h-8 w-full items-center !justify-start gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                            <div
                                class="collapsed:left-2 transition-sidebar absolute inset-2 flex w-fit items-center justify-center gap-2 whitespace-nowrap ">
                                <i class="bi bi-house text-sm"></i>
                                <span class="data-text">Inicio</span>
                            </div>
                        </a>
                    </div>
                    <div class="group relative flex items-center rounded-md">
                        <a class="<?php echo $item4; ?> group-hover:bg-gray-100 active:bg-gray-150  collapsed:w-8 transition-sidebar peer relative flex h-8 w-full items-center !justify-start gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900  "
                            data-state="closed" href="./setting">
                            <div
                                class="collapsed:left-2 transition-sidebar absolute inset-2 flex w-fit items-center justify-center gap-2 whitespace-nowrap ">
                                <i class="bi bi-gear text-sm"></i>
                                <span class="data-text">Ajustes</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div role="none"
                class="shrink-0 h-[1px] transition-sidebar collapsed:w-8 mx-2 w-[calc(var(--sidebar-width)-theme(spacing.4))] border-b border-dashed bg-transparent collapsed:hidden">
            </div>
            <div class="transition-sidebar grid w-full min-w-0 p-2">
                <div class="transition-sidebar flex w-full min-w-0 flex-col gap-2">
                    <?php if ($tipo_user == 1 || $tipo_user == '1') { ?>
                        <div class="group relative flex items-center rounded-md">
                            <a
                                href="./students"
                                class="<?php echo $item3; ?> group-hover:bg-gray-100 collapsed:w-8 transition-sidebar peer relative flex h-8 w-full items-center !justify-start gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                                <div
                                    class="collapsed:left-2 transition-sidebar absolute inset-2 flex w-fit items-center justify-center gap-2 whitespace-nowrap">
                                    <i class="bi bi-people text-sm"></i>
                                    <span class="data-text">Estudiantes</span>
                                </div>
                            </a>
                        </div>
                        <div class="group relative flex items-center rounded-md">
                            <a
                                href="./cursos"
                                class="<?php echo $item2; ?> group-hover:bg-gray-100 collapsed:w-8 transition-sidebar peer relative flex h-8 w-full items-center !justify-start gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                                <div
                                    class="collapsed:left-2 transition-sidebar absolute inset-2 flex w-fit items-center justify-center gap-2 whitespace-nowrap ">
                                    <i class="bi bi-book text-sm"></i>
                                    <span class="data-text">Cursos</span>
                                </div>
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="flex flex-1 flex-col overflow-auto">
                <div class="transition-sidebar grid w-full min-w-0 p-2 mt-auto"><button
                        class="focus-visible:ring-offset-background shrink-0 cursor-pointer items-center justify-center gap-1.5 whitespace-nowrap text-nowrap border font-medium outline-none ring-blue-600 transition-all focus-visible:ring-2 focus-visible:ring-offset-1 disabled:pointer-events-none disabled:cursor-not-allowed disabled:ring-0 has-[:focus-visible]:ring-2 aria-disabled:pointer-events-none aria-disabled:cursor-not-allowed aria-disabled:ring-0 [&amp;>svg]:pointer-events-none [&amp;>svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-alpha-200 focus:bg-alpha-200 focus-visible:bg-alpha-200 border-transparent bg-transparent text-zinc-900 hover:border-transparent focus:border-transparent focus-visible:border-transparent disabled:border-transparent disabled:bg-transparent disabled:text-gray-400 aria-disabled:border-transparent aria-disabled:bg-transparent aria-disabled:text-gray-400 px-4 text-sm has-[>kbd]:gap-3 has-[>kbd]:pr-[6px] rounded-lg size-8 has-[>svg]:p-0 collapsed:flex hidden"><svg
                            class="size-4" height="16" stroke-linejoin="round" viewBox="0 0 16 16" width="16"
                            style="color: currentcolor;">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.245 2.5H14.5V12.5C14.5 13.0523 14.0523 13.5 13.5 13.5H6.245V2.5ZM4.995 2.5H1.5V12.5C1.5 13.0523 1.94772 13.5 2.5 13.5H4.995V2.5ZM0 1H1.5H14.5H16V2.5V12.5C16 13.8807 14.8807 15 13.5 15H2.5C1.11929 15 0 13.8807 0 12.5V2.5V1Z"
                                fill="currentColor"></path>
                        </svg></button></div>
            </div>

            <!--<div class="collapsed:hidden relative w-full">
                <div class="from-muted absolute inset-x-0 -top-8 z-10 h-8 w-full bg-gradient-to-t"></div><a
                    href="https://x.com/v0/status/1851397883490418818" target="_blank" rel="noreferrer"
                    class="relative z-20 block h-fit w-full p-2 pt-0">
                    <section
                        class="bg-background border-alpha-400 flex flex-col gap-1.5 rounded-lg border p-3 drop-shadow-sm transition-[transform,border] hover:-translate-y-0.5 hover:border-gray-300 hover:drop-shadow-md">
                        <span class="flex items-center justify-between text-gray-500">
                            <h5 class="text-[13px] font-medium">New Feature</h5><span class="sr-only">Learn
                                more</span><button
                                class="focus-visible:ring-offset-background inline-flex shrink-0 cursor-pointer items-center justify-center gap-1.5 whitespace-nowrap text-nowrap border font-medium outline-none ring-blue-600 transition-all focus-visible:ring-2 focus-visible:ring-offset-1 disabled:pointer-events-none disabled:cursor-not-allowed disabled:ring-0 has-[:focus-visible]:ring-2 aria-disabled:pointer-events-none aria-disabled:cursor-not-allowed aria-disabled:ring-0 [&amp;>svg]:pointer-events-none [&amp;>svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-alpha-200 focus:bg-alpha-200 focus-visible:bg-alpha-200 border-transparent bg-transparent text-zinc-900 hover:border-transparent focus:border-transparent focus-visible:border-transparent disabled:border-transparent disabled:bg-transparent disabled:text-gray-400 aria-disabled:border-transparent aria-disabled:bg-transparent aria-disabled:text-gray-400 px-2 text-xs has-[>kbd]:gap-2 has-[>svg]:px-1 has-[>kbd]:pr-1 size-5 rounded-sm"><span
                                    class="text-lg">×</span></button>
                        </span>
                        <p class="text-sm">We've improved v0's ability to generate code from uploaded images</p>
                    </section>
                </a>
            </div> -->
            <div class="transition-sidebar flex items-center collapsed:p-1 p-1">
                <button
                    onclick="handleComment()"
                    class=" inline-flex shrink-0 cursor-pointer items-center justify-between gap-1.5 whitespace-nowrap text-nowrap border font-medium   bg-zinc-950 text-slate-100 hover:border-transparent hover:bg-zinc-800  text-sm rounded-lg hover:bg-gray-150 transition-sidebar focus-visible:bg-gray-150 collapsed:size-10 active:bg-gray-150 relative h-10 w-full overflow-hidden px-2"
                    id="btn-comments"
                    type="button">
                    <span class="data-text">Deja tu comentario</span>


                    <i class="bi bi-chat-left-text"></i>

                </button>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 left-0 right-0  py-2 px-2 bg-white z-[99999] flex md:hidden w-full justify-center items-center border-t">
   
        <div class="w-full flex justify-between gap-2">
                <div class="group relative flex items-center rounded-md">
                    <a href="./" class="group-hover:bg-gray-100 active:bg-gray-150  collapsed:w-8 transition-sidebar peer relative  w-full items-center  gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                        <div
                            class="collapsed:left-2 transition-sidebar  inset-2 gap-2 whitespace-nowrap flex flex-col justify-center items-center">
                            <i class="bi bi-house text-sm"></i>
                            <span >Inicio</span>
                        </div>
                    </a>
                </div>
                <div class="group relative flex items-center rounded-md">
                    <a class="group-hover:bg-gray-100 active:bg-gray-150  collapsed:w-8 transition-sidebar peer relative   w-full items-center  gap-2 overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900  "
                        data-state="closed" href="./setting">
                        <div
                            class="collapsed:left-2 transition-sidebar  inset-2 gap-2 whitespace-nowrap flex flex-col justify-center items-center">
                            <i class="bi bi-gear text-sm"></i>
                            <spa>Ajustes</spa>
                        </div>
                    </a>
                </div>
                <?php if ($tipo_user == 1 || $tipo_user == '1') { ?>
                    <div class="group relative flex items-center rounded-md">
                        <a
                            href="./students"
                            class=" group-hover:bg-gray-100 collapsed:w-8 transition-sidebar peer relative  w-full items-center  overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                            <div
                                class="collapsed:left-2 transition-sidebar  inset-2 gap-2  flex flex-col justify-center items-center whitespace-nowrap">
                                <i class="bi bi-people text-sm"></i>
                                <span >Estudiantes</span>
                            </div>
                        </a>
                    </div>
                    <div class="group relative flex items-center rounded-md">
                        <a
                            href="./cursos"
                            class="group-hover:bg-gray-100 collapsed:w-8 transition-sidebar peer relative  w-full items-center overflow-hidden rounded-lg px-2 text-left text-sm font-normal outline-none ring-blue-600 hover:text-zinc-900 ">
                            <div
                                class="collapsed:left-2 transition-sidebar flex flex-col justify-center items-center  inset-2 gap-2 whitespace-nowrap ">
                                <i class="bi bi-book text-sm"></i>
                                <span>Cursos</span>
                            </div>
                        </a>
                    </div>
                <?php } ?>
      
        </div>

     
    </div>
</aside>
<?php
require "./components/telegram.php";
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById("sidebar");
        const btnExpanded = document.getElementById("btnExpanded");
        const elementHidden = document.querySelectorAll(".data-text");
        const dataModal = document.getElementById("data-modal");
        const btnComments = document.getElementById("btn-comments");
        const logocontainer = document.getElementById("logocontainer");
        const logo = document.getElementById("logo");

        let barra = localStorage.getItem('barra') === 'true';

        function adjustSidebar() {
            if (!barra) {
                sidebar.style.setProperty('--sidebar-width', '49px');
                logo.style.display = "none";
                logocontainer.classList.remove('justify-between');
                logocontainer.classList.add('justify-center');
                elementHidden.forEach(element => element.style.display = "none");
                btnComments.classList.remove('justify-between', 'px-4');
                btnComments.classList.add('justify-center');
            } else {
                sidebar.style.setProperty('--sidebar-width', '231px');
                logo.style.display = "block";
                logocontainer.classList.add('justify-between');
                logocontainer.classList.remove('justify-center');
                elementHidden.forEach(element => element.style.display = "block");
                btnComments.classList.add('justify-between', 'px-2');
                btnComments.classList.remove('justify-center');
            }
        }

        adjustSidebar();

        btnExpanded.addEventListener('click', () => {
            barra = !barra;
            localStorage.setItem('barra', barra);
            adjustSidebar();
        });


    });
    let comments = false;

    const dataModal = document.getElementById("data-modal");

    function handleComment() {
        comments = !comments;
        if (comments) {
            dataModal.classList.remove("hidden");
            dataModal.classList.add("flex");
        } else {
            dataModal.classList.add("hidden");
            dataModal.classList.remove("flex");
        }
    }
</script>