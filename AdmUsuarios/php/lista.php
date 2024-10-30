<?php
require_once 'C:/xampp/htdocs/bttescha/AdmUsuarios/php/connectdb.php';

$db = new DB_Connect();
$con = $db->connect();

if ($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $nick = $_POST['Nick'];

        if ($action === 'update') {
            $password = $_POST['Password'];
            $newNick = $_POST['newNick']; 
            if (!empty($newNick) && !empty($password)) {
                $stmt = $con->prepare("UPDATE usuario SET Nick = ?, Password = ? WHERE Nick = ?");
                $stmt->bind_param('sss', $newNick, $password, $nick);
                if ($stmt->execute()) {
                    echo "Usuario actualizado con éxito.";
                } else {
                    echo "Error al actualizar el usuario: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Nick o contraseña no pueden estar vacíos.";
            }
        } elseif ($action === 'toggle') {
            $estado = $_POST['estado'];
            $nuevoEstado = ($estado == '0') ? '1' : '0';

            $stmt = $con->prepare("UPDATE usuario SET borrado = ? WHERE Nick = ?");
            $stmt->bind_param('is', $nuevoEstado, $nick);
            if ($stmt->execute()) {
                echo $nuevoEstado ? "Usuario desactivado con éxito." : "Usuario activado con éxito.";
            } else {
                echo "Error al cambiar el estado del usuario.";
            }
            $stmt->close();
        } elseif ($action === 'delete') {
            // Agregar lógica para eliminar usuario
            $stmt = $con->prepare("DELETE FROM usuario WHERE Nick = ?");
            $stmt->bind_param('s', $nick);
            if ($stmt->execute()) {
                echo "Usuario eliminado con éxito.";
            } else {
                echo "Error al eliminar el usuario: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $sql = "SELECT Nick, Password, borrado FROM usuario"; 
        $sqlresultado = $con->query($sql);

        if ($sqlresultado->num_rows > 0) {
            while ($fila = $sqlresultado->fetch_assoc()) {
                $estado = ($fila["borrado"] == '0') ? "Activo" : "Inactivo"; 
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila["Nick"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["Password"]) . "</td>";
                echo "<td>" . $estado . "</td>";
                echo "<td class='text-center'>";
                echo "<button class='btneditar' onclick=\"showUpdateModal('" . htmlspecialchars($fila["Nick"]) . "', '" . htmlspecialchars($fila["Password"]) . "')\">";
                echo "<i class='fas fa-edit'></i> Editar";
                echo "</button> ";
                echo "<button class='btnactive' onclick=\"confirmToggle('" . htmlspecialchars($fila["Nick"]) . "', '" . htmlspecialchars($fila["borrado"]) . "')\">";
                echo "<i class='fas fa-exchange-alt'></i> Activar / Desactivar";
                echo "</button> ";
                echo "<button class='btndelete' onclick=\"confirmDelete('" . htmlspecialchars($fila["Nick"]) . "')\">";
                echo "<i class='fas fa-trash'></i> Eliminar";
                echo "</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
        }
    }
} else {
    echo "Error de conexión a la base de datos.";
}
?>
