<?php include('../class/helper.php');

if (file_get_contents("php://input")); {
    $data = (json_decode(file_get_contents("php://input")));
    
    $listado = '';
    $facturas = new db('factura_paga f');
    foreach ($facturas->joinQuery(
        array('facturas_pagas_detalle fpd', 'usuario u'),
        array(0, 0),
        array('f.id = fpd.id_factura_paga', 'f.id_usuario = u.id'),
        array("DATE(f.fecha_creacion) BETWEEN '{$data->desde}' AND '{$data->hasta}'","f.id_cuadre = 0"),
        array(
            'f.id', "(SELECT
    SUM(precio)
                FROM
                    factura_paga 
                INNER JOIN facturas_pagas_detalle fpd ON
                    (factura_paga.id = fpd.id_factura_paga)
                WHERE
                    factura_paga.id = f.id
                GROUP BY
    f.id  ) AS total",
            "f.fecha_creacion,
    concat(SUBSTRING_INDEX(u.nombre,' ',1),' ',SUBSTRING_INDEX(u.apellido,' ',1)) as cajero",
    "CASE 
          WHEN f.tipo_pago = 1 THEN 'Efectivo'
          WHEN f.tipo_pago = 2 THEN 'Tarjeta'
          WHEN f.tipo_pago = 3 THEN 'Tranferencia'
    END metodo_de_pago      
    "
        ),
        "GROUP BY f.id"


    ) as  $value) {
        $fecha =  date('d-m-Y', strtotime($value['fecha_creacion']));
        $listado .= "  
    <tr>
        <td>
        <div class='d-flex px-2 py-1'>

            <div class='d-flex flex-column justify-content-center'>
            <p class='text-xs text-secondary mb-0'>{$value['id']}</p>
            </div>
        </div>
        </td>
        <td>
        <p class='text-xs font-weight-bold mb-0'>$ <span id='dinero'>{$value['total']}</span></p>
        </td>
        <td class='align-middle text-center text-sm'>
        <p class='text-xs text-secondary mb-0'>{$fecha}</p>
        </td>
        <td class='align-middle text-center'>
        <span class='text-secondary text-xs font-weight-bold'>{$value['cajero']}</span>
        </td>
        <td class='align-middle text-center'>
        <span class='text-secondary text-xs font-weight-bold'>{$value['metodo_de_pago']}</span>
        </td>
        
  </tr>";
    }
    echo json_encode($listado);
}
// <td class='align-middle'>
//         <a href='javascript:;' class='text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
//             Edit
//         </a>
//         </td>

