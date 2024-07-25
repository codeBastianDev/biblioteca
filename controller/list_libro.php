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


foreach ($libro as $value) {
  $data[] = $value;
}

echo json_encode($data); ;
?>