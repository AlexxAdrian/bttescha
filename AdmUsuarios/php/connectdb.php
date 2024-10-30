<?php
class DB_Connect {
    private $db;

    public function connect() {
        // Cambiar la ruta a la ruta absoluta de config.php
        require_once 'C:/xampp/htdocs/bttescha/config/config.php'; // Cambia a la ruta correcta según tu estructura
        $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($con->connect_error) {
            die("Error de conexión: " . $con->connect_error);
        }
        return $con;
    }

    public function close($con) {
        $con->close();
    }
}
?>
