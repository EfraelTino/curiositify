

var response = "";


function isValidEmail(email) {
    // Expresión regular para validar el formato del correo electrónico
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}
function validCantCampos(campo, cantidad) {
    return campo.trim().length >= cantidad || undefined;
}
function crearCuenta() {
    // VALIDAR EMAIL
    
    const nombre = $("#nombres").val();
    const apellidos = $("#apellidos").val();
    const correo = $("#correo").val();
    const password = $("#password").val();
    const repeat_password = $("#repeat_password").val();
    if (!validCantCampos(nombre, 2)) {
        Toastify({
            text: "Por favor ingrese un nombre válido",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    if (!validCantCampos(apellidos, 4)) {
        Toastify({
            text: "Por favor ingrese un apellido válido",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    if (!isValidEmail(correo)) {
        Toastify({
            text: "Por favor ingrese un correo válido",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    if (!validCantCampos(password, 5)) {
        Toastify({
            text: "La contraseña debe ser mayor a 6 dígitos",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    if (!validCantCampos(repeat_password, 5)) {
        Toastify({
            text: "Repite nuevamente la contraseña",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    if (password != repeat_password) {
        Toastify({
            text: "Las contraseñas no coindicen",
            duration: 3000,
            backgroundColor: "#be185d"
        }).showToast();
        return;
    }
    const  formData = new FormData();
    formData.append('action', 'crearcuenta');
    formData.append('nombre', nombre);
    formData.append('apellidos', apellidos);
    formData.append('correo', correo);
    formData.append('password', password);
    formData.append('repeat_password', repeat_password);
    $.post({

        data: formData,
        url: "./conexion/actions.php",
        type: "post",
        processData: false,
        contentType: false,
        beforeSend: () => {
            Toastify({
                close: true,
                text: "Cargando...",
                duration: 3000,
                backgroundColor: "#00f059",
                style: {
                    borderRadius: "8px" // Cambia "8px" por el valor deseado
                }
            }).showToast();
        },
        success: (response) =>{
            console.log(response)
            if(response.success === true){
                window.location.href = "./"
                Toastify({
                    close: true,
                    text: response.message,
                    duration: 3000,
                    backgroundColor: "#15803d",
                    style: {
                        borderRadius: "8px" // Cambia "8px" por el valor deseado
                    }
                }).showToast();
            }else{
                Toastify({
                    close: true,
                    text: response.message,
                    duration: 3000,
                    backgroundColor: "#be185d",
                    style: {
                        borderRadius: "8px" // Cambia "8px" por el valor deseado
                    }
                }).showToast();
            }
        },
        error: (xhr, status, error) =>{
            console.log(xhr, "<br>")
            console.log(status, "<br>")
            console.log(error, "<br>")
            Toastify({
                text: "Error, inténtelo más tarde",
                duration: 3000,
                backgroundColor: "#be185d"
            }).showToast();
        }
    })


}

function Login (){
    const email = $("#email").val();
    const pass = $("#password").val(); // Corregido aquí
    // console.log("EMAIL: ", email , " PASSWORD: ", pass);
    if(!validCantCampos(email, 5)){
        Toastify({
            text: "Por favor ingrese un correo electrónico válido",
            duration: 3000,
            backgroundColor: "#be185d",
            close: true,
            style: {
                borderRadius: "8px" // Cambia "8px" por el valor deseado
            }
        }).showToast();
        return;
    }
    if(!isValidEmail(email)){
        Toastify({
            text: `La dirección de correo ${email} es incorrecta`,
            duration: 3000,
            backgroundColor: "#be185d",
            close: true,
            style: {
                borderRadius: "8px" // Cambia "8px" por el valor deseado
            }
        }).showToast();
        return;
    }
    if(!validCantCampos(pass, 5)){
        Toastify({
            text: "Ingrese una contraseña válidad mínima de 6 caracteres",
            duration: 3000,
            backgroundColor: "#be185d",
            close: true,
            style: {
                borderRadius: "8px" // Cambia "8px" por el valor deseado
            }
        }).showToast();
        return;
    }
    const formData = new  FormData ();
    formData.append('action', 'login');
    formData.append('email', email);
    formData.append('pass', pass);
    $.post({
        data: formData,
        url:'./conexion/actions.php',
        type:'post',
        processData: false,
        contentType:false,
        beforeSend  :()=>{
            Toastify({
                close: true,
                text: "Cargando...",
                duration: 1000,
                backgroundColor: "#00f059",
                style: {
                    borderRadius: "8px" // Cambia "8px" por el valor deseado
                }
            }).showToast();
        },success:(response) =>{
            console.log(response.success);
            if(response.success === true){
                console.log("Entro a true");
                Toastify({
                    close: true,
                    text: response.message,
                    duration: 3000,
                    backgroundColor: "#15803d",
                    style: {
                        borderRadius: "8px" // Cambia "8px" por el valor deseado
                    }
                }).showToast();
                window.location.href ="./dashboard/"
            }else{
                console.log("entró al false")
                Toastify({
                    close: true,
                    text: response.message,
                    duration: 3000,
                    backgroundColor: "#be185d",
                    style: {
                        borderRadius: "8px" // Cambia "8px" por el valor deseado
                    }
                }).showToast();
            }
        }, error: (xhr, status, error)=>{
            console.log(xhr, "<br>")
            console.log(status, "<br>")
            console.log(error, "<br>")
            Toastify({
                text: "Error, inténtelo más tarde",
                duration: 3000,
                backgroundColor: "#be185d",
                style: {
                    borderRadius: "8px" // Cambia "8px" por el valor deseado
                }
            }).showToast();
        }
    })
}

