<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="navbar-left">
            <button class="menu-toggle" id="menu-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <!-- Barra de navegación solo para administradores -->
                <?php if ($privilegio == 'admin'): ?>
                    <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                    <li><a href="../usuarios/registro_user.php" class="navbar-link">Usuarios</a></li>
                    <li><a href="../empleados/registrar_empleado.php" class="navbar-link">Empleados</a></li>
                    <li><a href="../empleados/tabla2.php" class="navbar-link">Gestión de empleados</a></li>
                    <li><a href="../usuarios/gestion_user.php" class="navbar-link">Gestión de usuarios</a></li>
                <?php endif; ?>

                <!-- Barra de navegación para docentes -->
                <?php if ($privilegio == 'docente'): ?>
                    <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                    <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
                    <li><a href="../constancias/constancias.php" class="navbar-link">Constancias</a></li>
                <?php endif; ?>

                <!-- Barra de navegación para secretarias -->
                <?php if ($privilegio == 'secretaria'): ?>
                    <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                    <li><a href="../constancias/constancias.php" class="navbar-link">Constancias</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
    </nav>
    
    <div id="access-container">
        <h1 class="main-title">Tienes acceso</h1>
        <p class="privilege-info">Privilegio: <span id="privilege"><?php echo htmlspecialchars($privilegio); ?></span></p>

        <table class="privileges-table">
            <tr>
                <th>Sección</th>
                <th>Descripción</th>
            </tr>
            <?php if ($privilegio == 'admin'): ?>
                <tr>
                    <td>Administradores</td>
                    <td>Acceso a contenido exclusivo para administradores.</td>
                </tr>
                <tr>
                    <td><a href="../sesiones/registro_user.php" class="link">Nuevo usuario</a></td>
                    <td>Registrar un nuevo usuario en el sistema.</td>
                </tr>
                <tr>
                    <td><a href="../empleados/registrar_empleado.php" class="link">Nuevo empleado</a></td>
                    <td>Registrar un nuevo empleado en el sistema.</td>
                </tr>
                <tr>
                    <td><a href="../empleados/tabla2.php" class="link">Gestionar empleados</a></td>
                    <td>Visualizar la tabla de empleados.</td>
                </tr>
                <tr>
                    <td><a href="../usuarios/gestion_user.php" class="link">Gestionar usuarios</a></td>
                    <td>Visualizar la tabla de usuarios.</td>
                </tr>
                <tr>
                    <td><a href="../planeaciones/subir_planeacion.php" class="link">Planeaciones</a></td>
                    <td>Visualizar la tabla de usuarios.</td>
                </tr>
            <?php elseif ($privilegio == 'docente'): ?>
                <tr>
                    <td>Docentes</td>
                    <td>Acceso a contenido exclusivo para docentes.</td>
                </tr>
                <tr>
                    <td><a href="../planeaciones/planeaciones.php" class="link">Planeaciones</a></td>
                    <td>Acceso a las planeaciones del docente.</td>
                </tr>
                <tr>
                    <td><a href="../constancias/constancias.php" class="link">Constancias</a></td>
                    <td>Ver las constancias relacionadas.</td>
                </tr>
            <?php elseif ($privilegio == 'secretaria'): ?>
                <tr>
                    <td>Secretarias</td>
                    <td>Acceso a contenido exclusivo para secretarias.</td>
                </tr>
                <tr>
                    <td><a href="../constancias/constancias.php" class="link">Constancias</a></td>
                    <td>Emitir y visualizar las constancias disponibles.</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>Sin privilegios</td>
                    <td>No tienes privilegios especiales asignados.</td>
                </tr>
            <?php endif; ?>
        </table>
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
