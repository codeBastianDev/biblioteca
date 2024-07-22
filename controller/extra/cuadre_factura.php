<?PHP
include('../class/helper.php');
session_start();

if ($_GET) {
    foreach ((new db('cuadre c'))->joinQuery(array('usuario u'), array(0), array('u.id = c.id_usuario'), array("c.id ={$_GET['id']}"), array('c.id', 'c.fecha_creacion', 'c.cantidad_factura', 'c.monto', "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ',SUBSTRING_INDEX(u.apellido,' ',1)) as user",'c.gasto'))  as $fl) {
        $data = $fl;
        $gasto = $fl['gasto'];
        $Total = $fl['monto'] - $fl['gasto']; 
        $cuadre = "
        <tr>
            <td>{$fl['id']}</td>
            <td>{$fl['fecha_creacion']}</td>
            <td>{$fl['monto']}</td>
            <td>{$fl['cantidad_factura']}</td>
        </tr>";
    }

    $facturas = '';

    foreach ((new db('factura_paga f'))->joinQuery(
        array('facturas_pagas_detalle fpd', 'usuario u'),
        array(0, 0),
        array('f.id = fpd.id_factura_paga', 'f.id_usuario = u.id'),
        array("f.id_cuadre ={$_GET['id']}"),
        array(
            "(SELECT
            SUM(precio)
                        FROM
                            factura_paga 
                        INNER JOIN facturas_pagas_detalle fpd ON
                            (factura_paga.id = fpd.id_factura_paga)
                        WHERE
                            factura_paga.id = f.id
                        GROUP BY
            f.id  ) AS total",
            "f.fecha_creacion,f.id",
            "concat(SUBSTRING_INDEX(u.nombre,' ',1),' ',SUBSTRING_INDEX(u.apellido,' ',1)) as cajero"
        ),
        "GROUP BY f.id"
    ) as $fl) {
        $fecha = date('d-m-Y', strtotime($fl['fecha_creacion']));
        $facturas .= "
            <tr>
                <td>{$fl['id']}</td>
                <td>{$fecha}</td>
                <td>{$fl['total']}</td>
                <td>{$fl['cajero']}</td>
            </tr>";
    }
}

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
                <strong>Cuadre No:</strong> <?= $data['id'] ?> <br>
                <strong>Fecha:</strong> <?= date('d-m-Y', strtotime($data['fecha_creacion'])) ?> <br>
                <strong>Usuario:</strong> <?= $data['user'] ?>
            </section>
        </article>

        <div class="titulo-tutor">
            <strong>CUADRE DE CAJA</strong>
        </div>
        <article>
            <table class="data-productos">
                <thead>
                    <th>NO.</th>
                    <th>FECHA</th>
                    <th>MONTO</th>
                    <th>CANTIDAD FACTURA</th>
                </thead>
                <tbody>
                    <?= $cuadre ?>
                </tbody>
            </table>

        </article>
        <div class="titulo-tutor">
            <strong>DETALLE DE CUADRE</strong>
        </div>
        <article>
            <table class="data-productos">
                <thead>
                    <th>NO.</th>
                    <th>FECHA</th>
                    <th>MONTO</th>
                    <th>Cajero</th>
                </thead>
                <tbody>
                    <?= $facturas ?>
                </tbody>
            </table>
        </article>
        <br>
        <div style="border: dotted ; margin-bottom: 5px;"></div>
        <article>
            <div style="display: flex; justify-content: space-between; font-size: 28px; font-weight: 800;">
                <div>
                    <div>Gasto:</div>
                    <div>Total:</div>
                </div>
                <div>
                    <div><?= number_format($gasto, 2) ?></div>
                    <div><?= number_format($Total, 2) ?></div>
                </div>
            </div>
        </article>


        <div style="border: dotted ; margin-bottom: 5px;"></div>
        <article>
            <hr style="height: 100px;">
            <hr>
            <div style="text-align: center; font-weight: 800; font-size: 18px;">Firma</div>
        </article>
        <article style="margin-top: 10px; text-align: center;">
            <br>
            <div><strong>Impreso por:</strong> <?= $_SESSION['usuario'] ?> <br>
                <?= date('d/m/Y g:i:s A') ?>
            </div>
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