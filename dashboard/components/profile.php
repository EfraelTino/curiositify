

<!-- Modal -->
<div class="modal fade fixed" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-lg font-semibold leading-none tracking-tight text-black" id="staticBackdropLabel">Busca tu curso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="relative">
                        <form class="d-flex" role="search">
                            <input class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm ring-offset-background placeholder:text-gray-400 text-black cursor-text focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 pr-16" type="search" placeholder="Buscar curso" id="inputsearch" aria-label="Search">
                            <button class="absolute right-0 top-0 h-full px-4 bg-[#F3C623] text-white rounded-md" type="button" onclick="buscarCurso();">Buscar</button>
                        </form>
                    </div>


                </div>
                <span class="text-black">Reultado de búsqueda:</span>
                <div class="w-full">
                    <div>
                        <div class="result" id="result_modal">
                            <div class="rounded-lg border p-2 bg-card text-card-foreground shadow-sm mb-4">

                                <small class="text-sm text-gray-400 ">Resultados de búsqueda</small>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="inline-flex mt-6 bg-gray-200  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 text-gray-600  hover:bg-opacity-60 h-10 px-4 py-2" data-bs-dismiss="modal">Cerrar </button>
                <button type="button" class=" inline-flex mt-6 bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-opacity-60 h-10 px-4 py-2">Aceptar</button>
            </div>
        </div>
    </div>
</div>