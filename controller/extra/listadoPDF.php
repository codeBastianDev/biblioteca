<?php
include "../class/helper.php";
if (isset($_GET)) {

    $grado = isset($_GET['grado']) ? $_GET['grado'] : 0;
    $anio = isset($_GET['anio']) ? $_GET['anio'] : 0;
    $fila = '';
    $est = (new db('estudiante e'))->joinQuery(
        array('inscripcion i','grado g'),
        array(0,0),
        array('e.id = i.id_estudiante',"g.id = i.id_grado"),
        array("i.id_grado = {$grado}", "i.id_anio = {$anio}"),
        array("CONCAT(e.nombre,' ',e.apellido) as estudiante", 'e.sexo,e.matricula','g.nombre grado'),
        "ORDER BY e.apellido"
    );

    foreach ($est as $value) {
        $sexo = sexo($value['sexo']);
     
        $fila .= "
        <tr> 
        <td>{$value['estudiante']}</td>
        <td>{$value['matricula']}</td>
        <td>{$sexo}</td>
        </tr>";
    }
} else {
    exit();
}



?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../assets/img/logo_trasparente.png" type="image/x-icon">
    <title>Listado de Estudiantes de <?= isset($value['grado'])? $value['grado']:'--'?> </title>
    <style>
        body {
            font-family: Arial, sans-serif;
    
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <h1>Listado de Estudiantes de <?= isset($value['grado'])? $value['grado']:'--' ?></h1>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Matricula</th>
                <th>Sexo</th>
            </tr>
        </thead>
        <tbody>
           <?= $fila?>
           
        </tbody>
    </table>
</body>

</html>

<script>
    print();
</script>