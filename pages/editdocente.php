<?php
$modulo = "Listado de docente";
include("../include/header.php");
include("../class/helper.php");

if ($_POST) {
  // Valido si es una imagen

  $foto = ($_FILES['foto']['error'] == 0) ? subirImg($_FILES['foto'], '../assets/fotoDocente/') : '';
 





  $db = new db('docente');
  $db->insert(array(
    'nombre' =>  $_POST['nombre'],
    'apellido' => $_POST['apellido'],
    'estado' => $_POST['estado'],
    'telefono' => $_POST['telefono'],
    'direccion' => $_POST['direccion'],
    'cedula' => $_POST['cedula'],
    'id_grado' => implode(',',$_POST['grado']),
    'salario' => $_POST['salario'],
    'estado' => $_POST['estado'],
    'foto' =>  $foto
  ), $_POST['id']);

  echo "<script>  location.href = 'docente.php'  </script>";

  exit();
};


$db = new db('docente d');
$est = [];
$estDt = $db->joinQuery(
  array('grado g'),
  array(0),
  array('d.id_grado = g.id'),
  array("d.id = {$_GET['id']}"),
  array(
    'd.*',
    'g.nombre as grado',
  )
);
foreach ($estDt as $fl) {

  $est[] = $fl;
}

// _log($est);
?>

<body class="g-sidenav-show bg-gray-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('../assets/img/docente_banner.jpeg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
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
                <?= (isset($est[0]['nombre']) && isset($est[0]['apellido'])) ? "{$est[0]['nombre']} {$est[0]['apellido']}" : ''  ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?= (isset($est[0]['grado'])) ? "{$est[0]['grado']}" : '' ?>
              </p>
            </div>
          </div>
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
              <p class="text-uppercase text-sm">Información del docente</p>

              <form id="formulario" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombre" class="form-control-label">Nombre</label>
                      <input class="form-control" id="nombre" name="nombre" type="text" required value="<?= (isset($est[0]['nombre'])) ? $est[0]['nombre'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="apellido" class="form-control-label">Apellido</label>
                      <input class="form-control" id="apellido" type="text" name="apellido" required value="<?= (isset($est[0]['apellido'])) ? $est[0]['apellido'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cedula" class="form-control-label">Cédula</label>
                      <input class="form-control" id="cedula" name="cedula" type="text" value=" <?= (isset($est[0]['cedula'])) ? $est[0]['cedula'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="direccion" class="form-control-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name='direccion' cols="30" rows="5"><?= isset($est[0]['direccion']) ? $est[0]['direccion'] : '' ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="foto" class="form-control-label">Foto</label>
                      <input class="form-control" id="foto" type="file" name="foto">
                    </div>
                  </div>


                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="salario" class="form-control-label">Salario</label>
                      <input type="text" id="salario" class="form-control" name="salario" value="<?= isset($est[0]['salario']) ? $est[0]['salario'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono" class="form-control-label">Número de telefono</label>
                      <input type="text" id="telefono" class="form-control" name="telefono" value="<?= isset($est[0]['telefono']) ? $est[0]['telefono'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="grado" class="form-control-label">Grado</label>
                      <select name="grado[]" multiple class="form-control" id="grado">
                        <option value="-1">Seleccione</option>
                        <?php $grados = new db('grado');
                        foreach ($grados->cargar() as $fl) {
                          $check = $est[0]['id_grado'] == $fl['id'] ? 'selected':'';
                        echo "<option {$check} value='{$fl['id']}'>{$fl['nombre']}</option>";
                        }; ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="Estado" class="form-control-label">Estado</label>
                      <select name="estado" id="Estado" class="form-control">
                        <option <?= (isset($est[0]['estado']) &&  $est[0]['estado'] == 1) ? 'selected' : '' ?> value="1">Activo</option>
                        <option <?= (isset($est[0]['estado']) &&  $est[0]['estado'] == 2) ? 'selected' : '' ?> value="2">Inactivo</option>
                      </select>
                    </div>
                  </div>
                    
                  <div class="col-md-6">
                    <input type="submit" class="btn btn-primary btn-block w-100" value="Guardar">
                  </div>
                  <div class="col-md-6">
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
    // document.getElementById('formulario').addEventListener('submit', function(event) {
    //   event.preventDefault(); // Evitar el envío normal del formulario

    //   const formData = new FormData(this);
    //   console.log(formData);
    //   for (const pair of formData.entries()) {
    //       console.log(pair[0] + ': ' + pair[1]);
    //   }
    // fetch('procesar_formulario.php', {
    //     method: 'POST',
    //     body: formData
    // })
    // .then(response => response.text())
    // .then(data => {
    //     console.log('Respuesta del servidor:', data);
    // })
    // .catch(error => {
    //     console.error('Error en la solicitud:', error);
    // });
    // });

    function eliminarEstudiante(id) {
      data = new FormData();
      data.append('docente', id);
      // console.log(data.get('id_eliminar'));
      fetch('../controller/eliminar_est.php', {
          method: 'POST',
          body: data
        })
        .then(response => response.text())
        .then(result => {
          console.log(result);
          location.href = 'docente.php';
        })
    }
  </script>
  <?php include("../include/configuracion.php") ?>
  <?php include("../include/footer.php") ?>