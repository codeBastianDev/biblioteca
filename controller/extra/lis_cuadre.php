<?php
include"../class/helper.php";
session_start();
$cuadres = new db('cuadre c');
$permiso = $permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 7");;
$hidden =  (!empty($permiso) )?'initial':'none';


$where = (!empty($_POST))? " c.fecha_creacion = '{$_POST['fecha_creacion']}' ":'c.fecha_creacion';
$row ='';
$tb = $cuadres->joinQuery(
    array('usuario u'),
    array(0),
    array("c.id_usuario = u.id"),
    array($where),
    array("concat(SUBSTRING_INDEX(u.nombre,' ',1),' ',SUBSTRING_INDEX(u.apellido,' ',1)) as cajero",
    "c.id",
    "c.fecha_creacion",
    "c.monto",
    "c.cantidad_factura numF",
    "u.foto","c.gasto"));
    foreach ($tb as $r) {
        // _log($r);
        $fotos = (!empty($r['foto'])?$r['foto']:"sinFoto.jpg" );
        $fecha = date('d-m-Y',strtotime($r['fecha_creacion']));
        $diferencia = number_format(($r['monto'] - $r['gasto']));
        $color_dif = ($diferencia > 0)?'success':'danger';
        $row .="<tr class=estudiante>
        <td>
          <div class='d-flex px-2 py-1'>
            <div>
              <img src='../assets/fotoUsuarios/{$fotos}' class='avatar avatar-sm me-3' alt='user1'>
            </div>
            <div class='d-flex flex-column justify-content-center'>
              <h6 class='mb-0 text-sm est'>{$r['cajero']}</h6>
              <p class='text-xs text-secondary mb-0'>ID CUADRE: {$r['id']}</p>
            </div>
          </div>
        </td>
        <td>
        <span class='text-secondary text-xs font-weight-bold'>{$r['monto']}</span>
        </td>
        <td class='align-middle text-center'>
          <span class='text-secondary text-xs font-weight-bold'>{$r['numF']}</span>
        </td>
        <td class='align-middle text-center'>
          <span class='text-secondary text-xs font-weight-bold'>{$fecha}</span>
        </td>
        <td class='align-middle text-center'>
          <span class='text-{$color_dif} text-xs font-weight-bold'>{$diferencia}</span>
        </td>
        <td class='align-middle text-center' style='display:{$hidden}' >
        <button class='btn btn-danger' onclick='eliminarCuadre({$r['id']})'> <i class='ni ni-fat-remove'></i> </button>
        </td>
        <td class='align-middle text-center' style='display:{$hidden}' >
        <a href='../controller/cuadre_factura.php?id={$r['id']}' target='_blank' class='btn btn-primary'>Visualizar</a>
        </td>
    </tr>";
    }

    echo $row;
?>
