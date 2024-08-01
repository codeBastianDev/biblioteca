<?php
session_start();
$modulo = "Listado de usuario";
include_once ("../class/helper.php");

$usuario = (new db('users'))->cargar(null);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo_trasparente.png">
  <title>
    Biblioteca Plus
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/4901049ea4.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <!-- slider -->
  <?php include_once ("../include/menu.php") ?>
  <!-- slider end-->
  <main class="main-content position-relative border-radius-lg ">
    <!--  Navbar -->
    <?php include_once ("../include/menuUser.php") ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-5">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-9">
                  <label for="" class="form=control-label">Buscador</label>
                  <input type="search" id="buscador" class="form-control" placeholder="Nombre">
                </div>

                <div class="col-2">
                  <label for="estado" name="estado" class="form-control-label">Tipo</label>
                  <select id="estado" class="form-control filtro" filtro='estado' onchange="filtro(event)">
                    <option selected value="">Todos</option>
                    <option value="1">Cliente</option>
                    <option value="2">Admin</option>
                  </select>
                </div>

                <div class="col-1">
                  <label class="form-conrol-label">Agregar</label>
                  <a href="editUsuario.php?id=-1" class="btn btn-success"><i class="ni ni-fat-add"></i> </a>
                </div>

              </div>

            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Correo</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefono</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dirección
                      </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha
                        registro</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="contenedor-principal">
                    <?php foreach ($usuario as $value): ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="../assets/fotoUsuarios/sinFoto.jpg" class="avatar avatar-sm me-3">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-xs nombre-user"><?= "{$value['nombre']} {$value['apellido']}" ?></h6>
                              <!-- <p class="text-xs text-secondary mb-0"><?= $value['email'] ?></p> -->
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0 user-tipo"><?= ($value['tipo'] == 1 ? "Cliente" : "Admin") ?>
                          </p>
                          <p class="text-xs text-secondary mb-0"><?= $value['email'] ?></p>
                        </td>
                        <td>
                          <p class="text-xs text-secondary mb-0"><?= $value['telefono'] ?></p>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold"><?= $value['direccion'] ?></span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold">2<?= $value['fecha_registro'] ?></span>
                        </td>
                        <td class="align-middle">
                          <a href="editUsuario.php?id=<?=$value['id']?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                            data-original-title="Edit user">
                            Edit
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
  <!-- Configuracion -->
  <?php include_once ("../include/configuracion.php") ?>
  <!-- Configuracion end-->

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>

<script>
  document.getElementById('buscador').addEventListener('keyup', e => {
    seach = e.target.value;
    registro = document.querySelectorAll('tbody tr');
    registro.forEach(element => {
      texto = element.querySelector(".nombre-user").textContent.toLowerCase()
      if (texto.includes(seach.toLowerCase()) || seach == '') {
        element.style.display = '';
      } else {
        element.style.display = 'none';
      }
    });
  })

  function filtro(e) {
    if (e.target.value > 0) {
      seach = (e.target.value == 1) ? "Cliente" : "Admin";
    } else {
      seach = '';
    }
    registro = document.querySelectorAll('tbody tr');
    registro.forEach(element => {
      texto = element.querySelector(".user-tipo").textContent.toLowerCase()
      if (texto.includes(seach.toLowerCase()) || seach == '') {
        element.style.display = '';
      } else {
        element.style.display = 'none';
      }
    });
  }
</script>