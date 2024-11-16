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
    
    // Sentencia SQL para insertar un empleado
    $sentencia = "INSERT INTO empleados 
    (CURP, RFC, titulo, nombres, apellido_p, apellido_m, sexo, fecha_nacimiento, email, telefono_movil, telefono_fijo, estado_civil, CP, col_fracc, calle, numero, fecha_contrato, puesto, turno, horario_entrada, horario_salida, estatus) VALUES ('$curp_em', '$rfc_em', '$titulo_em', '$nombres_em', '$apellido_p_em', '$apellido_m_em', '$sexo_em', '$fecha_nacimiento_em', '$email_em', '$telefono_movil_em', '$telefono_fijo_em', '$estado_civil_em', '$cp_em', '$col_fracc_em', '$calle_em', '$numero_em', '$fecha_contrato_em', '$puesto_em', '$turno_em', '$horario_entrada_em', '$horario_salida_em', '$estatus_em')";
    
    // Ejecutar la consulta SQL
    $ejecutar_sql = $conn->query($sentencia);

    if ($ejecutar_sql) {
        $entrar = "insertar";
        $mensaje = "Empleado registrado con éxito";
        header('location: ../pagina/inicio.php');
    } else {
        $entrar = "noinsertar";
        $mensaje = "Error al registrar el empleado";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registro empleado</title>
</head>

<body>
    <h1>formulario de registro de empleados</h1>

    <form action="registrar_empleado.php" method="POST">
        <!-- CURP -->
        <label for="curp">CURP:</label>
        <input type="text" id="curp" name="CURP" maxlength="18" required><br><br>

        <!-- RFC -->
        <label for="rfc">RFC:</label>
        <input type="text" id="rfc" name="RFC" maxlength="13" required><br><br>

        <!-- Título -->
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" maxlength="15"><br><br>

        <!-- Nombres -->
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required><br><br>

        <!-- Apellido Paterno -->
        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" require><br><br>

        <!-- Apellido Materno -->
        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m"><br><br>

        <!-- Sexo (Checkbox) -->
        <label for="sexo">Sexo:</label>
        <input type="radio" id="sexo_m" name="sexo" value="M"> Masculino
        <input type="radio" id="sexo_f" name="sexo" value="F"> Femenino<br><br>

        <!-- Fecha de Nacimiento -->
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"><br><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <!-- Teléfono Móvil -->
        <label for="telefono_movil">Teléfono Móvil:</label>
        <input type="text" id="telefono_movil" name="telefono_movil" require><br><br>

        <!-- Teléfono Fijo -->
        <label for="telefono_fijo">Teléfono Fijo:</label>
        <input type="text" id="telefono_fijo" name="telefono_fijo"><br><br>

        <!-- Estado Civil (Select) -->
        <label for="estado_civil">Estado Civil:</label>
        <select id="estado_civil" name="estado_civil">
            <option value="soltero">Soltero</option>
            <option value="casado">Casado</option>
            <option value="viudo">Viudo</option>
        </select><br><br>

        <!-- Código Postal -->
        <label for="cp">Código Postal:</label>
        <input type="text" id="cp" name="CP" maxlength="5" require><br><br>

        <!-- Colonia / Fraccionamiento -->
        <label for="col_fracc">Colonia/Fraccionamiento:</label>
        <input type="text" id="col_fracc" name="col_fracc" require><br><br>

        <!-- Calle -->
        <label for="calle">Calle:</label>
        <input type="text" id="calle" name="calle"><br><br>

        <!-- Número -->
        <label for="numero">Número:</label>
        <input type="text" id="numero" name="numero"><br><br>

        <!-- Fecha de Contrato -->
        <label for="fecha_contrato">Fecha de Contrato:</label>
        <input type="date" id="fecha_contrato" name="fecha_contrato" required><br><br>

        <!-- Puesto (Select) -->
        <label for="puesto">Puesto:</label>
        <select id="puesto" name="puesto">
            <option value="docente">Docente</option>
            <option value="administrativo">Administrativo</option>
            <option value="secretaria">Secretaria</option>
        </select><br><br>

        <!-- Turno -->
        <label for="turno">Turno:</label>
        <input type="text" id="turno" name="turno" required><br><br>

        <!-- Horario de Entrada -->
        <label for="horario_entrada">Horario de Entrada:</label>
        <input type="time" id="horario_entrada" name="horario_entrada" required><br><br>

        <!-- Horario de Salida -->
        <label for="horario_salida">Horario de Salida:</label>
        <input type="time" id="horario_salida" name="horario_salida" required><br><br>

        <button type="submit">Guardar Empleado</button>
    </form>

</body>

</html>