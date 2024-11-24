async function powerCourse(idCuso, estado) {
  const convertirEstado = parseInt(estado);

  if (convertirEstado == 1 || convertirEstado == "1") {
    const result = await desactivarCurso(idCuso, convertirEstado);
  } else {
    const desactivar = await activarCurso(idCuso, convertirEstado);
  }
}

function activarCurso(idcurso, estado) {
  try {
    const formData = new FormData();
    formData.append("action", "activarCurso");
    formData.append("idCurso", idcurso);
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {},
      success: (response) => {
        const result = response.success;
        if (result === true) {
          $(`#item_close-${idcurso}`)
            .html(`<button onclick="powerCourse(${idcurso},1)"  class="p-2 rounded  bg-amber-400 border-amber-400 text-black" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z"></path>
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"></path>
            </svg>
        </button>`);
          $(`#estadoCurso-${idcurso}`).html("Activo");
        } else {
          Toastify({
            close: true,
            text: response.message,
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
        }
      },
      error: (xhr, status, error) => {
        // console.log("XHR: ", xhr);
        // console.log("STATUS: ", status);
        // console.log("ERROR: ", error);
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
function desactivarCurso(idcurso, estado) {
  try {
    const formData = new FormData();
    formData.append("action", "desactivarCurso");
    formData.append("idCurso", idcurso);
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {},
      success: (response) => {
        const result = response.success;
        if (result == true) {
          $(`#item_close-${idcurso}`)
            .html(`<button onclick="powerCourse(${idcurso},0)"  class=" p-2 rounded bg-amber-200 text-black border-amber-200" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z"></path>
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"></path>
            </svg>
        </button>`);
          $(`#estadoCurso-${idcurso}`).html("Desactivado");
        } else {
          Toastify({
            close: true,
            text: response.message,
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
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
function updateCurso() {
  const namecurso = $("#nombrecurso").val();
  const instructor = $("#instructor").val();
  const fotocurso = $("#nuevafoto");
  const pIntCursoid = $("#idcursoHtml").text();
  function handleFileChange() {
    const archivos = $(this).prop("files");

    if (archivos.length === 0) {
      return Toastify({
        close: true,
        text: "Si desea actualizar el curso, ingrese una foto",
        duration: 3000,
        backgroundColor: "#be185d",
      }).showToast();
    } else {
      // Acceder al primer archivo seleccionado
      const archivo = archivos[0];
      return archivo;
    }
  }
  const archivo = handleFileChange.call(fotocurso[0]);
  // Verificar si se seleccionó un archivo
  if (!archivo) {
    return;
  }
  if (namecurso.length == 0) {
    return Toastify({
      close: true,
      text: "Ingresa el nombre del curso",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
  if (instructor.length == 0) {
    return Toastify({
      close: true,
      text: "Selecciona al instructor",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
  const formData = new FormData();
  formData.append("action", "updatecourse");
  formData.append("imagen", archivo);
  formData.append("nombre", namecurso);
  formData.append("instructor", instructor);
  formData.append("idcurso", pIntCursoid);
  try {
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {},
      success: (response) => {
        const result = response.success;
        if (result === true) {
          window.location.href = "./cursos.php";
        } else {
          return Toastify({
            close: true,
            text: response.message,
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
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
function addCurso() {
  const namecurso = $("#nombrecurso").val();
  const instructor = $("#instructor").val();
  const tipo = $("#tipo").val();
  const estado = $("#estado").val();
  const fotocurso = $("#imagen");

  // Validar archivo
  const archivos = fotocurso[0].files;
  if (archivos.length === 0) {
      Toastify({
          close: true,
          text: "Se necesita una imagen del curso",
          duration: 3000,
          backgroundColor: "#be185d",
      }).showToast();
      return;
  }

  if(namecurso.length == 0 || namecurso.length == null){
    return Toastify({
        close: true,
        text: "Ingresa el nombre del curso",
        duration: 3000,
        backgroundColor: "#be185d",
    }).showToast();
}

if(instructor.length == 0 || instructor.length == null){
    return Toastify({
        close: true,
        text: "Selecciona al instructor",
        duration: 3000,
        backgroundColor: "#be185d",
    }).showToast();
}

  const formData = new FormData();
  formData.append("action", "newcurso");
  formData.append("imagen", archivos[0]);
  formData.append("nombre", namecurso);
  formData.append("instructor", instructor);
  formData.append("tipo", tipo);
  formData.append("estado", estado);

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
            console.log(response)
              const result = response.success;
            
              if (result === true) {
                  window.location.href = `./cursos.php`;
              } else {
                  Toastify({
                      close: true,
                      text: response.message,
                      duration: 3000,
                      backgroundColor: "#be185d",
                  }).showToast();
              }
          },
          error: (xhr, status, error) => {
              Toastify({
                  close: true,
                  text: xhr.responseText,
                  duration: 3000,
                  backgroundColor: "#be185d",
              }).showToast();
              console.log("XHR", xhr);
              console.log("XHR", status);
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
