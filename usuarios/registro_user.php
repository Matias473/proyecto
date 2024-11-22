<?php
include('../sesiones/sesiones.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectarse a la BD
    include("../conexion/conexion.php");

    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $privi = $_POST['privilegio'];
    $status = 1;

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Desactivar las excepciones de MySQLi
    mysqli_report(MYSQLI_REPORT_OFF);

    $sentencia = "INSERT INTO usuarios (email, contrasena, privilegio, estatus) VALUES ('$email', '$hashed_password', '$privi', '$status')";

    // Intentar ejecutar el query y manejar errores
    $ejecutar_sql = $conn->query($sentencia);

    if ($ejecutar_sql) {
        echo "<script>alert('Registro realizado exitosamente.'); window.location.href = '../pagina/inicio.php';</script>";
    } else {
        if ($conn->errno === 1062) { // Código de error para duplicados
            echo "<script>alert('El correo electrónico ya está registrado. Intente con otro.');</script>";
        } else {
            echo "<script>alert('Error inesperado: no se pudo realizar el registro. Intente nuevamente.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../estilos.css">
    <script>
        window.onload = function () {
            <?php if (!empty($mensaje)) { ?>
                alert("<?php echo $mensaje; ?>");
            <?php } ?>
        };
    </script>
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

    <div class="user-form-container">
    <h2 class="user-form-title" >Registro de Usuario</h2>
    <form action="registro_user.php" method="post" class="user-form">
        <label for="email" class="user-form-label">Correo Electrónico:</label>
        <input type="text" id="email" name="email" class="user-input-field" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <label for="contrasena" class="user-form-label">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" class="user-input-field" value="<?php echo htmlspecialchars($_POST['contrasena'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <label for="privilegio" class="user-form-label">Privilegio:</label>
<select id="privilegio" name="privilegio" class="user-input-field" required>
    <option value="admin" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
    <option value="docente" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'docente') ? 'selected' : ''; ?>>Docente</option>
    <option value="secretaria" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'secretaria') ? 'selected' : ''; ?>>Secretaria</option>
</select>
<br><br>


        <button type="submit" class="user-submit-button">Registrar Usuario</button>
    </form>
    </div>
</body>
</html>