<?php 
include('../class/helper.php');
$factura = new db('factura_paga p');
foreach($factura->joinQuery(
    array('cuota_detalle c'),
    array(0),
    array('p.id_cuota = c.id'),
    array("p.id_cuota ={$_GET['id']}"),
    array('p.Estudiante, p.tutor, p.id_cuota, c.monto,c.cuota, p.id')) as  $value) {
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de <?= $value['Estudiante']?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <img src="../assets/img/logo.jpg" width="250" alt="">
            <h1>Factura de <?= $value['Estudiante']?></h1>
        </div>
        <div class="invoice-details">
            <p>Fecha de emisión: <?= date('d-m-Y')?></p>
            <p>Cliente: <?= $value['tutor']?></p>
            <p>Número de factura: <?= $value['id']?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cuota</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cuota # <?= $value['cuota']?></td>
                    <td><?= $value['cuota']?></td>
                    <td><?= $value['monto']?></td>
                </tr>
            </tbody>
        </table>
        <div class="total">
            <p>Total: <?= $value['monto']?></p>
        </div>
    </div>
</body>
</html>
