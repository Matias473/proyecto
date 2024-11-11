<?php
session_start(); // Mantener la sesión activa

$acceso = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Corrección aquí
    $user = $_POST['usuario'];
    $contra = $_POST['contraseña'];

    include_once("../conexion/conexion.php");

    $sentencia = "SELECT email, contrasena, privilegio, estatus FROM usuarios WHERE email='$user' AND contrasena='$contra' AND estatus=1";
    $ejecutar = mysqli_query($conn, $sentencia);

    if (mysqli_num_rows($ejecutar)) {
        if ($fila = mysqli_fetch_assoc($ejecutar)) {
            $privilegio = $fila['privilegio'];

            $_SESSION['usuario'] = $user;
            $_SESSION['privilegio'] = $privilegio;
            
            $entrar = "acceso";
            
            header("Location:../pagina/inicio.php");
            exit();
        }
    } else {
        $entrar = "noacceso"; 
        $mensaje = "No tienes acceso, corazón.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
</head>
<body>
    <h1>BIENVENIDO AL SISTEMA</h1>
    <form method="post">
        <p>Usuario: <input type="text" name="usuario" required></p>
        <p>Contraseña: <input type="password" name="contraseña" required></p> 
        <input type="submit" value="Iniciar">
    </form>
    <h2>
        <?php
            echo $mensaje;
        ?>
    </h2>
</body>
</html>