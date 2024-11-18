<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>Tienes acceso</h1>
    <p>Su privilegio es: <?php echo htmlspecialchars($privilegio); ?></p>

    <?php if ($privilegio == 'admin'): ?>
        <h2>Si eres admin, puedes ver este contenido exclusivo para administradores.</h2>
        <p><a href="../usuarios/registro_user.php">nuevo usuario</a></p>
        <p><a href="../empleados/tabla2.php">gestionar empleados</a></p>
        <p><a href="../usuarios/gestion_user.php">gestionar usuarios</a></p>
    <?php elseif ($privilegio == 'docente'): ?>
        <h2>Si eres docente, puedes ver este contenido exclusivo para docentes.</h2>
    <?php elseif ($privilegio == 'secretaria'): ?>
        <h2>Si eres secretaria, puedes ver este contenido exclusivo para secretarias.</h2>
    <?php else: ?>
        <h2>No tienes privilegios especiales asignados.</h2>
    <?php endif; ?>
    <p><a href="../sesiones/logout.php">Cerrar sesión</a></p>
</body>
</html>