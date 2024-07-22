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
    "(SELECT SUM(precio) FROM facturas_pagas_detalle WHERE id_factura_paga = f.id)  total_pagar",
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
    "(fpd.cantidad * p.precio)  total_producto",
    "e.nombre",
    "e.apellido",
    "e.matricula",
    'g.nombre grado',
    'pf.balance',
    'f.fecha_creacion fecha_factura',
    "concat(SUBSTRING_INDEX(e.nombre_tutor,' ',1),' ', SUBSTRING_INDEX(e.apellido_tutor,' ',1)) tutor",
    'e.cedula_tutor cedula'
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
    <title>Factura</title>
    <link rel="shortcut icon" href="../assets/img/logo.jpg" type="image/x-icon">
</head>

<body>
    <main>
        <header>
            <div><img src="../assets/img/logo_trasparente.png" width="120"></div>
            <div style="font-size: 20px;"><strong>COLEGIO ABRAHAM</strong></div>
            <div> "Educando para toda la vida"</div>
            <div><strong>TEL: 809-203-3904</strong></div>
            <div>Urbanización Mi Ensueño, <br> Carretera de Mendoza # 05</div>
            <div>E.mail: abrahamcolegio@gmail.com</div>
        </header>
        <article class="dato-recibo">
            <section>
                <strong>Recibo No:</strong> <?=$v['id']?> <br>
                <strong>Fecha:</strong> <?php echo date('d/m/Y',strtotime($v['fecha_factura'])) ?>
            </section>
        </article>
        <div class="titulo-tutor">
            <strong>DATOS DEL TUTOR</strong>
        </div>
        <article class="data-info">
            <table>
                <tbody>
                    <tr>
                        <th>Nombre:</th>
                        <td><?= $v['tutor']?></td>
                    </tr>
                    <tr>
                        <th>Documento:</th>
                        <td><?= $v['cedula']?></td>
                    </tr>
                    <tr>
                        <th>Estudiante:</th>
                        <td><?= $v['nombre'].' '. $v['apellido'] ?></td>
                    </tr>
                    <tr>
                        <th>Grado:</th>
                        <td><?= $v['grado'] ?></td>
                    </tr>
                    <tr>
                        <th>Año Escolar:</th>
                        <td><?= $anio[0]['nombre'] ?></td>
                    </tr>
                </tbody>
            </table>
            <!-- <p><strong>Nombre:</strong> Milagros Terrero <br></p>
          <p><strong>Documento:</strong> 402-341230 <br></p>
          <p><strong>Estudiante:</strong> Reynaldo Lopez <br></p>
          <p><strong>Año Escolar:</strong> 2023-2024</p> -->
        </article>
        <div class="titulo-tutor">
            <strong>DETALLES DE LA FACTURA</strong>
        </div>
        <article>
        <?php if($cuotas):?>
            <h3>Colegiatura</h3>
            <table class="data-productos">
                <thead>
                    <th>Fecha</th>
                    <th>Cuota # </th>
                    <th>Mensualida</th>
                </thead>
                <tbody>
                   <?=$cuotas?>
                </tbody>
            </table>
            <?php endif?>
            <?= ($cuotas && $productos)?"<hr>":''?>
            <?php if($productos):?>
            <h3>Artículo</h3>

            <table class="data-productos">
                <thead>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <?=$productos?>
                </tbody>
            </table>
            <?php endif?>
        </article>
        <br>
        <div style="border: dotted ; margin-bottom: 5px;"></div>
        <article>
            <div style="display: flex; justify-content: space-between; font-size: 28px; font-weight: 800;">
                <div>Total:</div>
                <div><?=$v['total_pagar']?></div>
            </div>
        </article>
        <div class="titulo-tutor">
            <strong>DETALLES DE LA PAGO</strong>
        </div>
        <article style="display: flex; justify-content: space-between; padding: 10px; font-size: 15px;">
            <div>
                <Strong>METODO DE PAGO:</Strong> <br>
                <strong>BALANCE</strong>
            </div>
            <div>
               
                <?=$v['metodo_de_pago']?> <br>
                <?=$v['balance']?>  <br>

            </div>
        </article>
        <div style="border: dotted ; margin-bottom: 5px;"></div>
        <article>
            <hr style="height: 100px;">
            <hr>
            <div style="text-align: center; font-weight: 800; font-size: 18px;">Firma</div>
        </article>
        <article style="margin-top: 10px; text-align: center;">
            <div>La validación de este recibo esta sujeta a su firma y sello por el departamento de caja.</div>
            <br>
            <div><strong>Atendido por:</strong> <?=$v['cajero']?> <br>
                <strong>Impreso:</strong> <?= date('d/m/Y g:i:s A' )?></div>
        </article>
    </main>
    <style>
        * {
            font-family: monospace;
        }

        main {
            width: 350px;
           
        }

        header {
            text-align: center;
        }

        .dato-recibo {
            margin-top: 10px;
            text-align: left;
        }

        .titulo-tutor {
            text-align: center;
            border-top: 1px solid;
            border-bottom: 1px solid;
            margin-top: 10px;
            padding: 15px;
            font-size: 20px;
            font-weight: 800;
        }

        .data-info {
            margin-top: 10px;
            padding: 5px;
        }

        .data-info table {
            width: 100%;
            text-align: -webkit-match-parent;
            font-size: 15px;
        }

        .data-productos {
            margin-top: 5px;
            width: 100%;
            text-align: left;
        }
    </style>
    <script>
        print();
    </script>
</body>

</html>