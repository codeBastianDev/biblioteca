<?php include_once("../class/helper.php");
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
    <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('../assets/img/banner_estudiante_creacion.webp'); background-position-y: 50%;">
      <span class="mask bg-primary opacity-6"></span>
    </div>
  </div>
  
  <?php include_once("../include/menu.php") ?>
 
  <main class="main-content position-relative border-radius-lg ">
    
    <?php include_once("../include/menuUser.php") ?>
    
    <div class="container-fluid py-4">
      <div class="search-container">
        <div class="bg-white border-radius-lg d-flex p-1 custom-border">
          <input type="text" id="buscador" class="form-control form-control-sm border-0 ps-2" placeholder="Type here...">
          <button class="btn btn-sm bg-gradient-primary my-1 me-1">Search</button>
        </div>
      </div>
      <div class="row" id="books-container">
        <div class="col-md-3">
          <div class="card mb-4" data-id="1">
            <img src="https://www.isliada.org/static/images/2021/02/marte-rojo.jpg" class="card-img-top" alt="Portada del libro 1">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">Marte Rojo</h5>
              <p class="card-text"><strong>Autor: Kim Stanley Robinson</strong></p>
              <p class="card-text">Categoria: Ciencia ficción</p>
              <p class="card-text">Una epopeya de ciencia ficción que explora la colonización de Marte.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="2">
            <img src="https://images-na.ssl-images-amazon.com/images/I/51UoqRAxwEL.jpg" class="card-img-top" alt="Portada del libro 2">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">Harry Potter</h5>
              <p class="card-text"><strong>Autor: J.K. Rowling</strong></p>
              <p class="card-text">Categoria: Libros de fantasía</p>
              <p class="card-text">Las aventuras de un joven mago en Hogwarts.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="3">
            <img src="https://th.bing.com/th/id/OIP.Aft1jKeeTXxWFVdKYjYDtgAAAA?rs=1&pid=ImgDetMain" class="card-img-top" alt="Portada del libro 3">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">El Hobbit</h5>
              <p class="card-text"><strong>Autor: J.R.R. Tolkien</strong></p>
              <p class="card-text">Categoria: Raza ficticia</p>
              <p class="card-text">La precuela de El Señor de los Anillos, una aventura épica en la Tierra Media.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="4">
            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png" class="card-img-top" alt="Portada del libro 4">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">1984</h5>
              <p class="card-text"><strong>Autor: George Orwell</strong></p>
              <p class="card-text">Categoria: Novela distópica</p>
              <p class="card-text">Una visión distópica del futuro bajo un régimen totalitario.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <!-- Nuevos libros -->
        <div class="col-md-3">
          <div class="card mb-4" data-id="5">
            <img src="https://th.bing.com/th/id/R.f6233258b73b5bd526265ef6ff8b9267?rik=qggb8vLMS4IW%2fQ&riu=http%3a%2f%2fcdn.pastemagazine.com%2fwww%2farticles%2f2019%2f12%2f06%2fdunebbc19final.jpg&ehk=C27WIAWUwb%2bJjZMmvZNZl6oQ2EYWoEwdw%2fmXABFlz1A%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Portada del libro 5">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">Dune</h5>
              <p class="card-text"><strong>Autor: Frank Herbert</strong></p>
              <p class="card-text">Categoria: Ciencia ficción</p>
              <p class="card-text">La historia épica de la lucha por el control del desértico planeta Arrakis.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg/1024px-To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg" class="card-img-top" alt="Portada del libro 6">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">To Kill a Mockingbird</h5>
              <p class="card-text"><strong>Autor: Harper Lee</strong></p>
              <p class="card-text">Categoria: Ficción</p>
              <p class="card-text">Una reflexión sobre el racismo y la injusticia en el sur de Estados Unidos.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="7">
            <img src="https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781471134746/pride-and-prejudice-9781471134746_hr.jpg" class="card-img-top" alt="Portada del libro 7">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">Pride and Prejudice</h5>
              <p class="card-text"><strong>Autor: Jane Austen</strong></p>
              <p class="card-text">Categoria: Novela romántica</p>
              <p class="card-text">Una historia clásica de amor y malentendidos en la Inglaterra del siglo XIX.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="8">
            <img src="https://th.bing.com/th/id/R.1213a0ff91c94b884330e362841704a1?rik=zQDdn4XMYcbdsw&pid=ImgRaw&r=0" class="card-img-top" alt="Portada del libro 8">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">The Catcher in the Rye</h5>
              <p class="card-text"><strong>Autor: J.D. Salinger</strong></p>
              <p class="card-text">Categoria: Ficción</p>
              <p class="card-text">Las experiencias de Holden Caulfield en Nueva York.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="9">
            <img src="https://th.bing.com/th/id/OIP.Wq5p6Atal6UNAX9uAPB2bAHaK4?rs=1&pid=ImgDetMain" class="card-img-top" alt="Portada del libro 9">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">Brave New World</h5>
              <p class="card-text"><strong>Autor: Aldous Huxley</strong></p>
              <p class="card-text">Categoria: Ciencia ficción</p>
              <p class="card-text">Una visión del futuro en una sociedad altamente controlada.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mb-4" data-id="10">
            <img src="https://th.bing.com/th/id/OIP.MSu1wkGWxI_-D58jiDFjogHaJt?rs=1&pid=ImgDetMain" class="card-img-top" alt="Portada del libro 10">
            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title">The Great Gatsby</h5>
              <p class="card-text"><strong>Autor: F. Scott Fitzgerald</strong></p>
              <p class="card-text">Categoria: Ficción</p>
              <p class="card-text">La historia del misterioso millonario Jay Gatsby y su amor por Daisy Buchanan.</p>
              <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
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
      let searchValue = e.target.value.toLowerCase();
      let cards = document.querySelectorAll('#books-container .card');

      cards.forEach(card => {
        let title = card.querySelector('.card-title').textContent.toLowerCase();
        if (title.includes(searchValue) || searchValue === '') {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  <script src="../assets/js/books.js"></script>

</body>

</html>
