<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'Pract1');

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Consultar los usuarios de la base de datos
$query = "SELECT Nick, Password, Borrado FROM usuario";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin de Usuarios</title>   
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        
        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            resize: both;
            overflow: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .close, .minimize, .maximize {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover, .minimize:hover, .maximize:hover {
            color: black;
        }
        .minimized {
            height: 50px;
            width: 30%;
            overflow: hidden;
        }
        .maximized {
            width: 90%;
            height: 90%;
        }
    </style>
</head>
<body>
    <h1>Admin Usuarios</h1>
    <table>
        <tr>
            <th>Nick</th>
            <th>Password</th>
            <th>Estado</th>
            <th>Editar</th>
            <th>Desactivar/Activar</th>
        </tr>
        
        <?php
        // Mostrar los datos de los usuarios
        while ($fila = $resultado->fetch_assoc()) {
            $estado = $fila['Borrado'] == 0 ? 'Activo' : 'Inactivo';
            $accion = $fila['Borrado'] == 0 ? 'Desactivar' : 'Activar';

            echo "<tr>
                <td>{$fila['Nick']}</td>
                <td>{$fila['Password']}</td>
                <td>{$estado}</td>
                <td><button onclick=\"openModalEdit('{$fila['Nick']}', '{$fila['Password']}', '{$fila['Borrado']}')\">Editar</button></td>
                <td><button onclick=\"openModalDeactivate('{$fila['Nick']}', '{$fila['Borrado']}')\">{$accion}</button></td>
            </tr>";
        }
        ?>

    </table>

    <!-- Modal para editar usuarios -->
    <div id="myModalEdit" class="modal">
        <div class="modal-content" id="modalContentEdit">
            <div class="modal-header">
                <h2>Editar Usuario</h2>
                <div>
                    <span class="minimize" onclick="minimizeModalEdit()">&#8722;</span>
                    <span class="maximize" onclick="maximizeModalEdit()">&#9723;</span>
                    <span class="close" onclick="closeModalEdit()">&times;</span>
                </div>
            </div>
            <form id="editForm" method="post" action="actualizar_usuario.php">
                <label for="nick">Nick:</label>
                <input type="text" id="nick" name="nick" readonly><br><br>
                <label for="password">Password:</label>
                <input type="text" id="password" name="password"><br><br>
                
                <div class="checkbox-container">
                    <label for="borrado">Desactivar:</label>
                    <span id="estadoTexto"></span>
                    <input type="checkbox" id="borrado" name="borrado">
                </div><br><br>

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </div>

    <!-- Modal para desactivar/activar usuarios -->
    <div id="myModalDeactivate" class="modal">
        <div class="modal-content" id="modalContentDeactivate">
            <div class="modal-header">
                <h2>Confirmar Acción</h2>
                <div>
                    <span class="minimize" onclick="minimizeModalDeactivate()">&#8722;</span>
                    <span class="maximize" onclick="maximizeModalDeactivate()">&#9723;</span>
                    <span class="close" onclick="closeModalDeactivate()">&times;</span>
                </div>
            </div>
            <form id="deactivateForm" method="post" action="cambiar_estado.php" onsubmit="return confirmAction()">
                <input type="hidden" id="nickDeactivate" name="nick">
                <input type="hidden" id="estadoDeactivate" name="estado">
                <p>¿Estás seguro de que deseas <span id="accionTexto"></span> a <span id="nickMostrar"></span>?</p>

                <input type="submit" value="Abuelita">
                <button type="button" onclick="closeModalDeactivate()">NelsonMandela</button>
            </form>
        </div>
    </div>

    <script>
        // Función para abrir el modal de edición
        function openModalEdit(nick, password, borrado) {
            document.getElementById('nick').value = nick;
            document.getElementById('password').value = password;
            document.getElementById('borrado').checked = borrado == 1 ? true : false;
            document.getElementById('estadoTexto').innerText = borrado == 1 ? 'Inactivo' : 'Activo';
            document.getElementById('myModalEdit').style.display = 'block';
        }

        // Función para cerrar el modal de edición
        function closeModalEdit() {
            document.getElementById('myModalEdit').style.display = 'none';
        }

        // Función para minimizar el modal de edición
        function minimizeModalEdit() {
            const modalContent = document.getElementById('modalContentEdit');
            modalContent.classList.toggle('minimized');
        }

        // Función para maximizar el modal de edición
        function maximizeModalEdit() {
            const modalContent = document.getElementById('modalContentEdit');
            modalContent.classList.toggle('maximized');
        }

        // Función para abrir el modal de desactivación
        function openModalDeactivate(nick, estado) {
            document.getElementById('nickDeactivate').value = nick;
            document.getElementById('estadoDeactivate').value = estado == 0 ? 1 : 0; // Si es 0, se desactiva, si es 1, se activa
            document.getElementById('accionTexto').innerText = estado == 0 ? 'desactivar' : 'activar';
            document.getElementById('nickMostrar').innerText = nick;
            document.getElementById('myModalDeactivate').style.display = 'block';
        }

        // Función para cerrar el modal de desactivación
        function closeModalDeactivate() {
            document.getElementById('myModalDeactivate').style.display = 'none';
        }

        // Función para minimizar el modal de desactivación
        function minimizeModalDeactivate() {
            const modalContent = document.getElementById('modalContentDeactivate');
            modalContent.classList.toggle('minimized');
        }

        // Función para maximizar el modal de desactivación
        function maximizeModalDeactivate() {
            const modalContent = document.getElementById('modalContentDeactivate');
            modalContent.classList.toggle('maximized');
        }

    </script>

</body>
</html>

<?php
$conexion->close();
?>