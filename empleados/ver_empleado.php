<?php
// Incluir el archivo de conexión
include("../conexion/conexion.php");

// Obtener el ID del empleado de la URL
$id_empleado = isset($_GET['id']) ? $_GET['id'] : 1; // Por defecto muestra el empleado 1

// Preparar y ejecutar la consulta
$query = "SELECT CURP, RFC, nombres, apellido_p, apellido_m, sexo, 
          fecha_nacimiento, email, telefono_movil, puesto, turno, 
          horario_entrada, horario_salida 
          FROM empleados 
          WHERE id_empleado = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Empleado</title>
    <!-- Incluir Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <?php if ($empleado): ?>
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl mx-auto">
                <!-- Encabezado -->
                <div class="border-b pb-4 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        <?php echo htmlspecialchars($empleado['nombres'] . ' ' . 
                                                  $empleado['apellido_p'] . ' ' . 
                                                  $empleado['apellido_m']); ?>
                    </h1>
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mt-2">
                        <?php echo htmlspecialchars($empleado['puesto']); ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información Personal -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4 text-gray-700">Información Personal</h2>
                        <div class="space-y-3">
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">CURP:</span> 
                                <?php echo htmlspecialchars($empleado['CURP']); ?>
                            </p>
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">RFC:</span> 
                                <?php echo htmlspecialchars($empleado['RFC']); ?>
                            </p>
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Fecha de Nacimiento:</span> 
                                <?php echo date('d/m/Y', strtotime($empleado['fecha_nacimiento'])); ?>
                            </p>
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Sexo:</span> 
                                <?php echo $empleado['sexo'] === 'M' ? 'Masculino' : 'Femenino'; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4 text-gray-700">Información de Contacto</h2>
                        <div class="space-y-3">
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Email:</span>
                                <a href="mailto:<?php echo htmlspecialchars($empleado['email']); ?>" 
                                   class="text-blue-600 hover:underline">
                                    <?php echo htmlspecialchars($empleado['email']); ?>
                                </a>
                            </p>
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Teléfono:</span> 
                                <?php echo htmlspecialchars($empleado['telefono_movil']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 text-gray-700">Información Laboral</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Turno:</span> 
                                <?php echo htmlspecialchars($empleado['turno']); ?>
                            </p>
                            <p class="bg-gray-50 p-3 rounded">
                                <span class="font-medium">Horario:</span> 
                                <?php echo htmlspecialchars($empleado['horario_entrada'] . ' - ' . 
                                                          $empleado['horario_salida']); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="mt-8 flex justify-center gap-4">
                    <a href="tabla.php" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg 
                              transition duration-200">
                        Regresar a la Lista
                    </a>
                    <a href="editar_empleado.php?id=<?php echo $id_empleado; ?>" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg 
                              transition duration-200">
                        Editar Empleado
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <p class="font-medium">No se encontró información del empleado.</p>
                <p class="mt-2">
                    <a href="lista_empleados.php" class="text-red-700 underline">
                        Volver a la lista de empleados
                    </a>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    // Cerrar la conexión y el statement
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>