<?php
    include ('../class/helper.php');
    $datos = json_decode(file_get_contents('php://input'));
    if(isset($datos->nombre)){
        $id = isset($datos->id) ?$datos->id:null;
        (new db('categories'))->insert(['nombre'=>$datos->nombre],$id);
    } elseif(isset($datos->delete)){
       (new db('categories'))->eliminar($datos->delete);
    } else if(isset($datos->actualizar)){
      foreach ((new db('categories'))->cargar($datos->actualizar) as  $value) {
        echo json_encode($value);
      } ;
    }
?>