<?php
include("../class/helper.php");

(new db('inscripcion'))->insert(array(
    'id_anio' =>  $_POST['anio'],
    'id_estudiante' => $_POST['id_estudiante'],  
    'id_grado' => $_POST['grado'],
));

(new facturacion('perfil_factura p',$_POST))->generar_perfil();
header('location:../pages/estudiante.php');
?>