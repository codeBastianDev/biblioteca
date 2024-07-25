<?php
include('../class/helper.php');
$modulo = "Dashboard";


validarUser();

$pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', ''); // Cambia las credenciales si es necesario


$query = $pdo->query("SELECT COUNT(*) as total_reservations FROM reservations WHERE fecha_expiracion IS NULL");
$reservationCount = $query->fetch(PDO::FETCH_ASSOC)['total_reservations'];


$query = $pdo->query("SELECT usuario_id, fecha_reserva, fecha_expiracion FROM reservations WHERE fecha_expiracion IS NULL");
$reservations = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $pdo->query("SELECT COUNT(*) as overdue_count FROM reservations WHERE fecha_expiracion < CURDATE()");
$overdueCount = $query->fetch(PDO::FETCH_ASSOC)['overdue_count'];


$usuarios = [];
foreach ($reservations as $reservation) {
    $userId = $reservation['usuario_id'];
    if (!isset($usuarios[$userId])) {
        $userQuery = $pdo->prepare("SELECT nombre FROM users WHERE id = ?");
        $userQuery->execute([$userId]);
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);
        $usuarios[$userId] = $user['nombre'] ?? 'Desconocido'; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/Logo2.jpeg">
    <link rel="icon" type="image/png" href="../assets/img/Logo2.jpeg">
    <title>Biblioteca Plus</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>
<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php include_once("../include/menu.php") ?>
    <main class="main-content position-relative border-radius-lg ">
        <?php include_once("../include/menuUser.php") ?>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-6 col-sm-12 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                        <i class="ni ni-books text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Préstamos Activos</p>
                                        <h5 class="font-weight-bolder"><?= $reservationCount ?></h5>
                                        <p class="mb-0 text-sm">Última actualización: hoy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Devoluciones Pendientes</p>
                                        <h5 class="font-weight-bolder"><?= $overdueCount ?></h5>
                                        <p class="mb-0 text-sm">Última actualización: hoy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Detalles de Reservas Actuales</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th>Nombre del Usuario</th>
                                        <th>Fecha de Reserva</th>
                                        <th>Fecha de Expiración</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $reservation): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($usuarios[$reservation['usuario_id']] ?? 'Desconocido') ?></td>
                                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($reservation['fecha_reserva']))) ?></td>
                                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($reservation['fecha_expiracion']))) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include('../include/configuracion.php') ?>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = { damping: '0.5' }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
