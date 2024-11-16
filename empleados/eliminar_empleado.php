<?php
include('../sesiones/sesiones.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectarse a la BD
    include("../conexion/conexion.php");

    // Obtener el CURP o RFC del formulario
    $curp_em = $_POST['CURP'];
    $rfc_em = $_POST['RFC'];

    // Sentencia SQL para eliminar un empleado
    if (!empty($curp_em)) {
        $sentencia = "DELETE FROM empleados WHERE CURP = '$curp_em'";
    } elseif (!empty($rfc_em)) {
        $sentencia = "DELETE FROM empleados WHERE RFC = '$rfc_em'";
    } else {
        $mensaje = "Debes proporcionar un CURP o RFC.";
    }

    // Ejecutar la consulta SQL si se ha definido una sentencia
    if (isset($sentencia)) {
        $ejecutar_sql = $conn->query($sentencia);

        if ($ejecutar_sql) {
            $mensaje = "Empleado eliminado con éxito";
        } else {
            $mensaje = "Error al eliminar el empleado";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Empleado</title>
</head>

<body>
    <h1>Eliminar Empleado</h1>

    <form action="eliminar_empleado.php" method="POST">
        <!-- CURP -->
        <label for="curp">CURP:</label>
        <input type="text" id="curp" name="CURP" maxlength="18"><br><br>

        <!-- RFC -->
        <label for="rfc">RFC:</label>
        <input type="text" id="rfc" name="RFC" maxlength="13"><br><br>

        <button type="submit">Eliminar Empleado</button>
    </form>

    <?php
    if (!empty($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>
</body>

</html>