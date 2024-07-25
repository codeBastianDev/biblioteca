<?php
$modulo = "Prestamos";
include ("../include/header.php");
include ("../class/helper.php");

// Conectar a la base de datos
$conexion = new Conexion();
$conexion->conexion();

// Obtener el ID del usuario
$usuario_id = $_SESSION['usuario_id'] ?? $_GET['usuario_id'] ?? 1;

// Consultar información del usuario
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conexion->cnx->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
  echo "Usuario no encontrado";
  $conexion->closeConexion();
  exit;
}

// Obtener fechas de inicio y fin para el filtro
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Consultar préstamos
$sql_prestamos = "SELECT reservations.*, books.titulo, books.imagen FROM reservations JOIN books ON reservations.libro_id = books.id WHERE usuario_id = ?";

if ($fecha_inicio && $fecha_fin) {
  $sql_prestamos .= " AND fecha_reserva >= ? AND fecha_expiracion <= ?";
  $stmt_prestamos = $conexion->cnx->prepare($sql_prestamos);
  $stmt_prestamos->bind_param("iss", $usuario_id, $fecha_inicio, $fecha_fin);
} else {
  $stmt_prestamos = $conexion->cnx->prepare($sql_prestamos);
  $stmt_prestamos->bind_param("i", $usuario_id);
}
$stmt_prestamos->execute();
$result_prestamos = $stmt_prestamos->get_result();

// Cerrar conexión a la base de datos
$conexion->closeConexion();
?>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include ("../include/menu.php") ?>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <?php include ("../include/menuUser.php") ?>
    <!-- End Navbar -->
    <style>
      .badge-custom {
        background-color: green;
        
        color: white;
        
      }
    </style>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <!-- Información del usuario -->
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-white shadow-xl">
                <div class="card-body text-center">
                  <h3>Información del Usuario</h3>
                  <h4 class="card-title"><?= htmlspecialchars($usuario['nombre']) ?>
                    <?= htmlspecialchars($usuario['apellido']) ?></h4>
                  <h6 class="category text-info text-gradient"><?= htmlspecialchars($usuario['email']) ?></h6>
                  <p class="card-description">
                    Teléfono: <?= htmlspecialchars($usuario['telefono']) ?><br>
                    Dirección: <?= htmlspecialchars($usuario['direccion']) ?><br>
                    Fecha de Registro: <?= htmlspecialchars($usuario['fecha_registro']) ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- Filtros de Préstamos -->
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-white shadow-xl">
                <div class="card-body">
                  <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                      <i class="fas fa-book opacity-10"></i>
                    </div>
                  </div>
                  <h6 class="text-center mb-4">Filtrar Préstamos por Fechas</h6>
                  <form method="GET" action="facturacionPerfil.php">
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="fecha_inicio">Fecha Inicial</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                          value="<?= htmlspecialchars($fecha_inicio) ?>">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="fecha_fin">Fecha Final</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                          value="<?= htmlspecialchars($fecha_fin) ?>">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Historial de Préstamos -->
            <div class="col-lg-12 mt-4">
              <div class="card">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Historial de Préstamos</h6>
                </div>
                <div class="card-body pt-4 p-3">
                  <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Imagen</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Título del
                            Libro</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha de
                            Reserva</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Estado</th>
                          <th class="text-secondary opacity-7"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($result_prestamos->num_rows > 0): ?>
                          <?php while ($prestamo = $result_prestamos->fetch_assoc()): ?>
                            <tr>
                              <td>
                                <div class="d-flex px-2 py-1">
                                  <div>
                                    <img src="<?= htmlspecialchars($prestamo['imagen']) ?>" class="avatar avatar-sm me-3"
                                      alt="Imagen del libro">
                                  </div>
                                </div>
                              </td>
                              <td>
                                <div class="d-flex flex-column justify-content-center">
                                  <h6 class="mb-0 text-xs"><?= htmlspecialchars($prestamo['titulo']) ?></h6>
                                </div>
                              </td>
                              <td>
                                <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($prestamo['fecha_reserva']) ?>
                                </p>
                              </td>
                              <td class="align-middle text-center">
                                <span class="badge badge-sm badge-custom">Disponible</span>
                              </td>

                            </tr>
                          <?php endwhile; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center">No hay préstamos para mostrar.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
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

  <!-- Script para manejo de fechas -->
  <script>
    function setFechaInicio(fecha) {
      document.getElementById('fecha_inicio').value = fecha;
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