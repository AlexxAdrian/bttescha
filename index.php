<html>
<head>
    <title>Login</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

    <style>
        body {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1, h2 {
            color: #f8f9fa;
            margin-bottom: 20px;
        }

        #user {
            color: #6c757d; 
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #212529;
            border-radius: 5px;
        }

        label, input {
            display: block;
            margin: 10px 0;
            width: 100%;
        }

        input {
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Hola Insano, Trrr</h1>
    <h2>LOGIN</h2>

    <form id="formLogin" action="AdmUsuarios/php/login.php" method="POST">

        <label for="user">NICK</label>
        <input type="text" id="user" name="user" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    
    <br>

    <!-- Botón de Registrar estilizado -->
    <button type="button" onclick="window.location.href='AdmUsuarios/registro.html'">Registrar</button>


</body>
</html>
