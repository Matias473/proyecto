<!-- se añadieron alertas en este caso -->

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

    // Desactivar las excepciones de MySQLi
    mysqli_report(MYSQLI_REPORT_OFF);

    $sentencia = "INSERT INTO usuarios (email, contrasena, privilegio, estatus) VALUES ('$email', '$password', '$privi', '$status')";

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
    <script>
        window.onload = function () {
            <?php if (!empty($mensaje)) { ?>
                alert("<?php echo $mensaje; ?>");
            <?php } ?>
        };
    </script>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="registro_user.php" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($_POST['contrasena'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <label for="privilegio">Privilegio:</label>
        <input type="text" id="privilegio" name="privilegio" value="<?php echo htmlspecialchars($_POST['privilegio'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <button type="submit">Registrar Usuario</button>
    </form>
</body>
</html>
