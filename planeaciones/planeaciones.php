<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
if ($privilegio != 'docente') {
    // Si el privilegio no es 'docente', redirigir a una página de error o login
    header("Location: ../sesiones/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeaciones</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="navbar-left">
            <button class="menu-toggle" id="menu-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
                <li><a href="../constancias/constancias.php" class="navbar-link">Constancias</a></li>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
    </nav>

    <!-- Contenedor del panel -->
    <div id="access-container">
        <h1 class="main-title">Bienvenido, Docente</h1>
        <p class="privilege-info">Privilegio: <span id="privilege"><?php echo htmlspecialchars($privilegio); ?></span></p>

        <div class="form">
            <div class="form-group">
                <a href="../planeaciones/subir_planeacion.php" class="form-button">Subir Planeación</a>
            </div>
            <div class="form-group">
                <a href="../planeaciones/ver_planeacion.php" class="form-button">Ver Planeaciones</a>
            </div>
        </div>
    </div>

    <script>
        // JavaScript para manejar el menú adaptable
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('navbar-menu');
            menu.classList.toggle('active');
        });
    </script>
</body>
</html>
