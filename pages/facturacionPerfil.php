<?php

$modulo = "Factuación";
include("../include/header.php");
include("../class/helper.php");
$est = new db('estudiante e');
foreach ($est->joinQuery(
  array('inscripcion i', 'perfil_factura p', 'grado g'),
  array(0, 0, 0),
  array('e.id = i.id_estudiante', 'i.id = p.idInscripcion', 'g.id = i.id_grado'),
  array("i.id = {$_GET['id']}"),
  array("CONCAT(e.nombre,' ',e.apellido) as nombre,g.nombre grado,p.balance, p.monto, e.foto, p.id id_perfil_factura")
) as $key) {
  $EST = $key;
}
$matriculacion = '';
$cuotas = new db('perfil_factura p');
$CUOTAS = '';
foreach ($cuotas->joinQuery(
  array('factura_detalle c', 'producto pd'),
  array('0', 0),
  array('p.id = c.id_factura', "c.id_producto = pd.id"),
  array("p.id = '{$EST['id_perfil_factura']}'"),
  array('c.id, c.fecha_pago,c.monto,c.balance,c.cuota,c.estado ,pd.categoria,pd.nombre producto,pd.foto,p.id id_factura')
) as $fl) {
  
  $matriculacion = ($fl['categoria'] == 3)?$fl : '';
  if ($fl['categoria'] == 4) :

    $button = ($fl['estado'] == 1) ? "<input id='cuota' class='form-check-input' type='checkbox' value='{$fl['id']}'>" : '';


    $CUOTAS .= "<li class='list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg' >
                    <div class='d-flex flex-column'>
                      <h6 class='mb-1 text-dark font-weight-bold text-sm'>{$fl['fecha_pago']}</h6>
                      <span class='text-xs'>#{$fl['cuota']}</span>
                    </div>
                    <div class='d-flex align-items-center text-sm'>
                    <div>
                    <div class='form-check'>
                    $ {$fl['balance']}
                    {$button}
                      </div>
                 
                  </li>";
  endif;
};

$pagos = new db('factura_paga f');
$registro_pagos = $pagos->joinQuery(
  array(
    'perfil_factura p',
    'inscripcion i',
    'estudiante e',
    'usuario u'
  ),
  array(0, 0, 0, 0),
  array(
    'f.id_factura = p.id',
    'p.idInscripcion = i.id',
    'i.id_estudiante = e.id',
    'u.id = f.id_usuario'
  ),
  array("p.id = {$EST['id_perfil_factura']}"),
  array(
    "concat(e.nombre_tutor,' ',e.apellido_tutor) tutor",
    "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ', SUBSTRING_INDEX(u.apellido,' ',1)) Cajero",
    "f.fecha_creacion fecha",
    "CASE 
          WHEN f.tipo_pago = 1 THEN 'Efectivo'
          WHEN f.tipo_pago = 2 THEN 'Tarjeta'
          WHEN f.tipo_pago = 3 THEN 'Tranferencia'
    END metodo_de_pago      
    ",
    "(SELECT SUM(precio) FROM facturas_pagas_detalle WHERE id_factura_paga = f.id) monto",
    "f.id",
    "f.id_cuadre"
  ),
  'order by f.id desc'
);
$rp = '';
foreach ($registro_pagos as $fl) {

  $button_elimianr = ($fl['id_cuadre'] == 0)?" <a data-bs-toggle='modal' data-bs-target='#cancelarP' onclick='id_eliminar = ({$fl['id']})' class='btn btn-link text-danger text-gradient px-3 mb-0'><i class='far fa-trash-alt me-2'></i>Eliminar</a> ":'';
  $rp .= "<li class='list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg'>
                  <div class='d-flex flex-column'>
                    <h6 class='mb-3 text-sm'>{$fl['Cajero']}</h6>
                    <span class='mb-2 text-xs'>Tutor: <span class='text-dark font-weight-bold ms-sm-2'>{$fl['tutor']}</span></span>
                    <span class='mb-2 text-xs'>Pago: <span class='text-dark font-weight-bold ms-sm-2'>$ {$fl['monto']}</span></span>
                    <span class='mb-2 text-xs'>Fecha: <span class='text-dark ms-sm-2 font-weight-bold'>{$fl['fecha']}</span></span>
                    <span class='mb-2 text-xs'>Metodo de pago: <span class='text-dark ms-sm-2 font-weight-bold'>{$fl['metodo_de_pago']}</span></span>
                    <span class='text-xs'>NO #: <span class='text-dark ms-sm-2 font-weight-bold'>{$fl['id']}</span></span>
                    <span class='text-xs'>ID CUADRE:<span class='text-dark ms-sm-2 font-weight-bold'>{$fl['id_cuadre']}</span></span>
                  </div>
                  <div class='ms-auto text-end'>
                  <a class='btn btn-link text-dark px-3 mb-0'target='_blank' href='../controller/factura_mod_1.php?id={$fl['id']}'><i class='fas fa-file-pdf text-lg me-1'></i> PDF</a>  
                   {$button_elimianr}
                  </div>
                </li>";
}

?>


<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include("../include/menu.php") ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include("../include/menuUser.php") ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">

            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-white shadow-xl">
                <div class="card-body text-center">
                  <img src="../assets/foto_estudiante/<?= (!empty($EST['foto'])) ? $EST['foto'] : 'sinFoto.jpg' ?>" class="w-50 rounded-3" alt="">
                  <h4 class="card-title"><?= $EST['nombre'] ?></h4>
                  <h6 class="category text-info text-gradient"><?= $EST['grado'] ?></h6>
                  <p class="card-description">

                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Balance</h6>
                      <span class="text-xs"></span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">$<?= number_format($EST['balance']) ?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fa-solid fa-sack-dollar opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Pago</h6>
                      <span class="text-xs"></span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">$<?= number_format($EST['monto']) ?></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" id="id_inscripcion" name="id_matriculacion" value="<?= $_GET['id'] ?>">
            <input type="hidden" id="id_factura" name="id_factura" value="<?= $matriculacion['id_factura']?>">

            <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card mt-4">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-6 d-flex align-items-center">
                      <h6 class="mb-0">Productos</h6>
                    </div>
                    <div class="col-6 text-end">
                      <a class="btn bg-gradient-dark mb-0" data-bs-toggle='modal' data-bs-target='#addProducto' onclick="cargarProducto()" addProducto href="javascript:;"><i class="fas fa-plus"></i>&nbsp;&nbsp;Agregar producto</a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <div class="row" id="contendor-productos">



                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 mt-4">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Matriculación</h6>
            </div>
            <div class="card-body">
              <div id='prod-cont' class='col-md-12 mb-md-0 mb-4'>
                <div class='card card-body border card-plain border-radius-lg d-flex align-items-center flex-row'>
                  <?php  if ($matriculacion) : ?>
                    <img class='w-10 me-3 mb-0' src='../assets/fotoProducto/<?= (!empty($matriculacion['foto'])) ? $matriculacion['foto'] : 'sinFoto.jpg' ?>' alt='logo'>
                    <h6 class='mb-0'><?= $matriculacion['producto'] ?></h6>
                    <div class='ms-auto text-dark'>$ <span id=precio><?= $matriculacion['balance'] ?></span></div>
                    <div class="form-check">
                      <?php if($matriculacion['estado'] == 1):?>
                      <input class="form-check-input mx-2" value="<?= $matriculacion['id'] ?>" id="id_producto_matriculacion" type="checkbox">
                        
                      <?php endif?>

                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mt-4">
          <div class="card " style="height: 100vh;">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0">Cuotas</h6>
                </div>
                <div class="col-6 text-end d-flex">
                  <select id="metodo" class="form-control " id="">
                    <option value="1">Efectivo</option>
                    <option value="2">Tarjeta</option>
                    <option value="3">Transferencia</option>
                  </select>
                  <button onclick="" data-bs-toggle='modal' data-bs-target='#exampleModalMessage' class="btn btn-outline-success btn-sm mb-0">Pagar <i class='fa-solid fa-money-check-dollar '> </i></button>
                </div>
              </div>
            </div>
            <div class="card-body p-3 pb-0" id="cont-factura" style=" overflow: auto;">
              <ul class="list-group" id="cuotas">
                <?= $CUOTAS ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Historial de facturas</h6>
            </div>
            <div class="card-body pt-4 p-3" style=" overflow: auto;">
              <ul class="list-group" style="height: 100vh;">
                <?= $rp ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row">

        <!-- <div class="col-md-5 mt-4">
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Your Transaction's</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <small>23 - 30 March 2020</small>
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3">
              <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                      <span class="text-xs">27 March 2020, at 12:30 PM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                    - $ 2,500
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Apple</h6>
                      <span class="text-xs">27 March 2020, at 04:30 AM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                    + $ 2,000
                  </div>
                </li>
              </ul>
              <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Stripe</h6>
                      <span class="text-xs">26 March 2020, at 13:45 PM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                    + $ 750
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">HubSpot</h6>
                      <span class="text-xs">26 March 2020, at 12:30 PM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                    + $ 1,000
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Creative Tim</h6>
                      <span class="text-xs">26 March 2020, at 08:30 AM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                    + $ 2,500
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                      <span class="text-xs">26 March 2020, at 05:00 AM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                    Pending
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div> -->
      </div>

    </div>
  </main>
  <?php include "../include/configuracion.php" ?>
  <!-- Modal para confimar pago -->
  <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realizar pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Seguro que quieres realizar un pago</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="pagarCuota()" class="btn bg-gradient-primary">Pagar</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Modal para confimar cancelacion -->
  <div class="modal fade" id="cancelarP" tabindex="-1" role="dialog" aria-labelledby="cancelarP" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Eliminar pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Seguro que quieres eliminar este pago</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick=" onclick=cancelarPago()" class="btn bg-gradient-danger">Eliminar pago</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Modal productos -->
  <div class="modal fade" id="addProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Nombre:</label>
              <input type="search" class="form-control" id="buscador">
            </div>
          </form>
          <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Precio</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody id="cont-producto">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="selecProdcuto()" class="btn bg-gradient-primary" data-bs-dismiss="modal">Agregar</button>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    let cuotas = document.getElementById('cuotas').getElementsByTagName('li');

    function pagarCuota() {
      // Matriculacion
      id_matriculacion ='';
      check = document.getElementById('id_producto_matriculacion');
      if(check && check.checked == true){
        id_matriculacion = document.getElementById('id_producto_matriculacion').value;

      }
    

      // Productos
      id_productos = [];
      producto = document.getElementById('contendor-productos').querySelectorAll('#producto');
      for (let i = 0; i < producto.length; i++) {
        id_productos[i] = [producto[i].getAttribute('data-producto'), producto[i].querySelector('input').value]
      }

      tipo_pago = document.getElementById('metodo').value;
      id_cuotas = [];
      for (let i = 0; i < cuotas.length; i++) {
        const cuotaCheckbox = cuotas[i].querySelector('#cuota');
        if (cuotaCheckbox && cuotaCheckbox.checked) {
          id_cuotas.push(cuotaCheckbox.value);
        }
      }

      // informacion a enviar
      data = {
        cuotas: id_cuotas,
        productos: id_productos,
        id_factura: <?= $EST['id_perfil_factura'] ?>,
        metodo: tipo_pago,
        id_usuario: <?= $_SESSION['id'] ?>,
        pago: 1,
        producto_matricula : id_matriculacion,
        id_matriculacion : document.getElementById('id_inscripcion').value};

      let options = {
        method: "POST",
        header: {
          'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
      }
      if (id_cuotas.length > 0 || id_productos.length > 0 || id_matriculacion > 0) {
        fetch("../controller/realizar_pago.php", options)
          .then(() => {
            window.location.href = "facturacionPerfil.php?id=<?= $_GET['id'] ?>";
          });
      } else {
        alert('No a seleccionado el articulo a pagar');
      }
    }

    function cancelarPago() {

      data = {
        id_factura_paga:id_eliminar,
        id_factura:<?= $EST['id_perfil_factura'] ?>,
        id_matriculacion: document.getElementById('id_inscripcion').value,
        user: <?= $_SESSION['id'] ?>
      }
      let options = {
        method: "POST",
        header: {
          'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
      }
      fetch("../controller/realizar_pago.php", options)
        .then(r => {
          window.location.href = "facturacionPerfil.php?id=<?= $_GET['id'] ?>";
        })
    }

    function verFactura(id) {
      window.open(`../controller/factura.php?id=${id}`);
    }

    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    function cargarProducto() {
      fetch('../controller/producto_facturacion.php')
        .then((r) => r.json())
        .then(r => {
          document.getElementById('cont-producto').innerHTML = r;

        });
    }

    function selecProdcuto() {
      contenido = '';
      productos = document.getElementById('cont-producto').getElementsByTagName('tr');
      for (let i = 0; i < productos.length; i++) {
        if (productos[i].querySelector('#check') && productos[i].querySelector('#check').checked == true) {
          contenido += productos[i].querySelector('#prod-cont').innerHTML;
          document.getElementById('contendor-productos').innerHTML = contenido;
        }
      }
    }

    function eliminar_lista_producto(e) {
      console.log(e.target.parentNode);
      e.target.parentNode.remove()
    }

    let buscador = document.getElementById('buscador');
    buscador.addEventListener('input', (e) => {
      document.querySelectorAll('.producto').forEach(est => {

        if (!est.querySelector('.prod').textContent.toLowerCase().includes(e.target.value.toLowerCase())) {
          est.style.display = 'NONE';
        } else {
          est.style.display = '';
        }
      })
    })
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>