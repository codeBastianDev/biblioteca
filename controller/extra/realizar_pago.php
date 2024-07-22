<?php
include ('../class/helper.php');
// Metodo de pago
// 1 Efectivo 2 Tarjeta 3 Transferencia
if(file_get_contents("php://input"));
{
    $data = (json_decode(file_get_contents("php://input")) );
    // _log($data);
    // exit();
    if(isset($data->pago)){
        $data = [
        'cuotas'=>$data->cuotas,
         "id_factura"=> $data->id_factura,
         "metodo_pago"=>  $data->metodo,
         "id_usuario"=> $data->id_usuario,
         "id_productos" => $data->productos,
         "matriculacion" => $data->producto_matricula,
         "id_matriculacion" => $data->id_matriculacion];
    
        $pagar = new facturacion('factura_paga',$data);
        $pagar->realizar_pago();
    }else{
        $eliminar_pago = new facturacion('factura_paga',$data);
        $eliminar_pago->elimar_pago();
    }

    
}


?>

