<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'C:/xampp/htdocs/bttescha/AdmUsuarios/php/connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'], $_POST['password'])) {
    $db = new DB_Connect();
    $con = $db->connect();
    
    $nick = $con->real_escape_string(trim($_POST['user']));
    $password = trim($_POST['password']); 
    $checkUser = "SELECT * FROM usuario WHERE Nick = '$nick'";
    $result = $con->query($checkUser);

    if ($result->num_rows > 0) {
        echo "Error: El nombre de usuario ya está en uso.";
        header("Refresh:2; url=/bttescha/AdmUsuarios/registro.html");
        exit();
    } else {
        $sql = "INSERT INTO usuario (Nick, Password, Borrado) VALUES ('$nick', '$password', '0')";
        
        if ($con->query($sql) === TRUE) {
            echo "Usuario registrado con éxito";
            header("Refresh:2; url=/bttescha/index.php");
            exit();
        } else {
            echo "Error al registrar el usuario: " . $con->error;
        }
    }

    $con->close();
} else {
    echo "Error: Complete los datos del formulario.";
}
?>
