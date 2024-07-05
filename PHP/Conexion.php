<?php
class Conexion {
    private $servername = "sql111.infinityfree.com";
    private $username = "if0_36308657";
    private $password = "Kalomito1234";
    private $database = "if0_36308657_biblioteca_futuro";
    private $conn;

    public function ConexionDB() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            $this->conn = null;
        }
        return $this->conn;
    }
}
?>
