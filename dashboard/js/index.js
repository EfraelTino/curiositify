
const userId = $("#userIdHtml").text();
const suscripcion = $("#suscrupcion").text();
const containerCourses = document.getElementById('data_cursos');
var userIdGlobal = parseInt(userId);
var suscripcionGlobal = parseInt(suscripcion);
$(() => {
  getCursoCompleted(userIdGlobal);

  getCourses();
});

function buscarCurso() {
  const searchItem = $("#inputsearch").val();
  const contCursos = $("#result_modal");
  if (!searchItem || searchItem == undefined || searchItem == null) {
    Toastify({
      text: "Ingresa el nombre de un curso",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
    return;
  }
  const formData = new FormData();
  formData.append("action", "searchcouser");
  formData.append("searchData", searchItem);

  try {
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {
        Toastify({
          close: true,
          text: "Cargando...",
          duration: 3000,
          backgroundColor: "#00f059",
        }).showToast();
      },
      success: (response) => {
        let htmlContent = "";
        if (response.success === true) {
          const result = response.message;
          result.map((item, index) => {
            const elementosCurso = `<div key='${index}' class='rounded-lg border bg-card text-card-foreground p-4 shadow-sm items-center mb-2 flex grid grid-cols-12 gap-2'>
                <div class='col-span-2'>
                    <div class='card-img'>
                        <img src='./assets/img/${item.imagen_curso}' alt='${item.titulo_curso}'>
                    </div>
                </div>
                <div class='col-span-6 m-0 p-0  items-center'>
                    <div class='row align-items-center'>
                        <div class='col-12 grid items-center'>
                            <h3 class='text-xl text-black font-semibold leading-none tracking-tight'>${item.titulo_curso}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class='col-span-4 row justify-content-center align-items-center'>
                    <a href='lecciones.php?idcr=${item.id}' class='inline-flex  bg-black  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full'>Continuar</a>
                </div>
            </div>`;
            htmlContent += elementosCurso;
          });
          contCursos.html(htmlContent);
        } else {
          Toastify({
            close: true,
            text: response.message,
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
          const elementosError = `
          <div class='bg-danger m-3'>
          <h3 class='text-black fs-5 m-0 p-0 text-white fw-normal text-center rounded-7 p-2'>${response.message}
          </h3>
          </div>
          `;
          htmlContent += elementosError;
          contCursos.html(htmlContent);
          $("#inputsearch").val("");
        }
      },
      error: (xhr, status, error) => {
        Toastify({
          close: true,
          text: xhr.responseText,
          duration: 3000,
          backgroundColor: "#be185d",
        }).showToast();
      },
    });
  } catch (error) {
    Toastify({
      close: true,
      text: "¡Error, intente de nuevo!",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
}


function getCursoCompleted(iduser) {
  const mostrarCompleto = $("#dataCompleted");
  try {
    const formData = new FormData();
    formData.append("action", "getcompletedcurso");
    formData.append("iduser", iduser);
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => { },
      success: (response) => {
        const result = response.message;
        mostrarCompleto.html(result.length);
      },
      error: (xhr, status, error) => {
        Toastify({
          close: true,
          text: xhr.responseText,
          duration: 3000,
          backgroundColor: "#be185d",
        }).showToast();
      },
    });
  } catch (error) {
    Toastify({
      close: true,
      text: "¡Error, intente de nuevo!",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
}

function renderCouser(item) {
  return ` <a class="col-span-1 md:col-span-1 h-full overflow-hidden" href="./lecciones.php?idcr=${item.id}">
        <div class="rounded-lg border bg-card text-card-foreground overflow-hidden shadow-sm flex flex-col">
            <div class="flex flex-col space-y-1.5 relative z-10 bg-background-subtle bg-white rounded-lg">
                <img 
  class="rounded-t-lg transform transition-transform bg-gray-200 duration-500 hover:scale-105" 
  style="aspect-ratio: 300 / 200; object-fit: cover;" 
  src="./assets/img/${item.imagen_curso}" 
  alt="${item.titulo_curso}"
>
                <div class="card-body p-4 ">
                    <h5 class="text-2xl font-semibold leading-none tracking-tight  text-black">
                        ${item.titulo_curso}</h5>
                    <p class="m-0 p-0">
                        <span class="text-sm text-muted-foreground">${item.nombre + ' ' + item.apellido}</span></p>
                    <div class="inline-flex mt-6 bg-zinc-900  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 hover:bg-zinc-800  h-10 px-4 py-2 w-full">Explorar</div>
                </div>
            </div>
        </div>
    </a>`
}
function renderCourses(array) {
  containerCourses.innerHTML = ""
  array.forEach(item =>
    containerCourses.innerHTML += renderCouser(item)
  )
}

function getCourses() {
  containerCourses.innerHTML = "";

  for (let i = 0; i < 2; i++) {
    const skeleton = document.createElement("div");
    skeleton.className = "col-span-1 h-[220px] rounded-lg border bg-gray-200 animate-pulse";
    containerCourses.appendChild(skeleton);
  }
  const errorData = document.createElement("p");
  errorData.className = "text-red-500 font-bold text-center col-span-2"
  let data = new FormData();
  data.append('action', 'getcourses');
  data.append('suscripcion', suscripcion);

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
      console.log(data)
      const { success, message } = data;
      if (success) {
        containerCourses.innerHTML = "";
        renderCourses(message);
      } else {

        containerCourses.innerHTML = "";
        errorData.textContent = message;
        containerCourses.appendChild(errorData);
      }
    })
    .catch(error => {
      console.error('Hubo un problema con la solicitud Fetch:', error);
      // Limpiar el skeleton en caso de error
      containerCourses.innerHTML = "";
    });
}
