<!-- insert into usuarios (email, contrasena, privilegio, estatus) values ('docente', 'pass', 'docente', 1); -->
<?php
include('sesiones.php');

$entrar = "";
$mensaje ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //1.- Conectarse a la BD
    include("../conexion/conexion.php");
    
    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $privi = $_POST['privilegio'];
    $status= 1;
    $sentencia = "INSERT INTO usuarios (email, contrasena, privilegio, estatus) VALUES ('$email', '$password', '$privi', '$status')";
    
    $ejecutar_sql = $conn->query($sentencia);

    if ($ejecutar_sql) {
        $entrar = "insertar";
        $mensaje = "se ha hecho el registro";
        header('location: ../pagina/inicio.php');
    } else {
        $entrar = "noinsertar";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <?php
    '<p>$mensaje</p>';
    ?>

    <form action="registro_user.php" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" required>
        <br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br><br>

        <label for="privilegio">Privilegio:</label>
        <input type="text" id="privilegio" name="privilegio" required>
        <br><br>

        <button type="submit">Registrar Usuario</button>
    </form>
</body>
</html>