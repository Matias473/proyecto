<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
if ($privilegio != 'docente' && $privilegio != 'directivo' && $privilegio != 'secretaria') {
    // Si el privilegio no es 'docente' o 'directivo', redirigir a una página de error o login
    header("Location: ../sesiones/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancias</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="navbar-left">
            <button class="menu-toggle" id="menu-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <?php if ($privilegio == 'admin' || $privilegio == 'directivo' || $privilegio == 'docente'): ?>
                <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
                <?php endif; ?> 
                <li><a href="../constancias/constancias.php" class="navbar-link">Constancias</a></li>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
    </nav>

    <!-- Contenedor del panel -->
    <div id="access-container">
        <h1 class="main-title">Bienvenido, <?php echo ucfirst($privilegio); ?></h1>
        <p class="privilege-info">Privilegio: <span id="privilege"><?php echo htmlspecialchars($privilegio); ?></span></p>

        <div class="form">
            <div class="form-group">
                <a href="../constancias/ver_constancias.php" class="form-button">Ver Constancias</a><br>
                <?php if ($privilegio == 'secretaria'): ?>
                    <a href="../constancias/emitir_constancias.php" class="form-button">Emitir Constancias</a>
                    <?php endif; ?>
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
