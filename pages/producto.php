<?php  
include_once ("../class/helper.php");  
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', ''); 
$query = $pdo->query("SELECT DISTINCT nombre FROM categories");
$categorias = $query->fetchAll(PDO::FETCH_ASSOC);
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
  <?php include_once("../include/menu.php")?>
  <main class="main-content position-relative border-radius-lg ">
    <?php include_once("../include/menuUser.php")?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-5">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-7">
                  <label for="buscador" class="form-control-label">Buscador</label>
                  <input type="search" id="buscador" class="form-control" placeholder="Nombre">
                </div>
                <div class="col-3">
                  <label for="categoria" class="form-control-label">Categoría</label>
                  <select id="categoria" class="form-control filtro" filtro='categoria' onchange="filtro(event)">
                    <option value="0">Todos</option>
                    <?php foreach ($categorias as $categoria): ?>
                      <option value="<?= htmlspecialchars($categoria['nombre']) ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-2">
                  <label for="estado" class="form-control-label">Estado</label>
                  <select id="estado" class="form-control filtro" filtro='estado' onchange="filtro(event)">
                    <option value="0">Todos</option>
                    <option selected value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>
                <div class="col-12 mt-3">
                  <a href="editProducto.php?id=-1" class="btn btn-success"><i class="ni ni-fat-add"></i> Agregar Libro</a>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div id="contenedor-principal" class="row"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include_once("../include/configuracion.php") ?>
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

    document.getElementById('buscador').addEventListener('input', function(e) {
      let filterValue = e.target.value.toLowerCase();
      document.querySelectorAll('.lista-libro').forEach(function(card) {
        let cardText = card.textContent.toLowerCase();
        card.style.display = cardText.includes(filterValue) ? '' : 'none';
      });
    });

    function filtro(e) {
      let formulario = new FormData();
      let filtros = document.querySelectorAll('.filtro');
      filtros.forEach(input => {
        let value = input.value;
        if (value) {
          formulario.append(input.getAttribute('filtro'), value);
        }
      });

      fetch('list_libro.php', {
        method: 'POST',
        body: formulario
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById('contenedor-principal').innerHTML = data;
      })
      .catch(error => console.error('Error fetching data:', error));
    }

    // Initial fetch to populate the table
    fetch('list_libro.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('contenedor-principal').innerHTML = data;
      })
      .catch(error => console.error('Error fetching data:', error));
  </script>
</body>
</html>
