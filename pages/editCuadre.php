<?php
$modulo = "Nuevo cuadre";
include("../class/helper.php");
include("../include/header.php");

$gastos = new db(null);


$dt_gasto = $gastos->dataTable("SELECT (SELECT sum(monto) FROM gasto where id_cuadre = 0) monto,id FROM gasto where id_cuadre = 0 ");
$monto = $dt_gasto[0]['monto'] ?? 0;

if (isset($_POST) && !empty($_POST)) {
  $contador_factura = 0;
  $monto_total = 0;


  $facturas = new db('factura_paga f');
  foreach ($facturas->joinQuery(
    array('facturas_pagas_detalle fpd', 'usuario u'),
    array(0, 0),
    array('f.id = fpd.id_factura_paga', 'f.id_usuario = u.id'),
    array("DATE(f.fecha_creacion) BETWEEN '{$_POST['desde']}' AND '{$_POST['hasta']}'", "f.id_cuadre = 0"),
    array(
      'f.id', "(SELECT
  SUM(precio)
            FROM
                factura_paga 
            INNER JOIN facturas_pagas_detalle fpd ON
                (factura_paga.id = fpd.id_factura_paga) where factura_paga.id =f.id ) AS total",
      "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ',SUBSTRING_INDEX(u.apellido,' ',1)) as cajero",
      "u.id id_usuario",
      "f.id_cuadre"
    ),
    "GROUP BY f.id"
  ) as $value) {
    $contador_factura++;
    $monto_total += $value['total'];
    $id_pagos[] = $value['id'];
  }
  if ($contador_factura > 0) {

    // Creamos en cudre
    $cuadre = new db('cuadre');
    $cuadre->insert(
      array(
        "monto" => $monto_total,
        "cantidad_factura" => $contador_factura,
        "id_usuario" => $_SESSION['id'],
        "gasto" => $dt_gasto[0]['monto']
      )
    );

    // Para los gasto colocarle su cuadre y no cobre en los proximo cuadre
    foreach ($dt_gasto as $fl) {
       (new db('gasto'))->insert(
          array("id_cuadre" => $cuadre->inser_id),
          $fl['id']
       );
     }
   
    

    // Agregamos el id del cuadre a las facturas
    foreach ($id_pagos as $fl) {
      (new db('factura_paga'))->insert(array(
        "id_cuadre" => $cuadre->inser_id
      ), $fl);
    }
  }

  header('location:cuadre.php');
  exit();
}
?>

<body class="g-sidenav-show bg-gray-100">
  <!-- <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div> -->
  <div class="position-absolute w-100 min-height-300 top-0">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <?php include("../include/menu.php") ?>



  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php include("../include/menuUser.php") ?>
    <!-- End Navbar -->
    <div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <H1>Cuadre de caja</H1>
        <div class="row gx-4">

          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <!-- <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                    <i class="ni ni-app"></i>
                    <span class="ms-2">App</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-email-83"></i>
                    <span class="ms-2">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-settings-gear-65"></i>
                    <span class="ms-2">Settings</span>
                  </a>
                </li>
              </ul>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <p class="text-uppercase text-sm">Información del usuario</p>

              <form id="formulario" method="post" action="#" enctype="multipart/form-data">

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre" class="form-control-label">Desde</label>
                      <input class="form-control" id="desde" name="desde" type="date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="apellido" class="form-control-label">Hasta</label>
                      <input class="form-control" id="hasta" type="date" name="hasta" required value="<?= date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="col-md-12 ">
                    <button class="btn btn-success w-100" onclick="cargarFactura(event)">Buscar <i class="ni ni-zoom-split-in"></i></button>
                  </div>

                  <div>
                    <div class="card">
                      <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Factura</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Monto</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cajero</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metodo</th>
                              <!-- <th class="text-secondary opacity-7"></th> -->
                            </tr>
                          </thead>
                          <tbody id="cuadre">

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-4">
                    <div class="card">
                      <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-start text-uppercase text-secondary  font-weight-bolder ">Total</th>
                              <th class="text-start text-uppercase text-success  font-weight-bolder  ps-2" id="total"></th>
                            </tr>
                            <tr>
                              <th class="text-start text-uppercase text-secondary  font-weight-bolder ">Gastos</th>
                              <th class="text-start text-uppercase text-danger  font-weight-bolder  ps-2" id="gastos"> $<?= number_format($monto) ?> </th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>



                  <div class="col-md-12 mt-3">
                    <input type="submit" class="btn btn-primary btn-block w-100" value="Guardar">
                  </div>

                  <!-- <div class="col-md-6 mt-3">
                    <button type="button" class="btn btn-block bg-gradient-danger mb-3 w-100" data-bs-toggle="modal" data-bs-target="#modal-notification">Eliminar</button>
                    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-notification">Atención</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="py-3 text-center">
                              <i class="ni ni-bell-55 ni-3x"></i>
                              <h4 class="text-gradient text-danger mt-4">¡Deberías leer esto!</h4>
                              <p>¿Estás seguro de que deseas eliminar permanentemente a este estudiante? Esta acción no se puede deshacer.</p>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <button type="button" onclick="eliminarEstudiante(<?= $_GET['id'] ?>)" class="btn btn-primary">Si</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
            </div>
          </div>




        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  </div>


  <script>
    function cargarFactura(e) {
      e.preventDefault();
      desde = document.getElementById('desde').value;
      hasta = document.getElementById('hasta').value;

      if (desde == '') {
        alert('Tienes que seleccionar el desde');
      }

      data = {
        desde: desde,
        hasta: hasta
      };
      Option = {
        method: "POST",
        header: {
          'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
      }
      url = '../controller/listado_cuadre.php'
      fetch(url, Option)
        .then(r => r.json())
        .then(r => {
          document.getElementById('cuadre').innerHTML = r;
          total = 0;
          facturas = document.getElementById('cuadre').getElementsByTagName('tr');
          for (let i = 0; i < facturas.length; i++) {
            total += parseFloat(facturas[i].querySelector('#dinero').textContent);
          }
          total = total.toLocaleString();
          document.getElementById('total').textContent = '$' + total;
        })
    }

    function eliminarCuadre(id) {
      // conf = confirm("Esta seguro que quieres eliminar este cuadre?");
      // console.log(conf,id);
      // data = new FormData();
      // data.append('docente', id);
      // // console.log(data.get('id_eliminar'));
      // fetch('../controller/eliminar_est.php', {
      //     method: 'POST',
      //     body: data
      //   })
      //   .then(response => response.text())
      //   .then(result => {
      //     console.log(result);
      //     location.href = 'docente.php';
      //   })
    }
  </script>
  <?php include("../include/configuracion.php") ?>
  <?php include("../include/footer.php") ?>