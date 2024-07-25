<?php

include_once ("../controller/libro.php");
if($_POST){
  extract($_POST);
  $valor = [
  'titulo' => $titulo,
  'autor' => $autor,
  'editorial' => $editorial,
  'anio' => $anio,
  'image' => $imagen,
  'descripcion' =>$descripcion,
  'categoria'=>$categoria_id
  ];
  // _log($valor);
   $libro = new libro($id);
   $libro->save($valor);
   header("Location: http://localhost/book/biblioteca/pages/producto.php");
   exit;
} ;
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', ''); // Cambia las credenciales si es necesario

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$book = null;

if ($id != -1) {
    $query = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $query->execute([$id]);
    $book = $query->fetch(PDO::FETCH_ASSOC);
}
// _log($book);
// Obtener las categorías existentes
$query = $pdo->query("SELECT * FROM categories");
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
  <link href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
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
              <h6>Agregar/Editar Libro</h6>
            </div>
            <div class="card-body">
              <form method="post" action="#">
                <input type="hidden" name="id" value="<?= $book['id'] ?? 0 ?>">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="titulo">Título</label>
                      <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $book['titulo'] ?? '' ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="autor">Autor</label>
                      <input type="text" class="form-control" id="autor" name="autor" value="<?= $book['autor'] ?? '' ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="categoria">Categoría</label>
                      <select class="form-control" id="categoria" name="categoria_id" required>
                        <?php foreach ($categorias as $categoria): ?>
                          <option value="<?= $categoria['id'] ?>" <?= isset($book['categoria_id']) && $book['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>><?= $categoria['nombre'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="isbn">Editorial</label>
                      <input type="text" class="form-control" id="isbn" name="editorial" value="<?= $book['editorial'] ?? '' ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="imagen">Imagen (URL)</label>
                      <input type="text" class="form-control" id="imagen" name="imagen" value="<?= $book['imagen'] ?? '' ?>" placeholder="https://example.com/imagen.jpg">
                      <?php if (!empty($book['imagen'])): ?>
                        <img src="<?= $book['imagen'] ?>" alt="Imagen del libro" class="img-thumbnail mt-2" style="max-width: 200px;">
                      <?php endif; ?>
                      
                    </div>
                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="anio">Año de publicación</label>
                      <input type="number" class="form-control" id="anio" name="anio" value="<?= $book['anio_publicacion'] ?? '' ?>" placeholder="" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="descripcion">Descripción</label>
                  <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?= $book['descripcion'] ?? '' ?></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-3">Guardar</button>
              </form>
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
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
