<?php
include_once ("../class/helper.php");
session_start();

$categoria = (new db('categories'))->cargar();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo_trasparente.png">
  <title>Biblioteca Plus</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/4901049ea4.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include_once ("../include/menu.php") ?>
  <main class="main-content position-relative border-radius-lg ">
    <?php include_once ("../include/menuUser.php") ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-5">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-12">
                  <label for="buscador" class="form-control-label">Buscador</label>
                  <input type="search" id="buscador" class="form-control" placeholder="Nombre">
                </div>
            
          
                <div class="col-12 mt-3">
                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Agregar categoria
                </button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div id="contenedor-principal" class="row">
                  <div class="card">
                    <div class="table-responsive">
                      <table class="table align-items-center mb-0">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre
                            </th>      
                            <th class="text-secondary opacity-7"></th>
                            <th class="text-secondary opacity-7"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($categoria as $value): ?>
                            <tr>
                              <td>
                                <p class="text-xs font-weight-bold mb-0"><?=$value['id']?></p>
                              </td>
                              <td>
                                <p class="text-xs font-weight-bold mb-0 " > <span class="nombre_categoria_s"><?=$value['nombre']?></span> </p>
                              </td>
                              <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editar(<?=$value['id']?>)">Editar</button>
                              </td>
                              <td>
                                <button class="btn btn-danger" onclick="eliminar(<?=$value['id']?>)">Eliminar</button>
                              </td>
                            </tr>
                          <?php endforeach?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </main>
  <?php include_once ("../include/configuracion.php") ?>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id_categoria" value="">
          <input type="text" id="nombre_categoria" class="form-control" placeholder="Ingrese la categoria">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gradient-primary" onclick="save_categoria()" >Save changes</button>
      </div>
    </div>
  </div>

</body>

</html>
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

  document.getElementById('buscador').addEventListener('input', function (e) {
    let filterValue = e.target.value.toLowerCase();
    document.querySelectorAll('.lista-libro').forEach(function (card) {
      let cardText = card.textContent.toLowerCase();
      card.style.display = cardText.includes(filterValue) ? '' : 'none';
    });
  });

  function save_categoria(){
    nombre =document.getElementById('nombre_categoria').value
    id = document.getElementById('id_categoria').value
    
    confing ={
      method:"POST",
      headers: {
          "Content-Type": "application/json",
      },
      body:JSON.stringify({nombre:nombre,id:id})
    }

    fetch("../controller/categoria.php",confing)
    setTimeout(()=>{
      location.reload()
    },100)
  }
  function eliminar(id) {
    
    confing ={
      method:"POST",
      headers: {
          "C0ontent-Type": "application/json",
      },
      body:JSON.stringify({delete:id})
    }
    fetch("../controller/categoria.php",confing)
    setTimeout(()=>{
      location.reload()
    },100)
  }
  function editar(id) {
  
    confing ={
      method:"POST",
      headers: {
          "C0ontent-Type": "application/json",
      },
      body:JSON.stringify({actualizar:id})
    }
    fetch("../controller/categoria.php",confing)
    .then(res => res.json())
    .then(data => {
      document.getElementById('nombre_categoria').value = data.nombre;
      document.getElementById('id_categoria').value = data.id;
    })
  }
  
  document.getElementById('buscador').addEventListener('keyup', function (e) {
      let searchValue = e.target.value.toLowerCase();
      let cards = document.querySelectorAll('tr');
      cards.forEach(card => {
        let title = card.querySelector(".nombre_categoria_s");
        console.dir(title);
        // if (title.toLowerCase().includes(searchValue) || searchValue === '') {
        //   card.style.display = 'block';
        // } else {
        //   card.style.display = 'none';
        // }
      });
    });

</script>