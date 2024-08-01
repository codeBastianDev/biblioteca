<?php 
include("./prestamo.php");
$id = json_decode(file_get_contents('php://input'));
(new db('reservations'))->insert(['estado' =>2],$id->prestamo);
(new db('books'))->insert(['disponibilidad' =>1],$id->libro);

?>