<?php
include ('../class/helper.php');
$modulo = "Dashboard";

validarUser();

$prestamo = new db('reservations');
$libro = [];
foreach (($prestamo->cargar(0, ["usuario_id = {$_SESSION['id']}"])) as $value) {
    $libro[] = $value['libro_id'];
}

$reservations = (new db('books b'))
    ->joinQuery(
        ['categories c', 'reservations r'],
        ['0', 2],
        ['c.id = b.categoria_id', 'b.id = r.libro_id'],
        ["usuario_id  = {$_SESSION['id']}"],
        ['b.*', 'c.nombre categoria', 'r.fecha_reserva reserva', 'r.fecha_expiracion expiracion','r.id id_prestamo'],
        "GROUP By b.id"
    );

$libro = implode(',', $libro);

$pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', '');


$query = $pdo->query("SELECT COUNT(*) as total_reservations FROM reservations WHERE usuario_id = '{$_SESSION['id']}'");
$reservationCount = $query->fetch(PDO::FETCH_ASSOC)['total_reservations'];

$query = $pdo->query("SELECT usuario_id, fecha_reserva, fecha_expiracion FROM reservations WHERE fecha_expiracion IS NULL");

$query = $pdo->query("SELECT COUNT(*) as overdue_count FROM reservations WHERE usuario_id = '{$_SESSION['id']}' and fecha_expiracion < CURDATE()");
$overdueCount = $query->fetch(PDO::FETCH_ASSOC)['overdue_count'];

$usuarios = [];

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
    <?php include_once ("../include/menu.php") ?>
    <main class="main-content position-relative border-radius-lg ">
        <?php include_once ("../include/menuUser.php") ?>
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
                                        <th>Libro</th>
                                        <th>Fecha de Reserva</th>
                                        <th>Fecha de Expiración</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $reservation):?>
                                        <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="<?=$reservation['imagen']?>" class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs"><?=$reservation['titulo']?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?=$reservation['autor']?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$reservation['reserva']?></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0"><?=$reservation['expiracion']?></p>
                                        </td>
                                        <td><button class="btn btn-primary" onclick="entregar(<?=$reservation['id_prestamo']?>,<?=$reservation['id']?>)">Entregar libro</button></td>
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
    <?php include ('../include/configuracion.php') ?>
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
      

            function entregar(id,libro){
                confing ={
                    method:"POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body:JSON.stringify({prestamo:id,libro:libro})
                }
                fetch("../controller/fin_libro.php",confing,e =>{
                    console.log(e);
                })
            }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
