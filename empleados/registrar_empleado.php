<?php
include('../sesiones/sesiones.php');

$entrar = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1.- Conectarse a la BD
    include("../conexion/conexion.php");

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
    $estatus_em = 1; // Asumiendo que el valor de estatus es siempre 1

    // Verificar si la CURP o el RFC ya existen
    $verificar_sql = "SELECT COUNT(*) as total FROM empleados WHERE CURP = '$curp_em' OR RFC = '$rfc_em'";
    $resultado = mysqli_query($conn, $verificar_sql);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila['total'] > 0) {
        $mensaje = "La CURP y/o RFC ya se encuentran en el sistema.";
    } else {
        // Insertar el empleado
        $sentencia = "INSERT INTO empleados 
        (CURP, RFC, titulo, nombres, apellido_p, apellido_m, sexo, fecha_nacimiento, email, telefono_movil, telefono_fijo, estado_civil, CP, col_fracc, calle, numero, fecha_contrato, puesto, turno, horario_entrada, horario_salida, estatus) 
        VALUES ('$curp_em', '$rfc_em', '$titulo_em', '$nombres_em', '$apellido_p_em', '$apellido_m_em', '$sexo_em', '$fecha_nacimiento_em', '$email_em', '$telefono_movil_em', '$telefono_fijo_em', '$estado_civil_em', '$cp_em', '$col_fracc_em', '$calle_em', '$numero_em', '$fecha_contrato_em', '$puesto_em', '$turno_em', '$horario_entrada_em', '$horario_salida_em', $estatus_em)";
        
        if (mysqli_query($conn, $sentencia)) {
            $entrar = "insertar";
            $mensaje = "Empleado registrado con éxito";
        } else {
            $entrar = "noinsertar";
            $mensaje = "Error al registrar el empleado: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Empleado</title>
    <script>
        window.onload = function() {
            <?php if (!empty($mensaje)) { ?>
                alert("<?php echo $mensaje; ?>");
                <?php if ($entrar === "insertar") { ?>
                    setTimeout(function() {
                        window.location.href = "ver_empleado.php?curp=<?php echo $curp_em; ?>";
                    }, 2000);
                <?php } ?>
            <?php } ?>
        };
    </script>
</head>

<body>
    <h1>Formulario de Registro de Empleados</h1>
    <form action="registrar_empleado.php" method="POST">
        <!-- Campos del formulario -->
        <label for="CURP">CURP:</label>
        <input type="text" name="CURP" required><br>

        <label for="RFC">RFC:</label>
        <input type="text" name="RFC" required><br>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo"><br>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required><br>

        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" name="apellido_p" required><br>

        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" name="apellido_m" required><br>

        <label for="sexo">Sexo:</label>
        <input type="text" name="sexo" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="telefono_movil">Teléfono Móvil:</label>
        <input type="text" name="telefono_movil"><br>

        <label for="telefono_fijo">Teléfono Fijo:</label>
        <input type="text" name="telefono_fijo"><br>

        <label for="estado_civil">Estado Civil:</label>
        <input type="text" name="estado_civil"><br>

        <label for="CP">Código Postal:</label>
        <input type="text" name="CP"><br>

        <label for="col_fracc">Colonia/Fraccionamiento:</label>
        <input type="text" name="col_fracc"><br>

        <label for="calle">Calle:</label>
        <input type="text" name="calle"><br>

        <label for="numero">Número:</label>
        <input type="text" name="numero"><br>

        <label for="fecha_contrato">Fecha de Contrato:</label>
        <input type="date" name="fecha_contrato" required><br>

        <label for="puesto">Puesto:</label>
        <input type="text" name="puesto" required><br>

        <label for="turno">Turno:</label>
        <input type="text" name="turno" required><br>

        <label for="horario_entrada">Horario Entrada:</label>
        <input type="time" name="horario_entrada" required><br>

        <label for="horario_salida">Horario Salida:</label>
        <input type="time" name="horario_salida" required><br>

        <button type="submit">Registrar</button>
    </form>
</body>

</html>
