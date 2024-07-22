<?php

$modulo = "Prestamos";
include("../include/header.php");
include("../class/helper.php");

?>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include("../include/menu.php") ?>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <?php include("../include/menuUser.php") ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <!-- Información del usuario -->
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-white shadow-xl">
                <div class="card-body text-center">
                  <img src="../assets/foto_estudiante/" class="w-50 rounded-3" alt="">
                  <h4 class="card-title">Información del Usuario</h4>
                  <h6 class="category text-info text-gradient"></h6>
                  <p class="card-description"></p>
                </div>
              </div>
            </div>

            <!-- Préstamos y Devoluciones -->
            <div class="col-xl-6">
              <div class="row">
                <!-- Préstamos Activos -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-book opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Préstamos Activos</h6>
                      <span class="text-xs"></span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">Listado de libros prestados</h5>
                    </div>
                  </div>
                </div>
                <!-- Devoluciones Pendientes -->
                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fa-solid fa-undo opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Devoluciones Pendientes</h6>
                      <span class="text-xs"></span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">Listado de libros a devolver</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Formulario para Préstamo de Libros -->
            <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card mt-4">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-6 d-flex align-items-center">
                      <h6 class="mb-0">Nuevo Préstamo</h6>
                    </div>
                    <div class="col-6 text-end">
                      <a class="btn bg-gradient-dark mb-0" data-bs-toggle='modal' data-bs-target='#addPrestamo' onclick="cargarLibros()" href="javascript:;">
                        <i class="fas fa-plus"></i>&nbsp;&nbsp;Agregar Préstamo
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <div class="row" id="contendor-prestamos">
                    <!-- Aquí se cargarán los préstamos -->
                  </div>
                </div>
              </div>
            </div>

            <!-- Historial de Préstamos -->
            <div class="col-lg-12 mt-4">
              <div class="card">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Historial de Préstamos</h6>
                </div>
                <div class="card-body pt-4 p-3" style="overflow: auto;">
                  <ul class="list-group" style="height: 100vh;">
                    <!-- Aquí se listarán los préstamos históricos -->
                  </ul>
                </div>
              </div>
            </div>

            <!-- Modal para Agregar Préstamo -->
            <div class="modal fade" id="addPrestamo" tabindex="-1" role="dialog" aria-labelledby="addPrestamoTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addPrestamoLabel">Agregar Nuevo Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group">
                        <label for="libro-titulo" class="col-form-label">Título del Libro:</label>
                        <input type="text" class="form-control" id="libro-titulo">
                      </div>
                      <div class="form-group">
                        <label for="nombre-usuario" class="col-form-label">Nombre del Usuario:</label>
                        <input type="text" class="form-control" id="nombre-usuario">
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" onclick="agregarPrestamo()" class="btn bg-gradient-primary">Agregar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../include/configuracion.php" ?>

  <!-- Script para manejo de préstamos -->
  <script>
    function agregarPrestamo() {
      const tituloLibro = document.getElementById('libro-titulo').value;
      const nombreUsuario = document.getElementById('nombre-usuario').value;

      // Aquí podrías agregar la lógica para agregar el préstamo

      alert(`Préstamo de "${tituloLibro}" agregado para ${nombreUsuario}.`);
    }

    function cargarLibros() {
      // Aquí podrías agregar la lógica para cargar los libros en el modal
    }
  </script>

  <!-- JS Core Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
