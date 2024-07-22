<?php include "../class/helper.php";
if($_POST)
{
    $pagos = new db('factura_paga');
    foreach ($pagos->cargar(0,array("id_cuadre = {$_POST['cuadre']}")) as $v) {
        (new db('factura_paga'))->insert(array(
            "id_cuadre" => 0
        ),$v['id']);
    };
    

    foreach ((new db('gasto'))->cargar(0,array("id_cuadre = {$_POST['cuadre']}")) as $value) {
        ((new db('gasto'))->insert(array(
            'id_cuadre' => 0
        ),$value['id'],true));
    }
    (new db ('cuadre'))->eliminar($_POST['cuadre']);
}
?>