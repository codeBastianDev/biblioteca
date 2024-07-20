<?php
$modulo = "Creacion de factura";
include("../include/header.php");
include("../class/helper.php");

if ($_POST) {
  // Valido si es una imagen

  $db = new db('inscripcion');
  $db->insert(array(
    'id_anio' =>  $_POST['anio'],
    'id_estudiante' => $_POST['id_estudiante'],
    'id_grado' => $_POST['grado'],
  ), $_POST['id']);

  echo "<script>  location.href = 'estudiante.php'  </script>";

  exit();
};


$db = new db('estudiante e');
$est = [];

$estDt = $db->joinQuery(array('inscripcion i','grado g','perfil_factura p'),
                        array(2,2,2),
                        array("e.id = i.id_estudiante and i.estado = 1 and i.id = {$_GET['id']}",
                              "g.id = i.id_grado",
                            "p.idInscripcion = i.id"),
                        array("e.id = '{$_GET['id_estudiante']}'"),
                        array('e.foto,e.nombre,e.apellido,i.id_grado, i.id_anio,g.nombre grado,p.id id_factura'));

foreach ($estDt as $fl) {
  $est[] = $fl;
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
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="../assets/foto_estudiante/<?= isset($est[0]['foto']) && !empty($est[0]['foto']) ? $est[0]['foto'] : 'sinFoto.jpg' ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?= (  isset($est[0]['nombre']) && isset($est[0]['apellido'])) ? "{$est[0]['nombre']} {$est[0]['apellido']}" : ''  ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?= (isset($est[0]['grado'])) ? "{$est[0]['grado']}" : '' ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <p class="text-uppercase text-sm">Información de factura</p>

              <form id="formulario" method="post" action="../controller/newCuota.php" >
                <input type="hidden" name="id_estudiante" value="<?=(isset($est[0]['id_factura'])) ? "{$est[0]['id_factura']}" : 0 ?>">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>"> 
                <?php if(!isset($est[0]['id_factura'])): ?>
                <div class="row">
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="grado" class="form-control-label">Inscripción</label>
                      <select name="inscripcion" id="matriculacion" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php
                        foreach ((new db('producto'))->cargar(0, array('categoria = 3')) as $v) {
                          echo "<option value='{$v['id']}' data-inscripcion={$v['precio']} >{$v['nombre']}</option>";
                        }
                        ?>

                      </select>
                    </div>
                  </div>

                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="anio" class="form-control-label">Escolaridad</label>
                      <select name="escolaridad" id="precioEscolarida" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php
                        foreach ((new db('producto'))->cargar(0, array('categoria = 4')) as $v) {
                          echo "<option value='{$v['id']}' data-escolaridad={$v['precio']} >{$v['nombre']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="anio" class="form-control-label">Cantidad de cuota</label>
                      <input type="number" class="form-control" name="cuota" id="cuota">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="anio" class="form-control-label">Fecha de inicio</label>
                      <input type="date" class="form-control" name="fecha" id="fecha">
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <div class="card">
                      <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha</th>
                              <th class="text-center text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <div class="card">
                      <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Totales</th>
                              <th class="text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Monto</th>
                            </tr>
                          </thead>
                          <tbody id="data_total">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <hr class="horizontal dark">
                  <div class="col-md-6">
                    <button class="btn btn-block btn-primary w-100">Inscribir</button>
                  </div>
                  <?php endif ?>
                  <div class="col-md-<?= (!isset($est[0]['id_factura']))?6:12 ?>">
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
                              <p>¿Estás seguro de que deseas eliminar permanentemente esta inscripción? Esta acción no se puede deshacer.</p>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <button type="button" onclick="eliminarEstudiante(<?= $est[0]['id_factura'] ?>)" class="btn btn-primary">Si</button>
                          </div>
                        </div>
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
      let form = document.querySelector('Form');
      form.addEventListener('input', event => {
        cuota = event.target.id === 'cuota' ? event.target.value : cuota;
        matriculacion = event.target.id === 'matriculacion' ? parseFloat(event.target.options[event.target.selectedIndex].getAttribute('data-inscripcion')) : matriculacion;
        fecha = event.target.id === 'fecha' ? new Date(event.target.value) : fecha;
        precio_cuota = event.target.id === 'precioEscolarida' ? event.target.options[event.target.selectedIndex].getAttribute('data-escolaridad') : precio_cuota;
        fecha.toLocaleString('en-US', { timeZone: 'America/Santo_Domingo' })
        
        console.log(matriculacion);
        
        precioCuotaFinal = 0;

        let tb = '';
        for (let index = 1; index <= cuota; index++) {
        fecha.setMonth(fecha.getMonth() + 1);
        dia = fecha.getDate();
        mes = fecha.getMonth() + 1; 
        año = fecha.getFullYear();
        fecha_final =`${dia}/${mes}/${año}`;
        precioCuotaFinal = precioCuotaFinal +parseFloat(precio_cuota) ;
          tb += `<tr>
                      <td class="align-middle text-center text-sm">
                          <span class=" text-secondary text-xs font-weight-bold">${index}</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                          <span class="text-secondary text-xs font-weight-bold">${fecha_final}</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                          <span class="text-secondary text-xs font-weight-bold">${precio_cuota}</span>
                      </td>
                  </tr>`
        }
        console.log(precioCuotaFinal);
        
        document.querySelector('tbody').innerHTML = tb;
        document.getElementById('data_total').innerHTML = `<tr>
                              <td class="align-middle text-start text-sm">
                                <span class=" text-secondary text-xs font-weight-bold">Monto total de matriculación</span>
                              </td>
                              <td class="align-middle text-start text-sm">
                                <span class="text-secondary text-xs font-weight-bold">${matriculacion}</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="align-middle text-start text-sm">
                                <span class=" text-secondary text-xs font-weight-bold">Monto total de cuotas</span>
                              </td>
                              <td class="align-middle text-start text-sm">
                                <span class="text-secondary text-xs font-weight-bold">${precioCuotaFinal}</span>
                              </td>
                            </tr>

                            <tr>
                              <td class="align-middle text-start text-sm">
                                <span class=" text-secondary text-xs font-weight-bold">Total a pagar</span>
                              </td>
                              <td class="align-middle text-start text-sm">
                                <span class="text-secondary text-xs font-weight-bold">${precioCuotaFinal + matriculacion}</span>
                              </td>
                            </tr>`;

      })

      function eliminarEstudiante(id) {
        data = new FormData();
        data.append('perfil_factura', id);
        // console.log(data.get('id_eliminar'));
        fetch('../controller/eliminar_est.php', {
            method: 'POST',
            body: data
          })
          .then(response => response.text())
          .then(result => {
            console.log(result);
            location.href = 'facturacion.php';
          })
      }
    </script>
    <?php include("../include/configuracion.php") ?>
    <?php include("../include/footer.php") ?>