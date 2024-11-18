<?php
include('../sesiones/sesiones.php');

$mensaje = "";

// 1.- Conectarse a la BD
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    $email_us = $_GET['email'];

    // Consultar datos del usuario
    $consulta_sql = "SELECT * FROM usuarios WHERE email = '$email_us'";
    $resultado = mysqli_query($conn, $consulta_sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $usuario = $fila;
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email_us = $_POST['email'];
    $privilegio_us = $_POST['privilegio']; // Corregido: nombre del campo
    $estatus_us = isset($_POST['estatus']) ? 1 : 0;  // El campo estatus será 1 si está marcado

    // Actualizar los datos del usuario
    $sentencia = "UPDATE usuarios SET 
        privilegio = '$privilegio_us', 
        estatus = '$estatus_us' 
        WHERE email = '$email_us'"; // Corregido: quitar coma extra

    if (mysqli_query($conn, $sentencia)) {
        $mensaje = "Datos del usuario actualizados con éxito.";
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
    <title>Modificar Usuario</title>
    <script>
        window.onload = function() {
            <?php if (!empty($mensaje)) { ?>
                alert("<?php echo $mensaje; ?>");
                window.location.href = "gestion_user.php";
            <?php } ?>
        };
    </script>
</head>

<body>
    <h1>Modificar Usuario</h1>
    <form action="mod_user.php" method="POST">
        <!-- Campos del formulario -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email'] ?? ''; ?>" readonly><br>

        <!-- este campo debe de contener varias elecciones como el de docente, secretaria, etc -->
        <label for="privilegio">Privilegio:</label>
        <select name="privilegio" id="privilegio"> <!-- Corregido: nombre del campo -->
            <option value="docente" <?php echo ($usuario['privilegio'] == 'docente' ? 'selected' : ''); ?>>Docente</option>
            <option value="secretaria" <?php echo ($usuario['privilegio'] == 'secretaria' ? 'selected' : ''); ?>>Secretaria</option>
            <option value="directivo" <?php echo ($usuario['privilegio'] == 'directivo' ? 'selected' : ''); ?>>Directivo</option>
            <option value="admin" <?php echo ($usuario['privilegio'] == 'admin' ? 'selected' : ''); ?>>Admin</option>
        </select><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>
