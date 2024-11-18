<?php
include('../sesiones/sesiones.php');

$mensaje = "";

// 1.- Conectarse a la BD
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['curp'])) {
    $curp_em = $_GET['curp'];

    // Consultar datos del empleado
    $consulta_sql = "SELECT * FROM empleados WHERE CURP = '$curp_em'";
    $resultado = mysqli_query($conn, $consulta_sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $empleado = $fila;
    } else {
        $mensaje = "Empleado no encontrado.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $curp_em = $_POST['CURP'];
    $rfc_em = $_POST['RFC'];
    $titulo_em = $_POST['titulo'];
    $nombres_em = $_POST['nombres'];
    $apellido_p_em = $_POST['apellido_p'];
    $apellido_m_em = $_POST['apellido_m'];
    $sexo_em = $_POST['sexo'];
    $fecha_nacimiento_em = $_POST['fecha_nacimiento'];
    $email_em = $_POST['email'];
    $telefono_movil_em = $_POST['telefono_movil'];
    $telefono_fijo_em = $_POST['telefono_fijo'];
    $estado_civil_em = $_POST['estado_civil'];
    $cp_em = $_POST['CP'];
    $col_fracc_em = $_POST['col_fracc'];
    $calle_em = $_POST['calle'];
    $numero_em = $_POST['numero'];
    $fecha_contrato_em = $_POST['fecha_contrato'];
    $puesto_em = $_POST['puesto'];
    $turno_em = $_POST['turno'];
    $horario_entrada_em = $_POST['horario_entrada'];
    $horario_salida_em = $_POST['horario_salida'];

    // Actualizar los datos del empleado
    $sentencia = "UPDATE empleados SET 
        RFC = '$rfc_em', 
        titulo = '$titulo_em', 
        nombres = '$nombres_em', 
        apellido_p = '$apellido_p_em', 
        apellido_m = '$apellido_m_em', 
        sexo = '$sexo_em', 
        fecha_nacimiento = '$fecha_nacimiento_em', 
        email = '$email_em', 
        telefono_movil = '$telefono_movil_em', 
        telefono_fijo = '$telefono_fijo_em', 
        estado_civil = '$estado_civil_em', 
        CP = '$cp_em', 
        col_fracc = '$col_fracc_em', 
        calle = '$calle_em', 
        numero = '$numero_em', 
        fecha_contrato = '$fecha_contrato_em', 
        puesto = '$puesto_em', 
        turno = '$turno_em', 
        horario_entrada = '$horario_entrada_em', 
        horario_salida = '$horario_salida_em' 
        WHERE CURP = '$curp_em'";

    if (mysqli_query($conn, $sentencia)) {
        $mensaje = "Datos del empleado actualizados con éxito.";
    } else {
        $mensaje = "Error al actualizar los datos: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empleado</title>
    <script>
    window.onload = function() {
        <?php if (!empty($mensaje)) { ?>
            alert("<?php echo $mensaje; ?>");
            window.location.href = "tabla2.php";
        <?php } ?>
    };
    </script>


</head>

<body>
    <h1>Modificar Empleado</h1>
    <form action="mod_empleado.php" method="POST">
        <!-- Campos del formulario -->
        <label for="CURP">CURP:</label>
        <input type="text" name="CURP" value="<?php echo $empleado['CURP'] ?? ''; ?>" readonly><br>

        <label for="RFC">RFC:</label>
        <input type="text" name="RFC" value="<?php echo $empleado['RFC'] ?? ''; ?>" readonly><br>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo $empleado['titulo'] ?? ''; ?>"><br>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" value="<?php echo $empleado['nombres'] ?? ''; ?>" required><br>

        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" name="apellido_p" value="<?php echo $empleado['apellido_p'] ?? ''; ?>" required><br>

        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" name="apellido_m" value="<?php echo $empleado['apellido_m'] ?? ''; ?>" required><br>

        <label for="sexo">Sexo:</label>
        <input type="text" name="sexo" value="<?php echo $empleado['sexo'] ?? ''; ?>" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $empleado['fecha_nacimiento'] ?? ''; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $empleado['email'] ?? ''; ?>" required><br>

        <label for="telefono_movil">Teléfono Móvil:</label>
        <input type="text" name="telefono_movil" value="<?php echo $empleado['telefono_movil'] ?? ''; ?>"><br>

        <label for="telefono_fijo">Teléfono Fijo:</label>
        <input type="text" name="telefono_fijo" value="<?php echo $empleado['telefono_fijo'] ?? ''; ?>"><br>

        <label for="estado_civil">Estado Civil:</label>
        <input type="text" name="estado_civil" value="<?php echo $empleado['estado_civil'] ?? ''; ?>"><br>

        <label for="CP">Código Postal:</label>
        <input type="text" name="CP" value="<?php echo $empleado['CP'] ?? ''; ?>"><br>

        <label for="col_fracc">Colonia/Fraccionamiento:</label>
        <input type="text" name="col_fracc" value="<?php echo $empleado['col_fracc'] ?? ''; ?>"><br>

        <label for="calle">Calle:</label>
        <input type="text" name="calle" value="<?php echo $empleado['calle'] ?? ''; ?>"><br>

        <label for="numero">Número:</label>
        <input type="text" name="numero" value="<?php echo $empleado['numero'] ?? ''; ?>"><br>

        <label for="fecha_contrato">Fecha de Contrato:</label>
        <input type="date" name="fecha_contrato" value="<?php echo $empleado['fecha_contrato'] ?? ''; ?>" required><br>

        <label for="puesto">Puesto:</label>
        <input type="text" name="puesto" value="<?php echo $empleado['puesto'] ?? ''; ?>" required><br>

        <label for="turno">Turno:</label>
        <input type="text" name="turno" value="<?php echo $empleado['turno'] ?? ''; ?>" required><br>

        <label for="horario_entrada">Horario Entrada:</label>
        <input type="time" name="horario_entrada" value="<?php echo $empleado['horario_entrada'] ?? ''; ?>" required><br>

        <label for="horario_salida">Horario Salida:</label>
        <input type="time" name="horario_salida" value="<?php echo $empleado['horario_salida'] ?? ''; ?>" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>
