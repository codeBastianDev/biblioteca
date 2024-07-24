<?php
include ('../class/helper.php');
$modulo = "Listado de libros";

session_start();
$libro = (new db('books b'))
            ->joinQuery(
                ['categories c'],
                ['0'],
                ['c.id = b.categoria_id'],
                null,
                ['b.*','c.nombre categoria']                          
            );
$html = "";
foreach ($libro as $value) {

    $html .= "<div class='col-md-3 lista-libro'>
          <div class='card mb-4' data-id='1'>
            <img src='{$value['imagen']}' class='card-img-top' alt='Portada del libro 1'>
            <div class='card-body d-flex flex-column text-center'>
              <h5 class='card-title'>{$value['titulo']}</h5>
              <p class='card-text'><strong>Autor: {$value['titulo']}</strong></p>
              <p class='card-text'>Categoria: {$value['categoria']}</p>
              <p class='card-text'>{$value['descripcion']}</p>
              <button class='btn btn-primary mt-auto rent-btn'>Alquilar</button>
            </div>
          </div>
        </div>";
}

echo $html ;
?>