const userId = $("#userIdHtml").text();
const suscripcion = $("#suscrupcion").text();
var userIdGlobal = parseInt(userId);
var suscripcionGlobal = parseInt(suscripcion);
$(() => {
  const id_user = $("#traerCursosBtn").data("id_user");
  traerCursos(id_user);
  getCursoCompleted(userIdGlobal);


  // Agrega un listener de evento al botón
  $("#traerCursosBtn").click(() => {
    traerCursos(id_user);
  });
});
async function traerCursos(id) {
  const mostrarCursos = $("#cursosMostrar");
  try {
    if (suscripcionGlobal == 1 || suscripcionGlobal == "1") {
      const favitems = await traerCursoFav(id); // Espera a que traerCursoFav() termine y devuelve los resultados
      const formData = new FormData();
      formData.append("action", "traercursos");
      $.ajax({
        url: "./conexion/actions.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          mostrarCursos.html(
            `<div class="rounded-lg border p-2 text-card-foreground shadow-sm my-4 text-black col-span-12 flex justify-center"><small class="text-sm text-muted-foreground">Cargando...</small></div>`
          );
        },
        success: (response) => {
          const result = response.message;
          let htmlContent = "";
          if (result && result.length >= 1) {
            result.map((item) => {
              const fav = favitems.find(
                (favItem) => favItem.idCurso == item.id
              );
              const comparar = fav
                ? `<button class="p-4" onclick="delFav(${item.id}, ${userIdGlobal});">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star-fill" viewBox="0 0 16 16">
                          <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                      </svg>
                  </button>`
                : `<button class="p-4" onclick="addFav(${item.id}, ${userIdGlobal})">     
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star" viewBox="0 0 16 16">
                          <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                      </svg>
                  </button>`;
              const elementoCurso = `
                  <div class="rounded-lg border bg-card text-card-foreground shadow-sm mb-4 col-span-12 p-2 relative z-10 bg-background-subtle bg-white" key="${item.id}">
                      <div class="grid grid-cols-12 p-4 md:gap-4">
                          <div class="col-span-12 md:col-span-3 items-center">
                              <div class="rounded">
                                  <img src="./assets/img/${item.imagen_curso}" alt="${item.titulo_curso}" class="rounded">
                              </div>
                          </div>
                          <div class="col-span-12 md:col-span-5 m-0 flex items-center">
                                  <div class="row m-0">
                                      <div class="col-8">
                                          <h3 class="text-2xl font-semibold leading-none tracking-tight text-black">${item.titulo_curso}</h3>
                                      </div>
                                      <div class="col-4">
                                          <div
                                              class="ct-porcen  row justify-content-center align-items-center h-100 w-100" id="starItems-${item.id}">
                                              ${comparar}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-span-12 md:col-span-4 mb-2 mt-2 d-flex justify-content-center align-items-center">
                                  <div class="flex w-full"><a href="./lecciones.php?idcr=${item.id}" class="inline-flex bg-black w-full items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full">Explorar </a></div>
                              </div>
                      </div>
                  </div>
                  `;
              htmlContent += elementoCurso;
            });

            mostrarCursos.html(htmlContent);
          } else {
            const elementosError = `
              <div class='bg-danger m-3'>
              <h3 class='text-black fs-5 m-0 p-0 titulo-curso text-white fw-normal text-center rounded-7 p-2'>${response.message}
              </h3>
              </div>
              `;
            htmlContent += elementosError;
            mostrarCursos.html(htmlContent);
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
    } else if (suscripcionGlobal == 0 || suscripcionGlobal == "0") {
      const favitems = await traerCursoFav(id); // Espera a que traerCursoFav() termine y devuelve los resultados
      const formData = new FormData();
      formData.append("action", "traercursosfree");
      $.ajax({
        url: "./conexion/actions.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          mostrarCursos.html(
            `<div class="rounded-lg border p-2 text-card-foreground shadow-sm my-4 text-black col-span-12 flex justify-center"><small class="text-sm text-muted-foreground">Cargando...</small></div>`
          );
        },
        success: (response) => {
          const result = response.message;
          let htmlContent = "";
          if (result && result.length >= 1) {
            result.map((item) => {
              const fav = favitems.find(
                (favItem) => favItem.idCurso == item.id
              );
              const comparar = fav
                ? `<button class="p-4" onclick="delFav(${item.id}, ${userIdGlobal});">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star-fill" viewBox="0 0 16 16">
                          <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                      </svg>
                  </button>`
                : `<button class="p-4" onclick="addFav(${item.id}, ${userIdGlobal})">     
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star" viewBox="0 0 16 16">
                          <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                      </svg>
                  </button>`;
              const elementoCurso = `
                  <div class="rounded-lg border bg-card text-card-foreground shadow-sm mb-4 col-span-12 p-2 relative z-10 bg-background-subtle bg-white" key="${item.id}">
                      <div class="grid grid-cols-12 p-4 gap-4">
                          <div class="col-span-12 md:col-span-4 items-center">
                              <div class="rounded">
                                  <img src="./assets/img/${item.imagen_curso}" alt="${item.titulo_curso}" class=" rounded">
                              </div>
                          </div>
                          <div class="col-span-12 md:col-span-4 m-0 flex items-center">
                                  <div class="grid grid-cols-12 m-0 w-full mt-2 md:mt-0 items-center">
                                      <div class="col-span-11 md:col-span-10">
                                          <h3 class="text-2xl font-semibold leading-none tracking-tight text-black">${item.titulo_curso}</h3>
                                      </div>
                                      <div class="col-span-1 md:col-span-2">
                                          <div
                                              class="" id="starItems-${item.id}">
                                              ${comparar}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-span-12 md:col-span-4 mb-2 mt-2 d-flex justify-content-center align-items-center">
                                  <div class="flex w-full"><a href="./lecciones.php?idcr=${item.id}" class="inline-flex bg-black w-full  items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full">Explorar </a></div>
                              </div>
                      </div>
                  </div>
                  `;
              htmlContent += elementoCurso;
            });

            mostrarCursos.html(htmlContent);
          } else {
            const elementosError = `
              <div class='col-span-12 flex justify-center'>
              <h3 class='text-sm text-muted-foreground'>${response.message}
              </h3>
              </div>
              `;
            htmlContent += elementosError;
            mostrarCursos.html(htmlContent);
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
    }
  } catch (error) {
    Toastify({
      close: true,
      text: "¡Error, intente de nuevo!",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
}
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
function traerCursoFav(id) {
  const mostrarCursos = $("#cursosMostrar");
  try {
    return new Promise((resolve, reject) => {
      const formData = new FormData();
      formData.append("action", "cursofav");
      formData.append("idUser", id);
      $.ajax({
        url: "./conexion/actions.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          mostrarCursos.html(
            `<div class="rounded-lg border p-2 text-card-foreground shadow-sm my-4 text-black col-span-12 flex justify-center"><small class="text-sm text-muted-foreground">Cargando...</small></div>`
          );
        },
        success: (response) => {
          const result = response.message;
          resolve(response.message);
          let htmlContent = "";
          if (result && result.length >= 1) {
            result.map((item, index) => {
              const elementoCurso = `
            <div class="col-span-12 rounded-lg border bg-card text-card-foreground shadow-sm mb-4 relative z-10 bg-background-subtle bg-white rounded-lg" key="${index}">
            <div class="grid grid-cols-12 items-center gap-4 p-4">
                <div class="col-span-12 md:col-span-3 items-center">
                    <div class="rounded">
                        <img src="./assets/img/${item.imagen_curso}" alt="${item.titulo_curso}" class="rounded">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4 m-0 flex items-center">
                        <div class="grid">
                            <div class="">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight text-black">${item.titulo_curso}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-4 mb-2 mt-2 d-flex justify-content-center align-items-center">
                    <div class="flex w-full"><a href="./lecciones.php?idcr=${item.id}" class="inline-flex w-full bg-black  w-full items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-opacity-60 h-10 px-4 py-2 w-full">Explorar </a></div>
                </div>
            </div>
        </div>
            `;
              htmlContent += elementoCurso;
            });
            mostrarCursos.html(htmlContent);
          } else {
            const elementosError = `
            <div class='col-span-12 flex justify-center'>
            <h3 class='text-sm text-muted-foreground'>Aún no tienes cursos favoritos            </h3>
            </div>
            `;
            htmlContent += elementosError;
            mostrarCursos.html(htmlContent);
          }
        },
        error: (xhr, status, error) => {
          Toastify({
            close: true,
            text: xhr.responseText,
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
          reject(error);
        },
      });
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
function addFav(id, iduser) {
  try {
    const starItems = $(`#starItems-${id}`);
    const formData = new FormData();
    formData.append("action", "addfav");
    formData.append("idCurso", id);
    formData.append("idUser", iduser);
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {},
      success: (response) => {
        Toastify({
          close: true,
          text: response.message,
          duration: 3000,
          backgroundColor: "#15803d",
        }).showToast();

        if (response.success == true) {
          const elementStar = `<button class="p-4" onclick="delFav(${id}, ${userIdGlobal});">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star-fill" viewBox="0 0 16 16">
          <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
      </svg>
      </button>`;
          starItems.html(elementStar);
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
function delFav(id, idUser) {
  const starItems = $(`#starItems-${id}`);
  try {
    const formData = new FormData();
    formData.append("action", "delfav");
    formData.append("idCurso", id);
    formData.append("idUser", idUser);
    $.ajax({
      url: "./conexion/actions.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => {},
      success: (response) => {
        htmlContent = "";
        Toastify({
          close: true,
          text: response.message,
          duration: 3000,
          backgroundColor: "#be185d",
        }).showToast();
        if (response.success === true) {
          const elementStar = `<button class="p-4" onclick="addFav(${id}, ${userIdGlobal});">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star" viewBox="0 0 16 16">
                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"></path>
                    </svg>
      </button>`;
          starItems.html(elementStar);
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
      beforeSend: () => {},
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