<?php
include ('../class/helper.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['usuario_id'], $data['libro_id'], $data['fecha_reserva'], $data['fecha_expiracion'])) {
    $db = new db('reservations');
    $result = $db->insert([
        'usuario_id' => $data['usuario_id'],
        'libro_id' => $data['libro_id'],
        'fecha_reserva' => $data['fecha_reserva'],
        'fecha_expiracion' => $data['fecha_expiracion']
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
