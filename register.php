<?php
$title = "Crear cuenta - Curiositify ";

include('page-master/head.php');
include('page-master/header.php');
?>

<body>
  <!-- Section: Design Block -->

  <section class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-[400px] bg-white">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight text-center">Crear cuenta
        </h3>
        <p class="text-sm text-muted-foreground  text-center">Ingrese sus datos para acceder a su cuenta.</p>
      </div>
      <form action="" method="#">
        <div class="p-6 pt-0 space-y-4 mt-4">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="space-y-2">
              <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium" for="nombres">Nombres</label>
              <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Escribe tus Nombres..." type="text" id="nombres">
            </div>
            <div class="space-y-2">
              <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium" for="apellidos">Apellidos</label>
              <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Escribe tus Apellidos..." placeholder="Escribe tus Apellidos..." type="text" id="apellidos">
            </div>
          </div>
          <div class="space-y-2">
            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium" for="correo">Correo electrónico</label>
            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Escribe tu correo electrónico" type="email" id="correo">
          </div>
          <div class="space-y-2">
            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium" for="password">Contraseña</label>
            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Escribe una contraseña" type="password" id="password">
          </div>
          <div class="space-y-2">
            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium" for="repeat_password">Repetir contraseña</label>
            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Repite la contraseña" type="password" id="repeat_password">
          </div>
        </div>
        <div class="items-center p-6 pt-0 flex flex-col space-y-4">
          <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none bg-black  text-white hover:bg-opacity-50 h-10 px-4 py-2 w-full" onclick="crearCuenta()" type="button">Registrarse</button>
          <div class="text-sm text-center">¿Ya tienes una cuenta? <a class="text-blacak text-opacity-80 hover:underline" href="./" rel="ugc">Inicia Sesión</a></div>
        </div>
      </form>

    </div>
  </section>
  <!-- Section: Design Block -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const inputs = document.querySelectorAll("#nombres, #apellidos, #correo, #password, #repeat_password");

      inputs.forEach(input => {
        input.addEventListener("keypress", function(event) {
          if (event.key === "Enter") {
            event.preventDefault(); 
            crearCuenta();
          }
        });
      });
    });
  </script>
</body>

</html>
<?php
// include "page-master/footer.php";
include('page-master/js.php');
?>