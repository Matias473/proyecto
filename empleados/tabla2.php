<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');
include('../sesiones/sesiones.php');

// Verificar si se ha enviado un término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Consulta para obtener los campos específicos de los empleados
if (!empty($search)) {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno 
            FROM empleados 
            WHERE estatus = 1 
            AND (nombres LIKE ? OR apellido_p LIKE ? OR CURP LIKE ?);";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno  
            FROM empleados 
            WHERE estatus = 1;";
    $result = $conn->query($sql);
}

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
    <!-- Barra de navegación -->
     <!-- esta  pantalla se compartira con las secretarias entonces es vital colocar permisos aqui -->
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
        <!-- Título -->
        <h1 class="tabla2-title">Gestión de Empleados</h1>

        <!-- Botones y barra de búsqueda -->
        <div class="tabla2-controls">
            <a href="registrar_empleado.php" class="tabla2-add-link">+ Añadir Empleado</a>
            <a href="tabla2.php" class="tabla2-add-link">Ver todos los empleados</a>
            <form method="GET" action="tabla2.php" class="busqueda-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Busqueda de empleado" 
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
                    while($row = $result->fetch_assoc()) {
                        // en este apartado tambien ya que las secretarias deberan poder ver la informacion del empleado pero no modificar
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
</body>
</html>
