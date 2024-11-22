<?php
session_start(); // Mantener la sesión activa

$acceso = "";
$mensaje = "";

// Manejo de peticiones web
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user = $_POST['usuario'];
    $contra = $_POST['contraseña'];

    include_once("../conexion/conexion.php");

    // Consulta para obtener la contraseña encriptada del usuario
    $sentencia = "SELECT email, contrasena, privilegio, estatus FROM usuarios WHERE email='$user' AND estatus=1";
    $ejecutar = mysqli_query($conn, $sentencia);

    if (mysqli_num_rows($ejecutar)) {
        if ($fila = mysqli_fetch_assoc($ejecutar)) {
            // Verificar la contraseña ingresada contra la encriptada
            if (password_verify($contra, $fila['contrasena'])) {
                $privilegio = $fila['privilegio'];

                $_SESSION['usuario'] = $user;
                $_SESSION['privilegio'] = $privilegio;

                $entrar = "acceso";

                header("Location:../pagina/inicio.php");
                exit();
            } else {
                $mensaje = "Contraseña incorrecta.";
            }
        }
    } else {
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
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="general-body">
    <div class="container" id="login-container">
        <h1 class="title" id="main-title">BIENVENIDO AL SISTEMA</h1>
        <form method="post" class="form" id="login-form">
            <p class="form-group">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-input" required>
            </p>
            <p class="form-group">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-input" required>
            </p> 
            <input type="submit" value="Iniciar" class="form-button" id="submit-button">
        </form>
        <h2 class="error-message" id="error-message">
            <?php
                echo $mensaje ?? '';
            ?>
        </h2>
    </div>
</body>
</html>