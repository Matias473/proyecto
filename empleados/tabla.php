<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');

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
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Empleados</h1>
            <a href="registrar_empleado.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                + Añadir Empleado
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            CURP
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Apellido Paterno
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Puesto
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-50'>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . htmlspecialchars($row["CURP"]) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . htmlspecialchars($row["nombres"]) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . htmlspecialchars($row["apellido_p"]) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . htmlspecialchars($row["puesto"]) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap text-center text-sm font-medium'>";
                            echo "<div class='flex justify-center space-x-3'>";
                            // Botón Ver
                            echo "<a href='ver_empleado.php?curp=" . urlencode($row["CURP"]) . "' class='text-blue-600 hover:text-blue-900'>";
                            echo "<i class='fas fa-eye'></i>";
                            echo "</a>";
                            // Botón Editar
                            echo "<a href='editar_empleado.php?curp=" . urlencode($row["CURP"]) . "' class='text-yellow-600 hover:text-yellow-900'>";
                            echo "<i class='fas fa-pencil-alt'></i>";
                            echo "</a>";
                            // Botón Eliminar
                            echo "<form method='POST' class='inline' onsubmit='return confirm(\"¿Está seguro de eliminar este empleado?\")'>";
                            echo "<input type='hidden' name='delete_curp' value='" . htmlspecialchars($row["CURP"]) . "'>";
                            echo "<button type='submit' class='text-red-600 hover:text-red-900'>";
                            echo "<i class='fas fa-trash-alt'></i>";
                            echo "</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='px-6 py-4 text-center text-sm text-gray-500'>No hay empleados registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>