<?php 
include("../controller/prestamo.php.php");
$id = json_decode(file_get_contents('php://input'));
_log($id);

prestamo::fin_prestamo();

?>