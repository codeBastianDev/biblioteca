<?php
include('../class/helper.php');
$db = new db('estudiante e');
$tb = '';
session_start();
$permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 4");
$hidden =  (!empty($permiso) )?'initial':'none';
if ($_POST) {
 
  foreach ($db->joinQuery(array('inscripcion i','grado g','perfil_factura p'),
  array(0,0,0),
  array('e.id = i.id_estudiante','g.id = i.id_grado','p.idInscripcion = i.id'),
  getFiltro($_POST),
  array('e.nombre, e.apellido, i.id, g.nombre as grado,e.nombre_tutor,e.apellido_tutor, i.estado','e.foto','e.id as id_est','p.balance')) as $fl) {
  
    $img = (!empty($fl['foto'])) ? $fl['foto'] : "sinFoto.jpg";
    $estado = ($fl['estado'] == 1) ? 'Activo' : 'Inactivo';
    $estadoColor = ($fl['estado'] == 1) ? 'success' : 'danger';
    $balance = number_format($fl['balance']);
    $tb .= "<tr class=estudiante>
    <td>
<div class='d-flex px-2 py-1'>
<div>
<img src='../assets/foto_estudiante/{$img}' class='avatar avatar-sm me-3' alt='user1'>
</div>
<div class='d-flex flex-column justify-content-center'>
<h6 class='mb-0 text-sm est'>{$fl['nombre']} {$fl['apellido']}</h6>
<p class='text-xs text-secondary mb-0'>ID: {$fl['id']}</p>
</div>
</div>
</td>
<td>
<span class='text-secondary text-xs font-weight-bold'>{$fl['grado']}</span>
</td>
<td class='align-middle text-center'>
<p class='text-xs font-weight-bold mb-0'>Padre o Tutor</p>
<p class='text-xs text-secondary mb-0'>{$fl['nombre_tutor']} {$fl['apellido_tutor']}</p>
</td>
<td class='align-middle text-center'>
<span class='text-secondary text-xs font-weight-bold'>$ {$balance}</span>
</td>
<td class='align-middle text-center text-sm'>
<span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
</td>
<td class='align-middle'>
<a style='display:{$hidden}' href='facturacionPerfil.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
<i class='ni ni-money-coins'></i>
</a>
</td>
    </tr>";
  };
} else {

  foreach ($db->joinQuery(array('inscripcion i','grado g','anio a','perfil_factura p'),
                          array(0,0,0,0),
                          array('e.id = i.id_estudiante','g.id = i.id_grado','i.id_anio = a.id and a.apertura = 1','p.idInscripcion = i.id'),
                          '',
                          array('e.nombre, e.apellido, i.id, g.nombre as grado,e.nombre_tutor,e.apellido_tutor, i.estado','e.foto','e.id as id_est','p.balance')) as $fl) {

    $img = (!empty($fl['foto'])) ? $fl['foto'] : "sinFoto.jpg";
    $estado = ($fl['estado'] == 1) ? 'Activo' : 'Inactivo';
    $estadoColor = ($fl['estado'] == 1) ? 'success' : 'danger';
    $balance = number_format($fl['balance']);
    $tb .= "<tr class=estudiante>
             <td>
  <div class='d-flex px-2 py-1'>
    <div>
      <img src='../assets/foto_estudiante/{$img}' class='avatar avatar-sm me-3' alt='user1'>
    </div>
    <div class='d-flex flex-column justify-content-center'>
      <h6 class='mb-0 text-sm est'>{$fl['nombre']} {$fl['apellido']}</h6>
      <p class='text-xs text-secondary mb-0'>ID: {$fl['id']}</p>
    </div>
  </div>
</td>
<td>
<span class='text-secondary text-xs font-weight-bold'>{$fl['grado']}</span>
</td>
<td class='align-middle text-center'>
<p class='text-xs font-weight-bold mb-0'>Padre o Tutor</p>
<p class='text-xs text-secondary mb-0'>{$fl['nombre_tutor']} {$fl['apellido_tutor']}</p>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>$ {$balance}</span>
</td>
<td class='align-middle text-center text-sm'>
  <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
</td>
<td class='align-middle'>
  <a style='display:{$hidden}' href='facturacionPerfil.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
  <i class='ni ni-money-coins'></i>
  </a>
</td>
             </tr>";
  };
}
echo $tb;
