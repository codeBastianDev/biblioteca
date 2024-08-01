<?php 
include('../class/helper.php');
if (!empty($_POST['usuario']) &&  !empty($_POST['contrasena'])) {
$acceso = false;
$login = new db('users');
$s= $login->cargar(null,array(" nombre = '{$_POST['usuario']}'","contrasena = '{$_POST['contrasena']}' "));
foreach ($s as $key ) {
 $acceso = (isset($key))?true:false;
}
if($acceso == true){
    session_start();
    $_SESSION['usuario'] = "{$key['nombre']}  {$key['apellido']}"; 
    $_SESSION['id'] = $key['id'];
    $_SESSION['tipo'] = $key['tipo'];
    header('location:../pages/dashboard.php');
}else{
    header('location:../');
}
}

?>
