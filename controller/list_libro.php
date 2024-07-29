<?php
include ('../class/helper.php');
$modulo = "Listado de libros";
$datos = json_decode(file_get_contents('php://input'));

if(!empty($datos)){

  $datos = getFiltro(get_object_vars($datos));
}else{
  $datos = null;
};

$libro = (new db('books b'))
            ->joinQuery(
                ['categories c'],
                ['0'],
                ['c.id = b.categoria_id'],
                 $datos,
                ['b.*','c.nombre categoria'],"GROUP By b.id"                          
            );


foreach ($libro as $value) {
  $data[] = $value;
}

echo json_encode($data); ;
?>