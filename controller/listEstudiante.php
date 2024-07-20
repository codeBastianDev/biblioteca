<?php
include('../class/helper.php');
session_start();
$db = new db('estudiante e');
$permiso = (new db(null))->dataTable("SELECT id FROM permisos where FIND_IN_SET({$_SESSION['id']},modificar) and id = 1");
$hidden =  (!empty($permiso) )?'initial':'none';
$tb='';
  
    if($_POST){
  
        foreach ($db->joinQuery(
        array('inscripcion i','grado g','anio a'),
        array('2','2','2',0),
        array('e.id = i.id_estudiante','g.id = i.id_grado', 'a.id = i.id_anio'),
        getFiltro($_POST),
        array(  'e.nombre,
                e.apellido,
                e.apellido_tutor,
                e.estado',
                'e.id',
                'e.matricula',
                'e.nombre_tutor',
                'g.nombre as grado',
                'a.nombre as anio',
                'e.foto',
                'i.id as id_inscripcion')) as $fl) {
                           
$estado = ($fl['estado'] == 1)?'Activo':'Inactivo';
$estadoColor = ($fl['estado'] == 1)?'success':'danger';
$img = (!empty($fl['foto']))?$fl['foto']:"sinFoto.jpg";
$ins = (isset($fl['id_inscripcion']) ? $fl['id_inscripcion'] : 0);
$tb.= "<tr class=estudiante>

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
  <p class='text-xs font-weight-bold mb-0'>Padre o Tutor</p>
  <p class='text-xs text-secondary mb-0'>{$fl['nombre_tutor']} {$fl['apellido_tutor']}</p>
  </td>
  <td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['grado']}</span>
    </td>
    
  <td class='align-middle text-center'>
  <span class='text-secondary text-xs font-weight-bold'>{$fl['matricula']}</span>
  </td>
  <td class='align-middle text-center text-sm'>
  <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
  </td>
   <td class='align-middle'>
              <a style='display:{$hidden}' href='editEstudiante.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
              <i class='fa-solid fa-pen'></i>
              </a>
    </td>
  <td class='align-middle' style='display:{$hidden}'>
  <div class='dropdown'  >
      <button  class='btn bg-gradient-success dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
      <i class='ni ni-ui-04'></i>
      </button>
      <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
      <li><a class='dropdown-item' href='editInscripcion.php?id_estudiante={$fl['id']}&id_ins={$ins}'><i class='ni ni-fat-add'></i>Agregar nueva matriculacion</a></li>
      <li><a class='dropdown-item' href='editMatriculacion.php?id_ins={$ins}&id_estudiante={$fl['id']}'><i class='ni ni-fat-remove'></i>Ver matriculación</a></li
      </ul>
  </div>
</td>
</tr>";
};
    }else{
                               
    foreach ($db->joinQuery(array('inscripcion i','grado g','anio a'),
    array('2','2','2',0),
    array('e.id = i.id_estudiante','g.id = i.id_grado', 'a.id = i.id_anio'),
    array('e.estado = 1'),
    array(  'e.nombre,
            e.apellido,
            e.apellido_tutor,
            e.estado',
            'e.id',
            'e.matricula',
            'e.nombre_tutor',
            'g.nombre as grado',
            'a.nombre as anio',
            'e.foto',
            'i.id as id_inscripcion'),'GROUP BY e.id') as $fl) {
            $img = (!empty($fl['foto']))?$fl['foto']:"sinFoto.jpg";
            $estado = ($fl['estado'] == 1)?'Activo':'Inactivo';
            $estadoColor = ($fl['estado'] == 1)?'success':'danger';
            $ins = (isset($fl['id_inscripcion']) ? $fl['id_inscripcion'] : 0);

            
            $tb.= "<tr class=estudiante>
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
              <p class='text-xs font-weight-bold mb-0'>Padre o Tutor</p>
              <p class='text-xs text-secondary mb-0'>{$fl['nombre_tutor']} {$fl['apellido_tutor']}</p>
            </td>
            <td class='align-middle text-center'>
              <span class='text-secondary text-xs font-weight-bold'>{$fl['grado']}</span>
            </td>
            <td class='align-middle text-center'>
              <span class='text-secondary text-xs font-weight-bold'>{$fl['matricula']}</span>
            </td>
            <td class='align-middle text-center text-sm'>
              <span class='badge badge-sm bg-gradient-{$estadoColor}'>{$estado}</span>
            </td>
            <td class='align-middle'>
            <a style='display:{$hidden}' href='editEstudiante.php?id={$fl['id']}' class='btn  text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
            <i class='fa-solid fa-pen'></i>
            </a>
            </td>

            <td class='align-middle' style='display:{$hidden}'>
              <div class='dropdown'>
                  <button class='btn bg-gradient-success dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                  <i class='ni ni-ui-04'></i>
                  </button>
                  <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <li><a class='dropdown-item' href='editInscripcion.php?id_estudiante={$fl['id']}&id_ins={$ins}'><i class='ni ni-fat-add'></i>Agregar nueva matriculacion</a></li>
                    <li><a class='dropdown-item' href='editMatriculacion.php?id_ins={$ins}&id_estudiante={$fl['id']}'><i class='ni ni-fat-remove'></i>Ver matriculación</a></li>
                  </ul>
              </div>
          </td>
          </tr>";
          };
    }
    echo $tb;
