<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');

include('../sesiones/sesiones.php');

// Consulta para obtener los campos específicos de los usuarios activos
$sql = "SELECT email, privilegio, estatus FROM usuarios WHERE estatus = 1;";
$result = $conn->query($sql);

// Procesar eliminación si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_email'])) {
    $email = $_POST['delete_email'];
    $delete_sql = "UPDATE usuarios SET estatus = 0 WHERE email = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $email);
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
    <title>Gestión de Usuarios</title>
    <!-- link para los iconos de acciones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="contenedor">
        <div>
            <h1 id="G_usuarios">Gestión de Usuarios</h1>
            <a href="registro_user.php">
                + Añadir Usuario
            </a>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Privilegio</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["privilegio"]) . "</td>";
                            echo "<td>";
                            // Mostrar 'Activo' si el estatus es 1
                            echo ($row["estatus"] == 1) ? "Activo" : "Inactivo";
                            echo "</td>";
                            echo "<td>";
                            echo "<div>";
                            // Botón Editar
                            echo "<a href='mod_user.php?email=" . urlencode($row["email"]) . "'>";
                            echo "<i class='fa fa-edit'></i>";
                            echo "</a>";
                            // Botón Eliminar
                            echo "<form method='POST' class='inline' onsubmit='return confirm(\"¿Está seguro de eliminar este usuario?\")'>";
                            echo "<input type='hidden' name='delete_email' value='" . htmlspecialchars($row["email"]) . "'>";
                            echo "<button type='submit'>";
                            echo "<i class='fa fa-trash'></i>";
                            echo "</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
