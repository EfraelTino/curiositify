<?php
$title = "Login - Curiositify";

include('page-master/head.php');
include('page-master/header.php');
?>

<body>
  <!-- Section: Design Block -->
  <div style="
        width: 100vw;
        min-height: 100vh;
        position: fixed;
        top: 0px;
        z-index: 1;
        display: flex;
        justify-content: center;
        padding: 120px 24px 160px;
        pointer-events: none;
      ">
    <div style="
          content: '';
          background-image: url('https://assets.dub.co/misc/grid.svg');
          z-index: 1;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          opacity: 0.5;
          filter: invert(1);
        "></div>
  </div>
  <section class="flex items-center  justify-center min-h-screen bg-gray-100">
    <div class="rounded-lg border bg-card text-card-foreground bg-white z-10 shadow-sm w-[350px]">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight text-center">Inicia Sesión
        </h3>
        <p class="text-sm text-muted-foreground  text-center">Ingrese sus credenciales para acceder a su cuenta.</p>
      </div>
      <form action="" method="#">
        <div class="p-6 pt-0">
          <div class="grid w-full items-center gap-4">
            <div class="flex flex-col space-y-1.5">
              <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
              <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Escribe tu correo electrónico" type="email" id="email" required />

            </div>
            <div class="flex flex-col space-y-1.5">
              <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="password">Password</label>
              <input placeholder="Escribe una contraseña" type="password" id="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />

            </div>
          </div>
        </div>
        <div class="items-center  p-6 pt-0 flex flex-col space-y-4">
          <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-black text-white hover:bg-opacity-50 h-10 px-4 py-2 w-full" onclick="Login()" type="button">Ingresar</button>
          <div class="text-sm text-center">¿No tienes una cuenta? <a class="text-black text-opacity-80 hover:underline" href="./register" rel="ugc">
              Crear ahora
            </a>
          </div>
        </div>
      </form>
    </div>
  </section>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      emailInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          Login();
        }
      });
      passwordInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          Login();
        }
      });
    });
  </script>

  <!-- Section: Design Block -->
</body>

</html>
<?php
// include "page-master/footer.php";
include('page-master/js.php');
?>