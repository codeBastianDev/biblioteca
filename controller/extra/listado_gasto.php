<?php 
include ('../class/helper.php');
session_start();
$gastos = new db('gasto g');
$gastosM = (new db(null))->dataTable("SELECT * FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 2");
$permiso = !empty($gastosM)?'':"style='display:none;";

$fl ='';
$where = (!empty($_POST))? " g.fecha_creacion = '{$_POST['fecha_creacion']}' ":'g.fecha_creacion';
foreach ($gastos->joinQuery( 
    array('usuario u'),
    array(0),
    array('g.id_usuario = u.id'),
    array($where),
    array('g.id',
    'g.fecha_creacion',
    'g.monto',
    "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ', SUBSTRING_INDEX(u.apellido,' ',1)) cajero",
    "u.foto",
    "g.detalle"
    )) as $value) {
        $foto = (!empty($value['foto']))?$value['foto']:'sinFoto.jpg';
        $fl.="<tr class=estudiante>
        <td>
          <div class='d-flex px-2 py-1'>
            <div>
              <img src='../assets/fotoUsuarios/{$foto}' class='avatar avatar-sm me-3' alt='user1'>
            </div>
            <div class='d-flex flex-column justify-content-center'>
              <h6 class='mb-0 text-sm est'>{$value['cajero']}</h6>
              <p class='text-xs text-secondary mb-0'>ID GASTO: {$value['id']}</p>
            </div>
          </div>
        </td>
        <td>
        <span class='text-secondary text-xs font-weight-bold'>$ {$value['monto']}</span>
        </td>
        <td class='align-middle text-center'>
          <span class='text-secondary text-xs font-weight-bold'>{$value['detalle']}</span>
        </td>
        <td class='align-middle text-center'>
          <span class='text-secondary text-xs font-weight-bold'>{$value['fecha_creacion']}</span>
        </td>
        <td class='align-middle' {$permiso} >
          <a href='editGasto.php?id={$value['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
            <i class='fa-solid fa-pen'></i>
          </a>
        </td>
        </tr>";
    
}
echo $fl;
