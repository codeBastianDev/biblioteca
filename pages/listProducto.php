<?php
include_once("../class/helper.php");

$libros = new db("books");

$filters = [];
if (isset($_POST['categoria']) && $_POST['categoria'] != '0') {
    $filters[] = "category = '" . $_POST['categoria'] . "'";
}
if (isset($_POST['estado']) && $_POST['estado'] != '0') {
    $filters[] = "status = '" . $_POST['estado'] . "'";
}
if (isset($_POST['buscador']) && $_POST['buscador'] != '') {
    $filters[] = "title LIKE '%" . $_POST['buscador'] . "%'";
}

$where = '';
if (count($filters) > 0) {
    $where = 'WHERE ' . implode(' AND ', $filters);
}

$sql = "SELECT * FROM books $where";
$resultado = $libros->query($sql);

if ($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($row["category"]) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($row["created_at"]) . "</td>";
        echo "<td class='text-center'>" . ($row["status"] ? "Activo" : "Inactivo") . "</td>";
        echo "<td class='text-center'><a href='editProducto.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-warning'><i class='ni ni-settings'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
}
?>
