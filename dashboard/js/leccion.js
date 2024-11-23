
const containerLecciones = document.getElementById("leccionescnt");
const cursoid = document.getElementById("cursoid").textContent.trim();
const userid = document.getElementById("userid").textContent.trim();
$(() => {
  getCourses();
});

function renderCourses(array) {
  containerLecciones.innerHTML = ""
  let firstElement = array[0];
  array.forEach(item => {
    containerLecciones.innerHTML += generateUILeccion(item, firstElement)
  }
  )
}
function generateUILeccion(item, firstElement) {
  let primeroBloqued = false;
  console.log(firstElement.estado);

  // Verificamos si el primer elemento tiene estado 0
  const esAccesible = firstElement.estado === 0 && item === firstElement;

  return `
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all duration-300 ring-2 ring-primary group" data-id="13">
      <a href="${item.estado === 1 || esAccesible ? `./verleccion.php?leccion=${item.id_leccion}&orden=${item.orden}&curso=${item.id_curso}` : '#'}"
        class="${item.estado === 0 && !esAccesible ? 'cursor-not-allowed' : 'cursor-pointer'}">
        <div class="flex flex-col space-y-1.5 p-6" data-id="14">
          <div class="flex items-center justify-between" data-id="15">
            <h3 class="font-semibold tracking-tight text-lg normal-case">${item.titulo}</h3>
            <i class="bi   ${item.estado === 1 ? 'bi-check2-circle text-green-500' : esAccesible ? 'bi-file-lock text-emerald-500' : 'bi-file-lock opacity-50 text-yellow-400'} text-2xl"></i>
          </div>
        </div>
        <div class="p-6 pt-0 overflow-hidden transition-all duration-300 max-h-96" data-id="17">
          <div class="flex flex-col md:flex-row gap-4" data-id="18">
            <img
              class="bg-slate-100 rounded object-cover w-[200px] h-[100px]"
              alt="${item.titulo}"
              src="./assets/img_leccion/${item.img_leccion}"
            >
            <div class="flex-grow" data-id="20">
              <p class="text-muted-foreground mb-2">${item.descripcion}</p>
              <div class="flex justify-between items-center" data-id="22">
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                  ${item.nombre} ${item.apellido}
                </div>
                <div
  class="inline-flex items-center rounded-full  px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring  
    ${item.estado === 1 ? 'bg-green-500 text-white' : esAccesible ? 'bg-emerald-500  text-zicn-900' : 'bg-yellow-400 opacity-50 '}"
  ${item.estado === 0 && !esAccesible ? 'disabled' : ''}
>
  ${item.estado === 1 ? 'Completado' : esAccesible ? 'Empieza ahora' : 'Pendiente'}
</div>

              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center px-6 h-0 group-hover:h-24 !group-hover:opacity-100 transition-all duration-300 overflow-hidden">
          <button
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full 
    ${item.estado === 1 ? 'bg-green-500 text-white' : esAccesible ? 'bg-emerald-500  text-zicn-900' : 'bg-yellow-500 hover:bg-yellow-600 text-black'}  
    "
            ${item.estado === 0 && !esAccesible ? 'disabled' : ''}
          >
                  ${item.estado === 1 ? 'Ver ahora' : esAccesible ? 'Empezar' : 'Pendiente'}

          </button>
        </div>
      </a>
    </div>`;
}

function getLeccion() {
  containerLecciones.innerHTML = "";

  for (let i = 0; i < 2; i++) {
    const skeleton = document.createElement("div");
    skeleton.className = "col-span-1 h-[220px] rounded-lg border bg-gray-200 animate-pulse";
    containerLecciones.appendChild(skeleton);
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
      console.log(response)
      if (!response.ok) {
        throw new Error('Error en la solicitud');
      }
      return response.json();
    })
    .then(data => {
      console.log(data)
      const { success, message } = data;
      if (success) {
        containerLecciones.innerHTML = "";
        renderCourses(message);
      } else {

        containerLecciones.innerHTML = "";
        errorData.textContent = message;
        containerLecciones.appendChild(errorData);
      }
    })
    .catch(error => {
      console.log(error)
      console.error('Hubo un problema con la solicitud Fetch:', error);
      // Limpiar el skeleton en caso de error
      containerLecciones.innerHTML = "";
    });
}
getLeccion();