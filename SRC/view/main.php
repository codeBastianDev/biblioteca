<?php include('./layout/header.php') ?>

<h1 class="mb-4">Bienvenido a tu bibliote virtual <i class="fa-solid fa-book"></i></h1>
<main>
    <div class="d-flex gap-2 w-100 flex-wrap justify-content-around">
        <?php for($i = 0; $i < 4 ; $i++): ?>
        <div class="col-md-3">
            <div class="card mb-4" data-id="4">
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png" class="card-img-top" alt="Portada del libro 4">
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title">1984</h5>
                    <p class="card-text">Autor: George Orwell</p>
                    <p class="card-text">Precio: $9</p>
                    <p class="card-text">Una visión distópica del futuro bajo un régimen totalitario.</p>
                    <button class="btn btn-primary mt-auto rent-btn">Alquilar</button>
                </div>
            </div>
        </div>
        <?php endfor ?>
    </div>

</main>
<?php include('./layout/foooter.php') ?>