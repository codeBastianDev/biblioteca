<?php include('../class/helper.php');
$factura = new db('factura_paga f');


$anio = (new db('anio'))->cargar(0, array('apertura = 1'));



$registro_pagos = $factura->joinQuery(
  array(
    'facturas_pagas_detalle fpd',
    'producto p',
    'factura_detalle c',
    'usuario u',
    'perfil_factura pf',
    'inscripcion i',
    'estudiante e',
    'grado g'
  ),
  array(0, 2, 0, 0, 0, 0, 0, 0),
  array(
    'f.id = fpd.id_factura_paga',
    'fpd.id_producto = p.id',
    'c.id = fpd.id_producto_venta',
    'u.id = f.id_usuario',
    'f.id_factura = pf.id',
    'pf.idInscripcion = i.id',
    'e.id = i.id_estudiante',
    'g.id = i.id_grado'
  ),
  array("f.id = {$_GET['id']}"),
  array(
    'f.id',
    'fpd.producto',
    'p.categoria',
    'p.precio precio_producto',
    "(SELECT SUM(precio) FROM facturas_pagas_detalle WHERE id_factura_paga = f.id) total_pagar",
    'fpd.cantidad',
    'c.fecha_pago',
    'fpd.id id_pago_detalle',
    "
  CASE 
          WHEN f.tipo_pago = 1 THEN 'Efectivo'
          WHEN f.tipo_pago = 2 THEN 'Tarjeta'
          WHEN f.tipo_pago = 3 THEN 'Tranferencia'
    END metodo_de_pago
  ",
    "c.cuota",
    "c.id id_cuota",
    "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ', SUBSTRING_INDEX(u.apellido,' ',1)) cajero",
    "(fpd.cantidad * fpd.precio)  total_producto",
    "e.nombre",
    "e.apellido",
    "e.matricula",
    'g.nombre grado'
  ),
  'group by fpd.id'
);
$cuotas = '';
$productos = '';
foreach ($registro_pagos as $v) {
  if ($v['categoria'] == 4) {
    $fecha = date('d-m-Y', strtotime($v['fecha_pago']));
    $cuotas .= " <tr>
    <td> {$fecha} </td>
    <td> {$v['cuota']} </td>
    <td> {$v['precio_producto']} </td>
    <td>Pago de mensualidad</td>
  </tr>";
  } else {
    $fecha = date('d-m-Y', strtotime($v['fecha_pago']));
    $productos .= "
    <tr>
            <td> {$v['producto']}</td>
            <td> {$v['cantidad']}</td>
            <td> {$v['precio_producto']}</td>
            <td>{$v['total_producto']}</td>
          </tr>";
  }
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="factura" style="padding: 10px;">
    <div class="cabezera">
      <div><img src="../assets/img/logo_trasparente.png" alt="" width="100"></div>
      <div> <strong>COLEGIO ABRAHAM FUNDADO EN 1984</strong> </div>
      <div class="sub-texto">CARRETERA MENDOZA NO 152 VILLA FARO</div>
      <div class="sub-texto">SANTO DOMINGO R.D TELF (809)-595-7982</div>
      <div class="sub-texto">4-23-0021-8</div>
      <div><strong>Recibo de pago</strong></div>
    </div>

    <div style="display: flex; justify-content: space-between;">
      <div>
        <div class="border" style="width: 100%;">Datos del alumno</div>
        <table>
          <thead>
            <tr>
              <th>Matricula:</th>
              <td><?= $v['matricula'] ?></td>
            </tr>
            <tr>
              <th style="text-align: start;">Nombre:</th>
              <td><?= $v['nombre'] ?></td>
            </tr>
            <tr>
              <th style="text-align: start;">Apellido:</th>
              <td><?= $v['apellido'] ?></td>
            </tr>
          </thead>
        </table>
      </div>
      <div>
        <p style="font-size: 20px;">Mensualidades Colegiatura Año Escolar <?= $anio[0]['nombre'] ?></p>
      </div>
      <div>
        <p style="text-align: right;"> <strong>Recibo No.</strong> <?= $v['id'] ?> <br> <strong>Cajero:</strong> <?= $v['cajero'] ?> <br> <strong>Metodo de pago:</strong> <?= $v['metodo_de_pago'] ?> <br> <?= date('d-m-Y') ?> </p>

      </div>
    </div>

  </div>

  <br>

  <?php if ($cuotas) : ?>
    <h3>Mensualidad</h3>
    <table class="tabla-factura">
      <thead style="font-size: 18px;">
        <th>Fecha</th>
        <th># Cuota</th>
        <th>Cuota Mensual</th>
        <th>Concepto</th>
      </thead>
      <tbody>
        <?= $cuotas ?>
      </tbody>
    </table>
  <?php endif ?>

  <?php if ($productos) : ?>
    <h3>Productos</h3>
    <table class="tabla-factura">
      <thead style="font-size: 18px;">
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Monto</th>
        <th>Total</th>
      </thead>
      <tbody>
        <?= $productos ?>
      </tbody>
    </table>
  <?php endif ?>

  <br>

  <div style="display: flex;">
    <table class="resumen-factura">
      <thead>
        <tr>
          <th>Matricula</th>
          <th>Concepto</th>
          <th>Monto</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2023-02021</td>
          <td>Pago de mensualdiad</td>
          <td>Total cobro variado 5000.00</td>
        </tr>
      </tbody>
    </table>
  </div>

  <br>
  <br>
  <div style="
    margin: auto;
    width: 25%;
    text-align: center;
">
    <hr>
    <div><strong>Firma Cajero</strong></div>
    <div>Este recibo no es valido sin el sello y la firma autorizada de la institución</div>
  </div>
</body>

</html>

<style>
  .cabezera {
    padding: 10px;
    margin: auto;
    text-align: center;
  }

  .sub-texto {
    font-size: 12px;
  }

  .border {
    border: 1.5px solid black;
    padding: 2px;
  }

  .tabla-factura {

    width: 100%;
    text-align: left;
    border-spacing: 0;
  }

  .tabla-factura thead th {
    border-top: 1px solid;
    border-bottom: 1px solid;
    padding: 6px;

  }

  .resumen-factura thead th {
    border-bottom: 1px solid;

  }
  
  .tabla-factura tbody  td {
    padding: 7px;
  }

  .resumen-factura {
    border-spacing: 0;
    width: 42%;
    margin-top: 20px;
  }
  .resumen-factura tbody td{
    padding: 7px;
  }

</style>