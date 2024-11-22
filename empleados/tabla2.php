<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');

include('../sesiones/sesiones.php');
// Consulta para obtener los campos específicos de los empleados
$sql = "SELECT CURP, nombres, apellido_p, puesto, turno  from empleados WHERE estatus = 1;";
$result = $conn->query($sql);

// Procesar eliminación si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_curp'])) {
    $curp = $_POST['delete_curp'];
    $delete_sql = "UPDATE empleados SET estatus = 0 WHERE CURP = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $curp);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<nav class="navbar" id="navbar">
        <div class="navbar-left" id="navbar-left">
            <button class="menu-toggle" id="menu-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="../pagina/inicio.php" class="navbar-link" id="link-inicio">Inicio</a></li>
                <li><a href="../usuarios/registro_user.php" class="navbar-link" id="link-usuarios">Usuarios</a></li>
                <li><a href="../empleados/registrar_empleado.php" class="navbar-link" id="link-empleados">Empleados</a></li>
                <li><a href="../empleados/tabla2.php" class="navbar-link" id="link-tabla">Gestión de empleados</a></li>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link" id="logout-link">Cerrar sesión</a>
    </nav>

<div class="tabla2-container">
    <div>
        <h1 class="tabla2-title" id="G_empleados">Gestión de Empleados</h1>
        <a href="registrar_empleado.php" class="tabla2-add-link">
            + Añadir Empleado
        </a>
    </div>

    <div>
        <table class="tabla2-table">
            <thead>
                <tr>
                    <th>CURP</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Puesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["CURP"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombres"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["apellido_p"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["puesto"]) . "</td>";
                        echo "<td class='tabla2-actions'>";
                        echo "<a href='ver_empleado.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-eye'></i></a>";
                        echo "<a href='mod_empleado.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-edit'></i></a>";
                        echo "<form method='POST' class='inline' onsubmit='return confirm(\"¿Está seguro de eliminar este empleado?\")'>";
                        echo "<input type='hidden' name='delete_curp' value='" . htmlspecialchars($row["CURP"]) . "'>";
                        echo "<button type='submit'><i class='fa fa-trash'></i></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay empleados registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
