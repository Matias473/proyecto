<?php
// Incluir el archivo de conexión
include("../conexion/conexion.php");

include("../sesiones/sesiones.php");
// Obtener la CURP del empleado de la URL
$curp = isset($_GET['curp']) ? $_GET['curp'] : ''; 

// Preparar y ejecutar la consulta
$query = "SELECT CURP, RFC, nombres, apellido_p, apellido_m, sexo, 
          fecha_nacimiento, email, telefono_movil, puesto, turno, 
          horario_entrada, horario_salida 
          FROM empleados 
          WHERE CURP = ? AND estatus = 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $curp);  // "s" porque CURP es string
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
</head>
<body>
    <div>
        <?php if ($empleado): ?>
            <div>
                <!-- Encabezado -->
                <div>
                    <h1>
                        <?php echo htmlspecialchars($empleado['nombres'] . ' ' . 
                                                  $empleado['apellido_p'] . ' ' . 
                                                  $empleado['apellido_m']); ?>
                    </h1>
                    <span>
                        <?php echo htmlspecialchars($empleado['puesto']); ?>
                    </span>
                </div>

                <div>
                    <!-- Información Personal -->
                    <div>
                        <h2>Información Personal</h2>
                        <div>
                            <p>
                                <span>CURP:</span> 
                                <?php echo htmlspecialchars($empleado['CURP']); ?>
                            </p>
                            <p>
                                <span>RFC:</span> 
                                <?php echo htmlspecialchars($empleado['RFC']); ?>
                            </p>
                            <p>
                                <span>Fecha de Nacimiento:</span> 
                                <?php echo date('d/m/Y', strtotime($empleado['fecha_nacimiento'])); ?>
                            </p>
                            <p>
                                <span>Sexo:</span> 
                                <?php echo $empleado['sexo'] === 'M' ? 'Masculino' : 'Femenino'; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <h2>Información de Contacto</h2>
                        <div>
                            <p>
                                <span>Email:</span>
                                <a href="mailto:<?php echo htmlspecialchars($empleado['email']); ?>">
                                    <?php echo htmlspecialchars($empleado['email']); ?>
                                </a>
                            </p>
                            <p>
                                <span>Teléfono:</span> 
                                <?php echo htmlspecialchars($empleado['telefono_movil']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div>
                        <h2>Información Laboral</h2>
                        <div>
                            <p>
                                <span>Turno:</span> 
                                <?php echo htmlspecialchars($empleado['turno']); ?>
                            </p>
                            <p>
                                <span>Horario:</span> 
                                <?php echo htmlspecialchars($empleado['horario_entrada'] . ' - ' . 
                                                          $empleado['horario_salida']); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div>
                    <a href="tabla2.php">
                        Regresar a la Lista
                    </a>
                    <a href="editar_empleado.php?curp=<?php echo urlencode($empleado['CURP']); ?>">
                        Editar Empleado
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div>
                <p>No se encontró información del empleado.</p>
                <p>
                    <a href="tabla2.php">
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