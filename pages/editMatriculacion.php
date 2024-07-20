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

$estDt = $db->joinQuery(array('inscripcion i'),
                        array(2),
                        array("e.id = i.id_estudiante and i.estado = 1 and i.id = {$_GET['id_ins']}"),
                        array("e.id = '{$_GET['id_estudiante']}'"),
                        array('e.foto,e.nombre,e.apellido,i.id_grado, i.id_anio'));
              
foreach ($estDt as $fl) {
  $est[] = $fl;

}

?>

<body class="g-sidenav-show bg-gray-100">
<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('../assets/img/banner_estudiante_creacion.webp'); background-position-y: 50%;">
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
                <?=  (isset($est[0]['nombre']) && isset($est[0]['apellido'])) ? "{$est[0]['nombre']} {$est[0]['apellido']}" : ''  ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?= (isset($est[0]['cargo'])) ? "{$est[0]['cargo']}" : '' ?>
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
              <p class="text-uppercase text-sm">Información de la inscripción</p>
              <?php if($_GET['id_ins'] != 0) { ?>
              <form id="formulario" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="id_estudiante" value="<?= $_GET['id_estudiante'] ?>">
                <input type="hidden" name="id" value="<?= $_GET['id_ins'] ?>">
                <div class="row">
                  <div class="col-md-6 ">
                    <div class="form-group">
                      <label for="grado" class="form-control-label">Grado</label>
                      <select name="grado" id="grado" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php 
                        foreach ((new db('grado'))->cargar() as $v) {
                          $check = ($v['id'] == $est[0]['id_grado'])?'selected':'';
                          echo "<option {$check} value='{$v['id']}'>{$v['nombre']}</option>";
                        } 
                        ?>

                      </select>
                    </div>
                  </div>

                  <div class="col-md-6 ">
                    <div class="form-group">
                      <label for="anio" class="form-control-label">Año electivo</label>
                      <select name="anio" id="anio" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php 
                        foreach ((new db('anio'))->cargar() as $v) {
                          $check = ($v['id'] == $est[0]['id_anio'])?'selected':'';
                          echo "<option {$check} value='{$v['id']}'>{$v['nombre']}</option>";
                        } 
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                   <button class="btn btn-block btn-primary w-100">Editar</button>
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
                              <p>¿Estás seguro de que deseas eliminar permanentemente esta inscripción? Esta acción no se puede deshacer.</p>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <button type="button" onclick="eliminarEstudiante(<?= $_GET['id_ins'] ?>)" class="btn btn-primary">Si</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php }else{
  echo "<div class='alert alert-danger text-white' role='alert'>
         Este estudiante no esta inscripto
        </div>";
} ?>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
   

    function eliminarEstudiante(id) {
      data = new FormData();
      data.append('inscripcion', id);
      // console.log(data.get('id_eliminar'));
      fetch('../controller/eliminar_est.php', {
          method: 'POST',
          body: data
        })
        .then(response => response.text())
        .then(result => {
          console.log(result);
          location.href = 'estudiante.php';
        })
    }
  </script>
  <?php include("../include/configuracion.php") ?>
  <?php include("../include/footer.php") ?>