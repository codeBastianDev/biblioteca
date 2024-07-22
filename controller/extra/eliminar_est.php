<?php
include('../class/helper.php');
if(isset($_POST))
{
    
    $table = array_keys($_POST) ;
    $data =implode(',',$_POST);

    $db = new db("$table[0]");
    $db->eliminar($data);
    echo 'Estudiante elimiando';
}

?>