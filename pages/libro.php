<?php include_once ("../class/helper.php");
session_start();
$modulo = "Listado de libros";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo_trasparente.png">
  <title>
    Biblioteca Plus
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/4901049ea4.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <style>
    .custom-border {
      border: 2px solid blue;
    }

    .search-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 15px;
    }

    .card {
      width: 100%;
      max-width: 350px;

    }

    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100">
    <div class="position-absolute w-100 min-height-300 top-0"
      style="background-image: url('../assets/img/banner_estudiante_creacion.webp'); background-position-y: 50%;">
      <span class="mask bg-primary opacity-6"></span>
    </div>
  </div>

  <?php include_once ("../include/menu.php") ?>

  <main class="main-content position-relative border-radius-lg ">

    <?php include_once ("../include/menuUser.php") ?>

    <div class="container-fluid py-4">
      <div class="search-container">
        <div class="bg-white border-radius-lg d-flex p-1 custom-border">
          <input type="text" id="buscador" class="form-control form-control-sm border-0 ps-2"
            placeholder="Type here...">
          <button class="btn btn-sm bg-gradient-primary my-1 me-1">Search</button>
        </div>
      </div>
      <div class="row" id="books-container">


      </div>
    </div>
  </main>

  <?php include_once ("../include/configuracion.php") ?>

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


    document.getElementById('buscador').addEventListener('keyup', function (e) {
      let searchValue = e.target.value.toLowerCase();
      let cards = document.querySelectorAll('.lista-libro');
      console.log(cards);
      cards.forEach(card => {
        let title = card.querySelector('.card-title').textContent.toLowerCase();
        console.log(title.includes(searchValue));
        if (title.includes(searchValue) || searchValue === '') {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });


    fetch('../controller/list_libro.php').then(res => res.json()).then(res => {
      res.forEach(e => {
        let button = e.disponibilidad == 1 ? `
                <a href="facturacionPerfil.php?libro=${e.id}" class='btn btn-primary mt-auto rent-btn'>Alquilar</a>`
          : ` <a  class='btn btn-danger mt-auto rent-btn'>No disponible</a>`;
        document.getElementById('books-container').innerHTML += (`<div class='col-md-4 lista-libro'>
                                                            <div class='card mb-4' data-id='1'>
                                                              <img src='${e.imagen}' class='card-img-top' alt='Portada del libro 1'>
                                                              <div class='card-body d-flex flex-column text-center'>
                                                                <h5 class='card-title'>${e.titulo}</h5>
                                                                <p class='card-text'><strong>Editorial:</strong> ${e.editorial}</p>
                                                                <p class='card-text'><strong>Categoria:</strong> ${e.categoria} 
                                                                  <br>
                                                                  <strong>Autor:</strong> ${e.autor ?? ""}
                                                                </p>
                                                                <p class='card-text'>Descripción: ${e.descripcion ?? ""}</p>
                                                                <p class='card-text'>Publicado: ${e.anio_publicacion ?? ""}</p>
                                                                ${button}
                                                              </div>
                                                            </div>
                                                          </div>`)
      });

    })
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>


</body>

</html>