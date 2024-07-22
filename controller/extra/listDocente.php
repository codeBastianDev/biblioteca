<?php
include('../class/helper.php');
session_start();
$permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 5");
$hidden =  (!empty($permiso) )?'initial':'none';
$grados = [];
$grado = new db('grado');
foreach ($grado->cargar() as $key => $value) {
 $grados [$key + 1]= $value['nombre'];
};
$db = new db('docente d');
$tb='';

    if($_POST){
        foreach ($db->joinQuery(array('grado g'),
        array(2),
        array('d.id_grado = g.id'),
        getFiltro($_POST),
        array("d.nombre, 
              d.apellido ,  
              g.nombre as grado, 
              d.estado, 
              d.salario, 
              d.foto,
              d.id,
              d.cedula, 
              d.id_grado")) as $fl) {

                $grados_mostrar = [];
                foreach (explode(',',$fl['id_grado']) as $key ) {
                  // _log($key);                     
                  if(isset($grados[$key])){
                    $grados_mostrar[] = $grados[$key]  ;
                  }  
                }
                $Grado = implode(', ', $grados_mostrar);

$img = (!empty($fl['foto']))?$fl['foto']:"sinFoto.jpg";
$estado = ($fl['estado'] == 1)?'Activo':'Inactivo';
$estadoColor = ($fl['estado'] == 1)?'success':'danger';
$salario = number_format($fl['salario'],2,'.',',');

$tb.= "<tr class=estudiante>
<td>
  <div class='d-flex px-2 py-1'>
    <div>
      <img src='../assets/fotoDocente/{$img}' class='avatar avatar-sm me-3' alt='user1'>
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
  <span class='text-secondary text-xs font-weight-bold'>{$Grado}</span>
</td>
<td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>$ {$salario}</span>
</td>
<td class='align-middle text-center text-sm'>
  <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
</td>
<td class='align-middle'>
  <a style='display:{$hidden}' href='editdocente.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
  <i class='fa-solid fa-pen'></i>
  </a>
</td>
</tr>";
};
    }else{
   

  


    foreach ($db->joinQuery(array('grado g'),
    array(2),
    array('d.id_grado = g.id'),
    '',
    array("d.nombre, 
          d.apellido ,  
          g.nombre as grado, 
          d.estado, 
          d.salario, 
          d.foto,
          d.id,
          d.cedula,
          d.id_grado")) as $fl) {
            $grados_mostrar = [];
            foreach (explode(',',$fl['id_grado']) as $key ) {
              // _log($key);                     
              if(isset($grados[$key])){
                $grados_mostrar[] = $grados[$key]  ;
              }  
            }
            $Grado = implode(', ', $grados_mostrar);
            $img = (!empty($fl['foto']))?$fl['foto']:"sinFoto.jpg";
              $estado = ($fl['estado'] == 1)?'Activo':'Inactivo';
              $estadoColor = ($fl['estado'] == 1)?'success':'danger';
              $salario = number_format($fl['salario'],2,'.',',');
              
              $tb.= "<tr class=estudiante>
              <td>
                <div class='d-flex px-2 py-1'>
                  <div>
                    <img src='../assets/fotoDocente/{$img}' class='avatar avatar-sm me-3' alt='user1'>
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
                <span class='text-secondary text-xs font-weight-bold'>{$Grado}</span>
              </td>
              <td class='align-middle text-center'>
                <span class='text-secondary text-xs font-weight-bold'>$ {$salario}</span>
              </td>
              <td class='align-middle text-center text-sm'>
                <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
              </td>
              <td class='align-middle'>
                <a style='display:{$hidden}' href='editdocente.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                <i class='fa-solid fa-pen'></i>
                </a>
              </td>
             </tr>";
            };
      }
    echo $tb;
?>