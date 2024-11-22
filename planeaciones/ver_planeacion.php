<?php
session_start();
include_once("../conexion/conexion.php");
include("../sesiones/sesiones.php"); // Asegura que la sesión está activa
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeaciones</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="../verplan-estilos.css"> <!-- Archivo CSS adicional -->
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

    <!-- Contenido principal -->
    <div class="verplan-container">
        <h3 class="verplan-title">Planeaciones</h3>
        <hr>
        <div class="verplan-table-container">
            <?php
            $consulta = "SELECT id_planeacion, subido_por, docente_encargado, nombre_materia, grado, periodo, 
                         fecha_creacion, hora_creacion, archivo, aprobacion, aprobado_por, estatus, nom_arch, 
                         size_arch, ruta, extencion FROM planeaciones";
            $resultado = $conn->query($consulta);

            echo "<table class='verplan-table'>";
            echo "<tr class='verplan-header-row'>
                    <th>#</th>
                    <th>Subido Por</th>
                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Grado</th>
                    <th>Periodo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Archivo</th>
                    <th>Aprobación</th>
                    <th>Aprobado Por</th>
                    <th>Estatus</th>
                    <th>Nombre Archivo</th>
                    <th>Tamaño</th>
                    <th>Ruta</th>
                    <th>Extensión</th>
                    <th>Acciones</th>
                  </tr>";

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr class='verplan-row'>";
                echo "<td>" . $fila['id_planeacion'] . "</td>";
                echo "<td>" . htmlspecialchars($fila['subido_por']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['docente_encargado']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre_materia']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['grado']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['periodo']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_creacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['hora_creacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['archivo']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['aprobacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['aprobado_por']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['estatus']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nom_arch']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['size_arch']) . " KB</td>";
                echo "<td><a href='" . htmlspecialchars($fila['ruta']) . "' target='_blank' class='verplan-link'>Ver Archivo</a></td>";
                echo "<td>" . htmlspecialchars($fila['extencion']) . "</td>";
                echo "<td><a href='eliminar_planeacion.php?id_planeacion=" . $fila['id_planeacion'] . "' class='verplan-action-link'>Eliminar</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <hr>
        <div class="verplan-actions">
            <a href="subir_planeacion.php" class="verplan-button">Subir Planeación</a>
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
