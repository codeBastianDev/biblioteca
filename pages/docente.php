<?php  
session_start();
$modulo = "Listado de docente";
include_once ("../class/helper.php");  
$grados = new db('grado');
$g ='';
$permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 5");
foreach ($grados->cargar() as $fl ) {
$g .= "<option value='{$fl['id']}'>{$fl['nombre']}</option>";
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo_trasparente.png">
  <title>
    Colegio Abraham
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/4901049ea4.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('../assets/img/docente_banner.jpeg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <!-- slider -->
  <?php include_once("../include/menu.php")?>
  <!-- slider end-->
  <main class="main-content position-relative border-radius-lg ">
     <!--  Navbar -->
     <?php include_once("../include/menuUser.php")?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-5">
            <div class="card-header pb-0">
            <div class="row">
              <div class="col-4">
                <label for="" class="form=control-label">Buscador</label>
                <input type="search" id="buscador" class="form-control" placeholder="Nombre">
              </div>

              <div class="col-3">
              <label for="" class="form=control-label">Grado</label>
                <select name="" id="" filtro='g__id' class="form-control filtro" onchange="filtro(event)">
                  <option value="">Seleccione</option>
                  <?= $g ?>
                </select>
              </div>
              <div class="col-3">
              <label for="estado" name="estado" class="form-control-label">Estado</label>
                <select  id="estado" class="form-control filtro" filtro='d__estado' onchange="filtro(event)">
                  <option value="0">Todos</option>
                  <option selected value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <div class="col-1">
              <?php if(!empty($permiso)): ?>
                <label class="form-conrol-label">Agreg.</label>
                <a href="editdocente.php?id=0" class="btn btn-success"><i class="ni ni-fat-add"></i> </a>
                <?php endif?>
              </div>
            </div>
              
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cédula</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Grado</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Salario</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="contenedor-principal">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>
 <!-- Configuracion -->
 <?php include_once("../include/configuracion.php") ?>
 <!-- Configuracion end-->
       
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>

<script>
  let  buscador = document.getElementById('buscador');

    buscador.addEventListener('input',(e)=>{
    document.querySelectorAll('.estudiante').forEach(est =>{
      if(!est.querySelector('.est').textContent.toLowerCase().includes(e.target.value.toLowerCase())){
        est.style.display = 'NONE';
      }else{
        est.style.display = '';
      }
    })
  })


  
  // fetch('../controller/listEstudiante.php').then(resul => resul.text()).then(r => console.log(r));
  function filtro (e){
    let formulario = new FormData();
    document.querySelectorAll('.filtro')
    let date = (e.target.getAttribute('filtro'));
    let filtros = document.querySelectorAll('.filtro').forEach(input=>{

      if(input.value){
        data = input.value;
        indice = input.getAttribute('filtro')
        formulario.append(indice,data);
      }
})

  fetch('../controller/listDocente.php', {
      method: 'POST',
      body:formulario
    })
    .then(r => r.text())
    .then(datos =>{
      document.getElementById('contenedor-principal').innerHTML = `${datos}`;
    }
    );
  }


  fetch('../controller/listDocente.php')
  .then(resul => resul.text())
  .then(r =>{
    
    document.getElementById('contenedor-principal').innerHTML = `${r}`;
  });
  
  // function ira(){
  //   fetch('editEstudiante.php',{
  //     method:'POST',
  //     body:'sebastian'
  //   }).then(responde =>{
  //     if(responde.ok){
  //       location.href ='editEstudiante.php';
  //     }
  //   })

    
    
  // }

</script>