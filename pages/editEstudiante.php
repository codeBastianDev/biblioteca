<?php
include("../include/header.php");
include("../class/helper.php");
$modulo = "Perfil estudiante";
if ($_POST) {
  // Valido si es una imagen

  $acta = ($_FILES['archivo']['error'] == 0) ? subirImg($_FILES['archivo'], '../assets/acta_de_nacimiento/') : '';
  $foto = ($_FILES['foto']['error'] == 0) ? subirImg($_FILES['foto'], '../assets/foto_estudiante/') : '';

  $db = new db('estudiante');
  $db->insert(array(
    'nombre' =>  $_POST['nombre'],
    'documento' => $acta,
    'apellido' => $_POST['apellido'],
    'observaciones' => $_POST['observaciones'],
    'nombre_tutor' => $_POST['nombre_tutor'],
    'apellido_tutor' => $_POST['apellido_tutor'],
    'direccion_tutor' => $_POST['direccion_tutor'],
    'telefono_tutor' => $_POST['telefono'],
    'numero_emergencia' => $_POST['numero_emergencia'],
    'estado' => $_POST['estado'],
    'contacto_emergencia' => $_POST['coctacto_emergencia'],
    'telefono' => $_POST['telefono'],
    'sexo' => $_POST['sexo'],
    'fecha_de_nacimiento' => $_POST['fecha'],
    'sexo_tutor' => $_POST['sexo_tutor'],
    'direccion' => $_POST['direccion'],
    'matricula' => $_POST['matricula'],
    'telefono_tutor' => $_POST['telefono_tutor'],
    'nombre_tutor2' => $_POST['nombre_tutor2'],
    'apellido_tutor2' => $_POST['apellido_tutor2'],
    'direccion_tutor2' => $_POST['direccion_tutor2'],
    'telefono_tutor2' => $_POST['celular_tutor2'],
    'sexo_tutor2' => $_POST['sexo_tutor2'],
    'cedula_tutor' => $_POST['cedula_tutor'],
    'cedula_tutor2' => $_POST['cedula_tutor2'],
    'foto' =>  $foto
  ), $_POST['id']);

  echo "<script>  location.href = 'estudiante.php'  </script>";

  exit();
};


$db = new db('estudiante e');
$est = [];
$estDt = $db->joinQuery(
  array('inscripcion i', 'grado g'),
  array(2, 2, 2),
  array('i.id_estudiante = e.id', 'i.id_grado = g.id'),
  array("e.id = {$_GET['id']}"),
  array(
    'e.*',
    'g.nombre as grado',
  )
);
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
              <p class="text-uppercase text-sm">Información del estudiante</p>

              <form id="formulario" method="post" action="editEstudiante.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombre" class="form-control-label">Nombre</label>
                      <input class="form-control" id="nombre" name="nombre" type="text" value="<?= (isset($est[0]['nombre'])) ? $est[0]['nombre'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="apellido" class="form-control-label">Apellido</label>
                      <input class="form-control" id="apellido" type="text" name="apellido" value="<?= (isset($est[0]['apellido'])) ? $est[0]['apellido'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="matricula" class="form-control-label">Matricula</label>
                      <input class="form-control" id="matricula" name="matricula" type="text" value="<?= (isset($est[0]['matricula'])) ? $est[0]['matricula'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha" class="form-control-label">Fecha de nacimiento</label>
                      <input class="form-control" id="fecha" type="date" name="fecha" value="<?= (isset($est[0]['fecha_de_nacimiento'])) ? $est[0]['fecha_de_nacimiento'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="foto" class="form-control-label">Foto</label>
                      <input class="form-control" id="foto" type="file" name="foto">
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sexo" class="form-control-label">Sexo</label>
                      <select name="sexo" class="form-control" id="sexo">
                        <option value="">Seleccione</option>
                        <option <?= (isset($est[0]['sexo']) &&  $est[0]['sexo'] == 1) ? 'selected' : '' ?> value="1">Masculino</option>
                        <option <?= (isset($est[0]['sexo']) &&  $est[0]['sexo'] == 2) ? 'selected' : '' ?> value="2">Femenino</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="direccion" class="form-control-label">Dirreción</label>
                      <input type="text" id="direccion" class="form-control" name="direccion" value="<?= isset($est[0]['direccion']) ? $est[0]['direccion'] : '' ?>">
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
                      <label for="acta" class="form-control-label">Acta</label>
                      <input type="file" class="form-control mb-3" name="archivo" id="acta">
                      <?php if (!empty($est[0]['documento'])) : ?>
                        <a href="../assets/acta_de_nacimiento/<?= $est[0]['documento']?>" target="_blank" class="btn btn-primary">Visualizar</a>
                      <?php endif ?>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="observaciones" class="form-control-label">Observaciones</label>
                      <textarea class="form-control" id="observaciones" name='observaciones' cols="30" rows="5"><?= isset($est[0]['observaciones']) ? $est[0]['observaciones'] : '' ?></textarea>
                    </div>
                  </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Padres / tutor principal</p>
                <div class="row">
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="nombreTutor" class="form-control-input">Nombre</label>
                      <input type="text" class="form-control" id="nombreTutor" name="nombre_tutor" value="<?= isset($est[0]['nombre_tutor']) ? $est[0]['nombre_tutor'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="apellidoTutor" class="form-control-input">Apellido</label>
                      <input type="text" class="form-control" id="apellidoTutor" name="apellido_tutor" value="<?= isset($est[0]['apellido_tutor']) ? $est[0]['apellido_tutor'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="cedula" class="form-control-input">Cedula</label>
                      <input type="text" class="form-control" id="cedula" name="cedula_tutor" value="<?= isset($est[0]['cedula_tutor']) ? $est[0]['cedula_tutor'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="direccion_tutor" class="form-control-label">Dirreción</label>
                      <input class="form-control" id="direccion_tutor" type="text" name="direccion_tutor" value="<?= isset($est[0]['direccion_tutor2']) ? $est[0]['direccion_tutor2'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono_tutor" class="form-control-label">Número Telefonico</label>
                      <input class="form-control" id="telefono_tutor" type="text" name="telefono_tutor" value="<?= isset($est[0]['telefono_tutor2']) ? $est[0]['telefono_tutor2'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="fomr-group">
                      <label for="sexo_tutor" class="form-control-input">Sexo</label>
                      <select name="sexo_tutor" id="sexo_tutor" class="form-control">
                        <option value=""> Seleccione</option>
                        <option <?= (isset($est[0]['sexo_tutor']) &&  $est[0]['sexo_tutor2'] == 1) ? 'selected' : '' ?> value="1">Masculino</option>
                        <option <?= (isset($est[0]['sexo_tutor']) &&  $est[0]['sexo_tutor2'] == 2) ? 'selected' : '' ?> value="2">Femenino</option>
                      </select>
                    </div>
                  </div>

                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Padres / tutor secundario</p>
                <div class="row">
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="nombreTutor" class="form-control-input">Nombre</label>
                      <input type="text" class="form-control" id="nombreTutor" name="nombre_tutor2" value="<?= isset($est[0]['nombre_tutor2']) ? $est[0]['nombre_tutor2'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="apellidoTutor" class="form-control-input">Apellido</label>
                      <input type="text" class="form-control" id="apellidoTutor" name="apellido_tutor2" value="<?= isset($est[0]['apellido_tutor2']) ? $est[0]['apellido_tutor2'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="fomr-group">
                      <label for="cedula" class="form-control-input">Cedula</label>
                      <input type="text" class="form-control" id="cedula" name="cedula_tutor2" value="<?= isset($est[0]['cedula_tutor2']) ? $est[0]['cedula_tutor2'] : '' ?> ">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="direccion_tutor" class="form-control-label">Dirreción</label>
                      <input class="form-control" id="direccion_tutor" type="text" name="direccion_tutor2" value="<?= isset($est[0]['direccion_tutor']) ? $est[0]['direccion_tutor'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="numero_celular" class="form-control-label">Número de celular</label>
                      <input class="form-control" id="numero_celular" type="text" name="celular_tutor2" value="<?= isset($est[0]['telefono_tutor2']) ? $est[0]['telefono_tutor2'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="fomr-group">
                      <label for="sexo_tutor" class="form-control-input">Sexo</label>
                      <select name="sexo_tutor2" id="sexo_tutor" class="form-control">
                        <option value=""> Seleccione</option>
                        <option <?= (isset($est[0]['sexo_tutor']) &&  $est[0]['sexo_tutor'] == 1) ? 'selected' : '' ?> value="1">Masculino</option>
                        <option <?= (isset($est[0]['sexo_tutor']) &&  $est[0]['sexo_tutor'] == 2) ? 'selected' : '' ?> value="2">Femenino</option>
                      </select>
                    </div>
                  </div>
                  
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Contacto de emergencia</p>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombre_contacto" class="form-control-label">Nombre del contacto de emergencia</label>
                      <input class="form-control" id="nombre_contacto" type="text" name="coctacto_emergencia" value="<?= isset($est[0]['contacto_emergencia']) ? $est[0]['contacto_emergencia'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="numero_emergencia" class="form-control-label">Número de contacto</label>
                      <input class="form-control" id="numero_emergencia" type="text" name="numero_emergencia" value="<?= isset($est[0]['numero_emergencia']) ? $est[0]['numero_emergencia'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="Estado" class="form-control-label">Estado</label>
                      <select name="estado" id="Estado" class="form-control">
                        <option <?= (isset($est[0]['estado']) &&  $est[0]['estado'] == 1) ? 'selected' : '' ?> value="1">Activo</option>
                        <option <?= (isset($est[0]['estado']) &&  $est[0]['estado'] == 2) ? 'selected' : '' ?> value="2">Inactivo</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <input type="submit" class="btn btn-primary w-100" value="Guardar">
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
      data.append('estudiante', id);
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