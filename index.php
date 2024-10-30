<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style.css">
    
</head>

<body>
    <div class="container">
        <div class="heading">Iniciar Sesión</div>
      
        <form class="form" id="formLogin" action="AdmUsuarios/php/login.php" method="POST">

      
          <input placeholder="Nick" id="user" name="user" type="text" class="input" required=""/>
      
          <input placeholder="Contraseña" id="password" name="password" type="password" class="input" required=""/>
      
          <span class="forgot-password"><a href="#">Olvidaste la contraseña?</a></span>
      
          <input value="Acceder" type="submit" class="login-button" />
          <button type="button"onclick="window.location.href='AdmUsuarios/registro.html'" class="login-button">Registrarse</button>
        </form>
    </div>
</body>

</html>
