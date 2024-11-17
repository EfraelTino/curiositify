$(() => {
  // Click en el paginado
  addImage();
  console.log("antes A AJX");
  $(document).on("click", ".pagination li a", function (evt) {
    evt.preventDefault();
    ajaxLoad($(this).data("page"));
  });

  // Cambio de valor
  $("#amount_show").change(function (evt) {
    evt.preventDefault();
    ajaxLoad(1); 
  });
  const datastudent = $("#data-cantidad");
  ajaxLoad(1);
  function ajaxLoad(page) {
    const formData = new FormData();
    formData.append("action", "getstudents");
    formData.append("page", page);
    formData.append("amount_show", $("#amount_show").val());
    // formData.append("customer", $("#customer").val());
    let endpoint = "./conexion/students.php";
    $.ajax({
      url: endpoint,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => { },
      success: (response) => {
        let rows = "";
        let pos = 0;
        users = response.records;
        datastudent.html(`Total: <strong>${users.length}</strong> Usuarios registrados`)
        for (let i = 0; i < users.length; i++) {
          pos++;
          rows += `
                 <tr class="border-b transition-colors hover:bg-gray-50">
  <td class="p-4 align-middle text-black font-medium">
    ${pos}
  </td>
  <td class="p-4 align-middle text-black">
    <img
      class="card-img object-fit-cover"
      style="width: 50px; height: 50px"
      src="./assets/users/${users[i].imagen_profile}"
      alt="${users[i].nombre} ${users[i].apellido}"
    />
  </td>
  <td class="p-4 align-middle text-black">
    <p class="titulo-curso m-0 p-0 text-black">
      ${users[i].nombre} ${users[i].apellido}
    </p>
  </td>
  <td class="p-4 align-middle text-black">${users[i].email}</td>
  <td class="p-4 align-middle text-black">
    ${users[i].telf == ""
              ? "<small class='text-black'>N/A</small>"
              : users[i].telf
            }
  </td>
  <td class="p-4 align-middle text-black">
    <p class="m-0 p-0 text-black" id="suscripcion-${users[i].id}">
      ${users[i].is_premium == 0 ? "Free" : "Premium"}
    </p>
  </td>
  <td class="p-4 align-middle text-black">
    <p class="text-black" id="fecha_student-${users[i].id}">
      ${users[i].fecha == ""
              ? "<small class='text-black'>No especificado</small>"
              : `<small class="text-black">${users[i].fecha}</small>`
            }
    </p>

    <p></p>
  </td>
  <td class="p-4 align-middle text-black">
    <div id="item_student-${users[i].id}">
      ${users[i].is_premium == 0
              ? `<button
        onclick="powerUser(${users[i].id},${users[i].is_premium})"
      class=" p-2 rounded bg-amber-200 text-black border-amber-200">
      
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="black"
          class="bi bi-power"
          viewBox="0 0 16 16"
        >
          <path d="M7.5 1v7h1V1z"></path>
          <path
            d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"
          ></path>
        </svg></button
      >`
              : `<button
        onclick="powerUser(${users[i].id},${users[i].is_premium})"
        class="p-2 rounded  bg-amber-400 border-amber-400 text-black"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="black"
          class="bi bi-power"
          viewBox="0 0 16 16"
        >
          <path d="M7.5 1v7h1V1z"></path>
          <path
            d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"
          ></path>
        </svg></button
      >`
            }
    </div>
  </td>

  <td class="p-4 align-middle text-black"></td>
</tr>
`;
        }
        $("#tbody-insert").html(rows);

        // Creamos el paginado
        $("#tfoot-paging").html(
          createPaging({
            url: endpoint,
            current_page: response.current_page,
            total_records: response.total_records,
            records_by_page: response.records_by_page,
          })
        );
      },
      error: (xhr, status, error) => {
        console.log("xhr: ", xhr);
        console.log("status: ", status);
        console.log("error: ", error);
      },
    });
  }

  // Funcion para crear el paginado según la configruación recibida
  function createPaging(data) {
    let html = '<div class="pagination"><ul class="pagination">',
      total_pages = Math.ceil(data.total_records / data.records_by_page);

    if (data.current_page > 1) {
      html += `<li><a data-page="1"><i class="icon-angle-double-arrow"></i></a></li>
              <li><a data-page="${data.current_page - 1
        }"><i class="icon-angle-left"></i></a></li>`;
    }

    for (let i = 1; i <= total_pages; i++) {
      if (data.current_page == i) {
        html += `<li><a class="page-link active">${i}</a></li>`;
      } else {
        html += `<li><a class="page-link" data-page="${i}">${i}</a></li>`;
      }
    }

    if (data.current_page < total_pages) {
      html += `<li><a class="page-link" data-page="${data.current_page + 1
        }"><i class="icon-angle-right"></i></a></li>
              <li><a class="page-link" data-page="${total_pages}"><i class="icon-angle-double-right"></i></a></li>`;
    }

    html += "</ul></div>";
    return html;
  }
});
async function powerUser(iduser, estado) {
  const convertirEstado = parseInt(estado);

  if (convertirEstado == 1 || convertirEstado == "1") {
    const result = await desactivarusuario(iduser, convertirEstado);
    console.log("entro a estado 1");
  } else {
    const desactivar = await acativarusuario(iduser, convertirEstado);
    console.log("entro a estado 0");
  }
}

function acativarusuario(id, estado) {
  const date = moment();
  const formattedDate = date.format("DD MMM YYYY");
  console.log(formattedDate);
  console.log("actuviar usuario");
  try {
    const formData = new FormData();
    formData.append("action", "activarusuario");
    formData.append("idusuario", id);
    $.ajax({
      url: "./conexion/students.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => { },
      success: (response) => {
        console.log(response);
        const result = response.success;
        // console.log(response);
        if (result == true) {
          $(`#fecha_student-${id}`).html(
            `<small class="text-black">${formattedDate}</small>`
          );
          $(`#item_student-${id}`)
            .html(`<button onclick="powerUser(${id},1)"  class="p-2 rounded  bg-amber-400 border-amber-400 text-black" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
        <path d="M7.5 1v7h1V1z"></path>
        <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"></path>
      </svg>
              </button>`);
          $(`#suscripcion-${id}`).html("Premium");
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
        console.log("XHR: ", xhr);
        console.log("STATUS: ", status);
        console.log("ERROR: ", error);
        // Toastify({
        //   close: true,
        //   text: xhr.responseText,
        //   duration: 3000,
        //   backgroundColor: "#be185d",
        // }).showToast();
      },
    });
  } catch (error) {
    console.log("Error en catch: ", error);
    // Toastify({
    //   close: true,
    //   text: "¡Error, intente de nuevo!",
    //   duration: 3000,
    //   backgroundColor: "#be185d",
    // }).showToast();
  }
}
function desactivarusuario(id, estado) {
  console.log("DESACTIVAR USUARIO");
  console.log("USUARIO ID: ", id, " ESTADO DE USUARIO: ", estado);
  try {
    const formData = new FormData();
    formData.append("action", "desactivarusuario");
    formData.append("iduser", id);
    $.ajax({
      url: "./conexion/students.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: () => { },
      success: (response) => {
        const result = response.success;
        console.log(response);
        if (result == true) {
          $(`#item_student-${id}`)
            .html(`<button onclick="powerUser(${id},0)"  class=" p-2 rounded bg-amber-200 text-black border-amber-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-power" viewBox="0 0 16 16">
            <path d="M7.5 1v7h1V1z"></path>
            <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"></path>
          </svg>
          </button>`);
          $(`#suscripcion-${id}`).html("Free");
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
        console.log("XHR: ", xhr);
        console.log("STATUS: ", status);
        console.log("ERROR: ", error);
        // Toastify({
        //   close: true,
        //   text: xhr.responseText,
        //   duration: 3000,
        //   backgroundColor: "#be185d",
        // }).showToast();
      },
    });
  } catch (error) {
    console.log("Error en catch: ", error);
    // Toastify({
    //   close: true,
    //   text: "¡Error, intente de nuevo!",
    //   duration: 3000,
    //   backgroundColor: "#be185d",
    // }).showToast();
  }
}
const notImage = () => {
  $("#formdara").html(`
<div class="space-y-2 mb-3">
  <label
    for="titulo"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Título</label
  >
  <input
    type="text"
    class="flex  w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    id="titulo"
    name="titulo"
    placeholder="Ingresa un título al anuncio"
    required
  />
</div>
<div class="space-y-2 mb-3">
  <label
    for="descripcion"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Descripción</label
  >
  <textarea
    class="flex  w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    name="descripcion"
    id="descripcion"
    placeholder="Ingresa una descripción"
    rows="3"
  ></textarea>
</div>
<div class="space-y-2 mb-3">
  <label
    for="estado"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Estado del anuncio</label
  >
  <select
    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-black"
    aria-label="Default select example"
    id="estado"
    required
    name="estado"
  >
    <option class="text-black" value="1">Activo</option>
    <option class="text-black" value="0">Desactivo</option>
  </select>
</div>
<div class="space-y-2 mb-3">
  <label
    for="enlace"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Enlace de redirección</label
  >
  <input type="text"  id="enlace" name="enlace"     class="flex  w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    name="descripcion"
    id="descripcion"
    placeholder="Ingresa un Link de redirección" required />
</div>
<button
  type="button"
  onclick="addAnuncio(1);"
  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black text-white hover:bg-opacity-50 h-10 px-4 py-2"
>
  Guardar Anuncio
</button>

                                            `);
};
const addImage = () => {
  $("#formdara").html(`

                                           <div class="space-y-2 mb-3">
  <label
    for="nuevafoto"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Foto del anuncio recomendado:
    <strong class="text-danger">720*720px </strong> || Extensiones
    <strong class="text-danger">.JPG - .JPEG - .WEBP </strong></label
  >
  <input
    type="file"
    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    id="nuevafoto"
    name="nuevafoto"
    accept=".jpg, .jpeg, .png, .webp"
    required
  />
</div>
<div class="space-y-2 mb-3">
  <label
    for="titulo"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Título</label
  >
  <input
    type="text"
    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    id="titulo"
    name="titulo"
    placeholder="Título del anuncio"
    required
  />
</div>
<div class="space-y-2 mb-3">
  <label
    for="descripcion"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Descripción</label
  >
  <textarea
    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-500"
    placeholder="Ingresa una descripción"
    name="descripcion"
    id="descripcion"
    rows="3"
  ></textarea>
</div>
<div class="space-y-2 mb-3">
  <label
    for="estado"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Estado del anuncio</label
  >
  <select
    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black text-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    aria-label="Default select example"
    id="estado"
    required
    name="estado"
  >
    <option class="text-black" value="1">Activo</option>
    <option class="text-black" value="0">Desactivo</option>
  </select>
</div>
<div class="space-y-2 mb-3">
  <label
    for="enlace"
    class="text-sm font-medium leading-none text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >Enlace de redirección</label
  >
  <input
    type="text"
    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none text-black focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    placeholder="Ingresa un Link de redirección"
    id="enlace"
    name="enlace"
    required
  />
</div>
<button
  type="button"
  onclick="addAnuncio(2);"
  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black text-white hover:bg-opacity-50 h-10 px-4 py-2"
>
  Guardar Anuncio
</button>
`);
};
const addAnuncio = (param) => {
  const fotocurso = $("#nuevafoto");
  const titulo = $("#titulo").val();
  const descripcion = $("#descripcion").val();
  const estado = $("#estado").val();
  const enlace = $("#enlace").val();
  const userIdHtml = $("#userIdHtml").html();
  const formData = new FormData();
  if (titulo.length == 0 || titulo.length == null) {
    return Toastify({
      close: true,
      text: "Ingresa un título al anuncio",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
  if (param == "2" || param == 2) {
    function handleFileChange() {
      const archivos = $(this).prop("files");

      if (archivos.length === 0) {
        return Toastify({
          close: true,
          text: "Se necesita una imagen para el anuncio",
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
    if (!archivo) {
      return;
    }
    formData.append("action", "newanuncio1");
    formData.append("titulo", titulo);
    formData.append("descripcion", descripcion);
    formData.append("estado", estado);
    formData.append("enlace", enlace);
    formData.append("imagen", archivo);
    formData.append("userIdHtml", userIdHtml);
    try {
      $.ajax({
        url: "./conexion/students.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          return Toastify({
            close: true,
            text: "Cargando...",
            duration: 3000,
            backgroundColor: "#00f059",
          }).showToast();
        },
        success: (response) => {
          if (response.success == true) {
            window.reload();
          } else {
            return Toastify({
              close: true,
              text: "Error al crear el anuncio",
              duration: 3000,
              backgroundColor: "#be185d",
            }).showToast();
          }
        },

        error: (xhr, status, error) => {
          // console.log("XHR", xhr);
          // console.log("STATUS", status);
          // console.log("ERROR", error);
          Toastify({
            close: true,
            text: "¡Error, intente de nuevo!",
            duration: 3000,
            backgroundColor: "#be185d",
          }).showToast();
        },
      });
    } catch (error) {
      // console.log(error);
      Toastify({
        close: true,
        text: "¡Error, intente de nuevo!",
        duration: 3000,
        backgroundColor: "#be185d",
      }).showToast();
    }
  } else if (param == "1" || param == 1) {
    formData.append("action", "newanuncio2");
    formData.append("titulo", titulo);
    formData.append("descripcion", descripcion);
    formData.append("estado", estado);
    formData.append("enlace", enlace);
    formData.append("userIdHtml", userIdHtml);
    try {
      $.ajax({
        url: "./conexion/students.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          return Toastify({
            close: true,
            text: "Cargando...",
            duration: 3000,
            backgroundColor: "#00f059",
          }).showToast();
        },
        success: (response) => {
          if (response.success == true) {
            window.reload();
          } else {
            return Toastify({
              close: true,
              text: "Error al crear el anuncio",
              duration: 3000,
              backgroundColor: "#be185d",
            }).showToast();
          }
        },
        error: (xhr, status, error) => {
          // console.log("XHR", xhr);
          // console.log("STATUS", status);
          // console.log("ERROR", error);
          Toastify({
            close: true,
            text: "¡Error, intente de nuevo!",
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
  } else {
    Toastify({
      close: true,
      text: "¡Error, intente de nuevo!",
      duration: 3000,
      backgroundColor: "#be185d",
    }).showToast();
  }
};
