<section class="fixed top-0 left-0 bg-zinc-700   bg-opacity-50 right-0 bottom-0 flex justify-center z-[100] hidden  items-center" id="data-modal" onclick="handleComment();">
    <div class="border-alpha-400 relative bg-white z-[101] relative rounded-xl border shadow-lg  max-w-[300px] transition-colors p-3" id="modal-content">
        <h2 class="text-xl font-bold text-black text-center" data-id="2">Buzón de sugerencias</h2>
        <p class="mb-4 text-sm text-muted-foreground text-center">¿Tienes dudas, comentarios o sugerencias para mejorar? ¡Estoy atento a tus recomendaciones para hacer esta plataforma aún mejor!</p>
        <div>
            <div id="comentarios" class="max-h-[240px] overflow-y-scroll"></div>
            <form class="border-t pt-2 relative" id="mensajesFormulario">
                <div class="flex items-center gap-2" data-id="12">
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background text-zinc-950 placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 flex-grow" placeholder="Escribe tu mensaje..." data-id="13" type="text" value="">
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0  absolute top-2 right-0 bg-zinc-950 hover:bg-primary/90 h-10 w-10" type="submit" data-id="14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4" data-id="15">
                            <path d="m22 2-7 20-4-9-9-4Z"></path>
                            <path d="M22 2 11 13"></path>
                        </svg>
                        <span class="sr-only" data-id="16">Enviar mensaje</span>
                    </button>
                </div>
            </form>
            <div id="resultado" class="text-center text-sm"></div>
        </div>
    </div>
</section>

<script>
    var contComentarios = document.getElementById("comentarios");
    document.addEventListener("DOMContentLoaded", () => {
        traerComentarios();

    });    const modalContent = document.getElementById("modal-content");

   // Agregar el evento click al contenido del modal
   modalContent.addEventListener('click', function(event) {
        event.stopPropagation();  // Evita que el clic se propague al fondo
    });

    function comentariosUI(comment) {
        console.log(comment)
        return `
            <div class="flex justify-start mb-2" data-id="5">
                <div class="flex w-full" data-id="6">
                    <div class="bg-muted px-4 py-2 rounded-lg w-full" data-id="9">
                        <p class="text-sm text-black" data-id="10">${comment.sugerencia}</p>
                    </div>
                </div>
            </div>
        `;
    }

    function traerComentarios() {
        try {
            const formData = new FormData();
            formData.append("action", "getcomentarios");

            // Usamos fetch para hacer la solicitud POST
            fetch("./conexion/actions.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok " + response.statusText);
                    }
                    return response.json(); // Convierte la respuesta a JSON
                })
                .then((result) => {
                    console.log(result.message);
                    if (result.message == null) {
                        contComentarios.innerHTML = "<p class='text-black text-center mb-4 font-bold'>No se encontraron comentarios</p>";
                    } else {
                        renderizarComentarios(result.message); // Asume que `result.comments` es un array
                    }
                })
                .catch((error) => {
                    console.log("There has been a problem with your fetch operation:", error);
                });

        } catch (error) {
            console.log("Error:", error);
        }
    }


    function renderizarComentarios(array) {
        contComentarios.innerHTML = "";
        array.forEach((element) => {
            contComentarios.innerHTML += comentariosUI(element);
        });
    }
    document.getElementById('mensajesFormulario').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        const commentInput = document.querySelector('input[type="text"]');
        const comentario = commentInput.value.trim(); // Get and trim the input value
        const resultadoDiv = document.getElementById('resultado');

        // Check if the comment is empty
        if (!comentario) {
            resultadoDiv.innerText = "Ingresa un comentario";
            resultadoDiv.classList.add('text-red-500'); // Class for red color
            return; // Stop execution if comment is invalid
        }

        const formData = new FormData();
        formData.append("action", "addcomentario");
        formData.append("comentario", comentario);

        // Send data to PHP file
        fetch("./conexion/actions.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.json(); // Convert response to JSON
            })
            .then((result) => {
                console.log(result);

                if (result.success) { // Check if the comment was added successfully
                    // Add the new comment to the UI
                    const newComment = {
                        sugerencia: comentario
                    };
                    contComentarios.innerHTML += comentariosUI(newComment); // Add the new comment to `#comentarios`

                    // Clear input field and any error message
                    commentInput.value = "";
                    resultadoDiv.innerText = "";
                    resultadoDiv.classList.remove('text-red-500'); // Remove error class
                    resultadoDiv.classList.add('text-green-500'); // Success color class
                    resultadoDiv.innerText = "Comentario enviado con éxito"; // Success message
                } else {
                    resultadoDiv.innerText = "Hubo un error al enviar tu comentario.";
                    resultadoDiv.classList.add('text-red-500'); // Error color class
                }
            })
            .catch((error) => {
                console.log("There has been a problem with your fetch operation:", error);
                resultadoDiv.innerText = "Hubo un error al enviar tu mensaje. Inténtalo de nuevo.";
                resultadoDiv.classList.add('text-red-500'); // Error color class
            });
    });

    function addSugestion({
        comentario
    }) {
        try {
            const formData = new FormData();
            formData.append("action", "addcomentario");
            formData.append("comentario", comentario);

            // Usamos fetch para hacer la solicitud POST
            fetch("./conexion/actions.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok " + response.statusText);
                    }
                    return response.json(); // Convierte la respuesta a JSON
                })
                .then((result) => {
                    console.log(result.message);
                    if (result.message == 0) {
                        contComentarios.innerHTML = "<p class='text-black text-center mb-4 font-bold'>No se encontraron comentarios</p>";
                    } else {
                        renderizarComentarios(result.message); // Asume que `result.comments` es un array
                    }
                })
                .catch((error) => {
                    console.log("There has been a problem with your fetch operation:", error);
                });

        } catch (error) {
            console.log("Error:", error);
        }
    }
</script>