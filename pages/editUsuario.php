<?php
$modulo = "Listado de usuario";
include("../class/helper.php");
include("../include/header.php");

if($_POST){
  if($_POST){
    $id = $_POST['id'] > 0 ? $_POST['id'] :null;
    $user = new db('users');
    $user->insert([
     'nombre'=>$_POST['nombre'],
     'apellido'=>$_POST['apellido'],
     'email'=>$_POST['email'],
     'contrasena'=>$_POST['contrasena'],
     'telefono'=>$_POST['telefono'],
     'direccion'=>$_POST['direccion'],
     'tipo'=>$_POST['tipo'],
    ],$id);
   header("location: usuario.php");
 }
  exit;
}

if($_GET){
 foreach ((new db('users'))->cargar($_GET['id']) as  $value) {
  $est[] =$value;
 } ;
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
              <img src="../assets/fotoUsuarios/<?= isset($est[0]['foto']) && !empty($est[0]['foto']) ? $est[0]['foto'] : 'sinFoto.jpg' ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?= (isset($est[0]['nombre']) && isset($est[0]['apellido'])) ? "{$est[0]['nombre']} {$est[0]['apellido']}" : ''  ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?= (isset($est[0]['cargo'])) ? "{$est[0]['cargo']}" : '' ?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">

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
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombre" class="form-control-label">Nombre</label>
                      <input class="form-control" id="nombre" name="nombre" type="text" value="<?= (isset($est[0]['nombre'])) ? $est[0]['nombre'] : '' ?>" required>
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
                      <label for="cedula" class="form-control-label">Contraseña</label>
                      <input class="form-control" id="cedula" name="contrasena" type="text" value="<?= (isset($est[0]['contrasena'])) ? $est[0]['contrasena'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="direccion" class="form-control-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name='direccion' cols="30" rows="5"><?= isset($est[0]['direccion']) ? $est[0]['direccion'] : '' ?></textarea>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="telefono" class="form-control-label">Número de telefono</label>
                      <input type="text" id="telefono" class="form-control" name="telefono" value="<?= isset($est[0]['telefono']) ? $est[0]['telefono'] : '' ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email" class="form-control-label">Correo</label>
                      <input type="email" id="email" class="form-control" required name="email" value="<?= isset($est[0]['email']) ? $est[0]['email'] : '' ?>">
                    </div>
                  </div>
             


                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="Estado" class="form-control-label">Tipo</label>
                      <select name="tipo" id="tipo" class="form-control">
                        <option <?= (isset($est[0]['tipo']) &&  $est[0]['tipo'] == 1) ? 'selected' : '' ?> value="1">Cliente</option>
                        <option <?= (isset($est[0]['tipo']) &&  $est[0]['tipo'] == 2) ? 'selected' : '' ?> value="2">Admin</option>
                      </select>
                    </div>
                  </div>
         
                  <br>
                  <div class="col-6 mt-3">
                    <input type="submit" class="btn btn-primary btn-block w-100" value="Guardar">
                  </div>
                  <div class="col-md-6 mt-3">
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
                              <p>¿Estás seguro de que deseas eliminar permanentemente a este usuario? Esta acción no se puede deshacer.</p>
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
      data.append('users', id);

      fetch('../controller/eliminar_est.php', {
          method: 'POST',
          body: data
        })
        .then(response => response.text())
        .then(result => {
          console.log(result);
          location.href = 'usuario.php';
        })
    }
  </script>
  <?php include("../include/configuracion.php") ?>
  <?php include("../include/footer.php") ?>