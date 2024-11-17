const cntLecciones = document.getElementById("leccionescnt");
const containerClase = document.getElementById("renderclase");
const cursoid = document.getElementById("cursoid").textContent.trim();
const userid = document.getElementById("userid").textContent.trim();
const leccionid = document.getElementById("leccionid").textContent.trim();
$(() => {

    getLeccion();
    generateUICourse();
});

function getLeccion() {
    cntLecciones.innerHTML = "";

    for (let i = 0; i < 2; i++) {
        const skeleton = document.createElement("div");
        skeleton.className = "col-span-1 h-[220px] rounded-lg border bg-gray-200 animate-pulse";
        cntLecciones.appendChild(skeleton);
    }
    const errorData = document.createElement("p");
    errorData.className = "text-red-500 font-bold text-center col-span-2"
    let data = new FormData();
    data.append('action', 'getleccionofcourse');
    data.append('idcurso', cursoid);
    data.append('idusuario', userid);

    fetch('./conexion/peticions.php', {
        body: data,
        method: 'post'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {
            const { success, message } = data;
            if (success) {

                cntLecciones.innerHTML = "";
                containerClase.innerHTML = "";
                containerClase.innerHTML += generateUICourse(message);

                renderItems(message);
            } else {

                cntLecciones.innerHTML = "";
                errorData.textContent = message;
                cntLecciones.appendChild(errorData);
            }
        })
        .catch(error => {
            console.log(error)
            console.error('Hubo un problema con la solicitud Fetch:', error);
            // Limpiar el skeleton en caso de error
            cntLecciones.innerHTML = "";
        });
}

function renderItems(array) {
    cntLecciones.innerHTML = ""
    post = 0;
    array.forEach(item => {
        post++;
        cntLecciones.innerHTML += generateUILeccion(item, post)
    }
    )
}
function generateUILeccion(item, firstElement) {

    cntLecciones.classList.add(item.estado === 1 ? 'border-green-500' : 'border-slate-300');

    return `
    <li class="mb-10 ml-8 p-1 ${item.estado === 1 ? 'bg-green-50 rounded ' : ' '}">
    <span
        class="absolute flex items-center justify-center w-8 h-8 rounded-full -left-4 ring-4 ${item.estado === 1 ? 'bg-green-500  ring-green-600' : 'bg-slate-200 ring-slate-300'}">
        <span class="font-semibold  ${item.estado === 1 ? ' text-white ' : ' text-slate-300 '}">
${firstElement}</span></span> 
    <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900">${item.titulo}</h3>
    <p class=" text-sm font-normal  text-gray-400" >${item.descripcion}
    </p>
</li>
    `;
}

function generateUICourse(message) {
    const getClase = message.filter(item => {
        return item.id_leccion == parseInt(leccionid);
    });

    const currentLeccion = getClase[0]; // La lección actual
    const currentIndex = message.findIndex(item => item.id_leccion === currentLeccion.id_leccion); // Encuentra el índice de la lección actual
    const nextLeccion = message[currentIndex + 1]; // La siguiente lección
    const prevLeccion = message[currentIndex - 1]; // La lección anterior

    // Verifica si hay lecciones previas o siguientes
    const hasPrevious = currentIndex > 0;
    const hasNext = currentIndex < message.length - 1;

    let nextButtonAction = hasNext ? `./verleccion?leccion=${nextLeccion.id_leccion}&orden=${nextLeccion.orden}&curso=${nextLeccion.curso_id}` : `./felicitaciones?idc=${cursoid}`; // Si hay siguiente, lo lleva a la siguiente lección, de lo contrario a felicitaciones
    let prevButtonAction = hasPrevious ? `./verleccion?leccion=${prevLeccion.id_leccion}&orden=${prevLeccion.orden}&curso=${prevLeccion.curso_id}` : '#'; // Si hay anterior, lo lleva a la lección anterior, de lo contrario no hace nada
    let prevButtonDisabled = !hasPrevious; // Si no hay lección anterior, deshabilitamos el botón "Atrás"

    console.log("Lección actual:", currentLeccion);
    console.log("Lección anterior:", prevLeccion);
    console.log("Lección siguiente:", nextLeccion);

    return `
    <div class="rounded-lg border bg-white  shadow-sm mb-4">
        <iframe class="w-full aspect-video rounded-md"
                src="https://www.youtube.com/embed/${extractVideoId(currentLeccion.video_url)}"
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen
                title="Descripción del video"
                loading="lazy"></iframe>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4 rounded-lg">
            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full sm:w-auto"
                    ${prevButtonDisabled ? 'disabled' : ''} onclick="window.location.href='${prevButtonAction}'"><i class="bi bi-arrow-left"></i> Atrás</button>
            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 px-4 py-2 w-full sm:w-auto bg-green-500 bg-green-00 text-white"
                    onclick="window.location.href='${nextButtonAction}'">Siguiente clase <i class="bi bi-arrow-right"></i></button>
        </div>
    </div>
    `;
}


// Función para extraer el video ID de la URL de YouTube
function extractVideoId(url) {
    const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/(\S+))|youtu\.be\/(\S+)/;
    const match = url.match(regex);
    return match ? match[1] || match[2] : null;
}
