<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');
include('../sesiones/sesiones.php');

// Verificar si se ha enviado un término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Consulta para obtener los campos específicos de los empleados dados de baja
if (!empty($search)) {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno 
            FROM empleados 
            WHERE estatus = 0 
            AND (nombres LIKE ? OR apellido_p LIKE ? OR CURP LIKE ?);";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno  
            FROM empleados 
            WHERE estatus = 0;";
    $result = $conn->query($sql);
}

// Procesar restauración si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['restore_curp'])) {
    $curp = $_POST['restore_curp'];
    $restore_sql = "UPDATE empleados SET estatus = 1 WHERE CURP = ?";
    $stmt = $conn->prepare($restore_sql);
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
    <title>Gestión de Usuarios Dados de Baja</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="navbar-left">
            <button class="menu-toggle">☰</button>
            <ul class="navbar-menu">
                <li><a href="../pagina/inicio.php">Inicio</a></li>
                <li><a href="../empleados/tabla2.php">Gestión de empleados</a></li>
                <li><a href="../usuarios/gestion_user.php" class="link">Gestionar usuarios</a></li>
                <li><a href="../empleados/bajas.php" class="navbar-link">Empleados dados de baja</a></li>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
    </nav>

    <!-- Contenedor principal -->
    <div class="tabla2-container">
        <h1 class="tabla2-title">Usuarios Dados de Baja</h1>

        <!-- Barra de búsqueda -->
        <div class="tabla2-controls">
            <form method="GET" action="bajas.php" class="busqueda-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar usuario dado de baja" 
                    class="busqueda-input" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="busqueda-button">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Tabla -->
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
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["CURP"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombres"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["apellido_p"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["puesto"]) . "</td>";
                        echo "<td class='tabla2-actions'>";
                        echo "<form method='POST' class='inline' onsubmit='return confirm(\"¿Está seguro de restaurar este usuario?\")'>";
                        echo "<input type='hidden' name='restore_curp' value='" . htmlspecialchars($row["CURP"]) . "'>";
                        echo "<button type='submit' title='Restaurar'><i class='fa fa-undo'></i></button>";
                        echo "<a href='ver_empleado_baja.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-eye'></i></a>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay usuarios dados de baja</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
