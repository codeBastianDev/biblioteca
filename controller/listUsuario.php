<?php
include('../class/helper.php');
$db = new db('usuario');
$tb = '';
session_start();
$permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 6");;
$hidden =  (!empty($permiso) )?'initial':'none';
if ($_POST) {
  foreach ($db->cargar(0,getFiltro($_POST)) as $fl) {


    $img = (!empty($fl['foto'])) ? $fl['foto'] : "sinFoto.jpg";
    $estado = ($fl['estado'] == 1) ? 'Activo' : 'Inactivo';
    $estadoColor = ($fl['estado'] == 1) ? 'success' : 'danger';

    $tb .= "<tr class=estudiante>
<td>
  <div class='d-flex px-2 py-1'>
    <div>
      <img src='../assets/fotoUsuarios/{$img}' class='avatar avatar-sm me-3' alt='user1'>
    </div>
    <div class='d-flex flex-column justify-content-center'>
      <h6 class='mb-0 text-sm est'>{$fl['nombre']} {$fl['apellido']}</h6>
      <p class='text-xs text-secondary mb-0'>ID: {$fl['id']}</p>
    </div>
  </div>
</td>
<td>
<span class='text-secondary text-xs font-weight-bold'>{$fl['cedula']}</span>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['cargo']}</span>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['telefono']}</span>
</td>
<td class='align-middle text-center text-sm'>
  <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
</td>
<td class='align-middle'>
  <a style='display:{$hidden}' href='editUsuario.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
  <i class='fa-solid fa-pen'></i>
  </a>
</td>
</tr>";
  };
} else {

  foreach ($db->cargar() as $fl) {

    $img = (!empty($fl['foto'])) ? $fl['foto'] : "sinFoto.jpg";
    $estado = ($fl['estado'] == 1) ? 'Activo' : 'Inactivo';
    $estadoColor = ($fl['estado'] == 1) ? 'success' : 'danger';
    $tb .= "<tr class=estudiante>
             <td>
  <div class='d-flex px-2 py-1'>
    <div>
      <img src='../assets/fotoUsuarios/{$img}' class='avatar avatar-sm me-3' alt='user1'>
    </div>
    <div class='d-flex flex-column justify-content-center'>
      <h6 class='mb-0 text-sm est'>{$fl['nombre']} {$fl['apellido']}</h6>
      <p class='text-xs text-secondary mb-0'>ID: {$fl['id']}</p>
    </div>
  </div>
</td>
<td>
<span class='text-secondary text-xs font-weight-bold'>{$fl['cedula']}</span>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['cargo']}</span>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['telefono']}</span>
</td>
<td class='align-middle text-center text-sm'>
  <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
</td>
<td class='align-middle'>
  <a  style='display:{$hidden}' href='editUsuario.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
  <i class='fa-solid fa-pen'></i>
  </a>
</td>
             </tr>";
  };
}
echo $tb;
