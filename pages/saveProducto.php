<?php
include_once ("../class/helper.php");
$id = isset($_POST['id']) ? (int)$_POST['id'] : -1;
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$categoria_id = $_POST['categoria_id'];
$descripcion = $_POST['descripcion'];
$isbn = $_POST['isbn'];


$imagen = $_POST['imagen']; 

try {
    if ($id == -1) {
        
        $query = $pdo->prepare("INSERT INTO books (titulo, autor, categoria_id, descripcion, isbn, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$titulo, $autor, $categoria_id, $descripcion, $isbn, $imagen]);
    } else {
     
        $query = $pdo->prepare("UPDATE books SET titulo = ?, autor = ?, categoria_id = ?, descripcion = ?, isbn = ?, imagen = ? WHERE id = ?");
        $query->execute([$titulo, $autor, $categoria_id, $descripcion, $isbn, $imagen, $id]);
    }

   
    header("Location: producto.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
