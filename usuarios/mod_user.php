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
    $privilegio_us = $_POST['privilegio'];

    // Encriptar la nueva contraseña si se proporciona
    $pass_us = $_POST['pass'];
    $set_password = "";
    if (!empty($pass_us)) {
        $pass_hash = password_hash($pass_us, PASSWORD_DEFAULT); // Encriptar
        $set_password = "contrasena = '$pass_hash', ";
    }

    // Actualizar los datos del usuario
    $sentencia = "UPDATE usuarios SET 
        $set_password
        privilegio = '$privilegio_us' 
        WHERE email = '$email_us'";

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
    <link rel="stylesheet" href="../estilos.css">
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
    <nav class="navbar" id="navbar">
        <div class="navbar-left" id="navbar-left">
            <button class="menu-toggle" id="menu-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <li><a href="../empleados/tabla2.php" class="navbar-link">Gestión de empleados</a></li>
                <li><a href="../usuarios/gestion_user.php" class="navbar-link">Gestión de usuarios</a></li>
                <li><a href="../empleados/bajas.php" class="navbar-link">Empleados dados de baja</a></li>
            </ul>
        </div>
        <a href="../sesiones/logout.php" class="logout-link" id="logout-link">Cerrar sesión</a>
    </nav>

    <div class="user-form-container moduser">
        <h1 class="user-form-title">Modificar Usuario</h1>
        <form class="user-form" action="mod_user.php" method="POST">
            <!-- Campos del formulario -->
            <label for="email" class="user-form-label">Email:</label>
            <input type="email" name="email" value="<?php echo $usuario['email'] ?? ''; ?>" class="user-input-field" readonly><br>

            <!-- Campo de contraseña -->
            <label for="pass" class="user-form-label">Nueva Contraseña:</label>
            <input type="text" name="pass" placeholder="Dejar en blanco para no cambiar" class="user-input-field"><br>

            <!-- Campo de privilegio con opciones -->
            <label for="privilegio" class="user-form-label">Privilegio:</label>
            <select name="privilegio" id="privilegio" class="user-input-field">
                <option value="docente" <?php echo ($usuario['privilegio'] == 'docente' ? 'selected' : ''); ?>>Docente</option>
                <option value="secretaria" <?php echo ($usuario['privilegio'] == 'secretaria' ? 'selected' : ''); ?>>Secretaria</option>
                <option value="directivo" <?php echo ($usuario['privilegio'] == 'directivo' ? 'selected' : ''); ?>>Directivo</option>
                <option value="admin" <?php echo ($usuario['privilegio'] == 'admin' ? 'selected' : ''); ?>>Admin</option>
            </select><br>

            <button type="submit" class="user-submit-button">Guardar Cambios</button>
            <br>
            <p><a href="../pagina/inicio.php" class="user-navbar-link">volver al inicio</a></p>
        </form>
    </div>
</body>

</html>