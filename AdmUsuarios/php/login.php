<?php
require_once 'C:/xampp/htdocs/bttescha/AdmUsuarios/php/connectdb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['user']) ? $_POST['user'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($user) && !empty($password)) {
        $db = new DB_Connect();
        $con = $db->connect();
        
        $userEscaped = $con->real_escape_string($user);

        $sql = "SELECT Password FROM usuario WHERE Nick = '$userEscaped'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password === $row['Password']) { 
                header('Location: ../index.html');
                exit();
            } else {
                echo "<script>alert('Usuario o contraseña incorrectos.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos.'); window.history.back();</script>";
        }

        $con->close();
    } else {
        echo "<script>alert('Por favor, ingrese un usuario y contraseña válidos.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}
?>
