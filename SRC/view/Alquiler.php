<?php include('./layout/header.php') ?>

  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card mb-4" data-id="1">
          <img src="https://www.isliada.org/static/images/2021/02/marte-rojo.jpg" class="card-img-top"
            alt="Portada del libro 1">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title">Marte Rojo</h5>
            <p class="card-text">Autor: Kim Stanley Robinson</p>
            <p class="card-text">Precio: $10</p>
            <p class="card-text">Una epopeya de ciencia ficción que explora la colonización de Marte.</p>
            <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-4" data-id="2">
          <img src="https://images-na.ssl-images-amazon.com/images/I/51UoqRAxwEL.jpg" class="card-img-top"
            alt="Portada del libro 2">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title">Harry Potter</h5>
            <p class="card-text">Autor: J.K. Rowling</p>
            <p class="card-text">Precio: $8</p>
            <p class="card-text">Las aventuras de un joven mago en Hogwarts.</p>
            <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-4" data-id="3">
          <img src="https://th.bing.com/th/id/OIP.Aft1jKeeTXxWFVdKYjYDtgAAAA?rs=1&pid=ImgDetMain" class="card-img-top"
            alt="Portada del libro 3">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title">El Hobbit</h5>
            <p class="card-text">Autor: J.R.R. Tolkien</p>
            <p class="card-text">Precio: $12</p>
            <p class="card-text">La precuela de El Señor de los Anillos, una aventura épica en la Tierra Media.</p>
            <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-4" data-id="4">
          <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png"
            class="card-img-top" alt="Portada del libro 4">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title">1984</h5>
            <p class="card-text">Autor: George Orwell</p>
            <p class="card-text">Precio: $9</p>
            <p class="card-text">Una visión distópica del futuro bajo un régimen totalitario.</p>
            <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal para visualizar libros alquilados -->
  <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Libros Alquilados</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="cart-items-modal" class="list-group">
            <!-- Aquí se añadirán los libros alquilados -->
          </ul>
          <div class="text-right mt-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <script src="AlquilerAnimaciones.js"></script>
</body>

</html>

<?php include('./layout/foooter.php') ?>