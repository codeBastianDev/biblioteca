<?php 
include("../class/helper.php");
$producto = new db("producto");
$p='';
foreach ($producto->cargar(0,array("estado = 1", "categoria in(1,2,5)")) as $fl) {
    $foto = (empty($fl['foto']))?'sinFoto.jpg':$fl['foto'];
  $p.= " 
  <tr class=producto>
    <td >
      <div class='d-flex px-2 py-1'>
        <div>
          <img src='../assets/fotoProducto/{$foto}' class='avatar avatar-sm me-3'>
        </div>
        <div class='d-flex flex-column justify-content-center'>
          <h6 class='mb-0 text-xs prod'  >{$fl['nombre']}</h6>
        </div>
      </div>
    </td>
    <td>
      <p class='text-xs text-secondary mb-0'>{$fl['precio']}</p>
    </td>
   
    <td class='align-middle'>
        <div class='form-check'>
            <input class='form-check-input' type='checkbox' id='check'>
        </div>
    </td>
    <td style='display:none'>
        <div id='prod-cont' class='col-md-6 mb-md-0 mb-4'>
            <div class='card card-body border card-plain border-radius-lg d-flex align-items-center flex-row' id='producto' data-producto='{$fl['id']}' >
                <img class='w-10 me-3 mb-0' src='../assets/fotoProducto/{$foto}' alt='logo'>
                <h6 class='mb-0'>{$fl['nombre']}</h6>
                <input class='form-control mx-2' style='width: 70px;' value='1' type='number' min=1>
                <div class='ms-auto text-dark'>$ <span id=precio >{$fl['precio']}</span></div>
               <i ml-2 style='cursor: pointer;' class='mx-2 far fa-trash-alt text-danger me-2' onclick='eliminar_lista_producto(event)'></i> 
            </div>
        </div>
    <td>
  </tr>";
}
echo json_encode($p) ;
?>