<?php
session_start();

// Asegúrate de que la ruta al archivo helper.php sea correcta
include_once("class/helper.php");

if($_POST){
   $user = new db('users');
   $user->insert([
    'nombre'=>$_POST['nombre'],
    'apellido'=>$_POST['apellido'],
    'email'=>$_POST['email'],
    'contrasena'=>$_POST['contrasena'],
    'telefono'=>$_POST['telefono'],
    'direccion'=>$_POST['direccion'],
    'tipo'=>1,
   ]);
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/Logo2.jpeg">
  <link rel="icon" type="image/png" href="assets/img/Logo2.jpeg">
  <link rel="shortcut icon" href="assets/img/Logo2.jpeg" type="image/x-icon">
  <title>Registro - Biblioteca Plus</title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>
<body class="">
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-center">
                  <img src="assets/img/Logo2.jpeg" class="img w-75" alt="">
                  <h4 class="font-weight-bolder">Registro de Usuario</h4>
                  <p class="mb-0">Complete el formulario para crear una nueva cuenta</p>
                </div>
                <div class="card-body">
                  <form method="post" action="#" role="form">
                    <div class="mb-3">
                      <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Nombre" aria-label="Nombre" required>
                    </div>
                    <div class="mb-3">
                      <input type="text" name="apellido" class="form-control form-control-lg" placeholder="Apellido" aria-label="Apellido" required>
                    </div>
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control form-control-lg" placeholder="Correo Electrónico" aria-label="Correo Electrónico" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="contrasena" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Contraseña" required>
                    </div>
                    <div class="mb-3">
                      <input type="tel" name="telefono" class="form-control form-control-lg" placeholder="Teléfono">
                    </div>
                    <div class="mb-3">
                      <input type="text" name="direccion" class="form-control form-control-lg" placeholder="Dirección">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Registrar</button>
                      <a href="login.php" class="btn btn-lg btn-secondary btn-lg w-100 mt-4 mb-0">Iniciar sesión</a>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('assets/img/img_login.jpg'); background-size: cover; background-position: center;">
                  <span class="mask bg-gradient-primary opacity-6"></span>
                  <h4 class="mt-5 text-white font-weight-bolder position-relative">"La atención es la nueva moneda"</h4>
                  <p class="text-white position-relative">¡Datos que inspiran, educación que transforma! Juntos hacia el éxito escolar. ¡Adelante!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
