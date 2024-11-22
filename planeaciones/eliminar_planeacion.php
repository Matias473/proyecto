<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
   
   <meta charset="utf-8">
	<title>Eliminar</title>
</head>

<?php 
	include_once("../conexion/conexion.php");

	// Convertir id_planeacion a un número entero
	$id_planeacion = intval($_GET['id_planeacion']);

	// 1. Consulta para obtener el nombre del archivo
	$consulta_archivo = "SELECT nom_arch FROM planeaciones WHERE id_planeacion = ?";
	$stmt = $conn->prepare($consulta_archivo);
	$stmt->bind_param("i", $id_planeacion);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$nombre_archivo = $row['nom_arch'];

		// Ruta completa del archivo
		$ruta_archivo = "files/" . $nombre_archivo;

		// Intentar borrar el archivo físico
		if (file_exists($ruta_archivo)) {
			if (unlink($ruta_archivo)) {
				echo "Archivo eliminado correctamente.";
			} else {
				echo "Error al intentar eliminar el archivo físico.";
			}
		} else {
			echo "El archivo no existe en la carpeta.";
		}

		// 2. Eliminar el registro de la base de datos
		$consulta_delete = "DELETE FROM planeaciones WHERE id_planeacion = ?";
		$stmt_delete = $conn->prepare($consulta_delete);
		$stmt_delete->bind_param("i", $id_planeacion);

		if ($stmt_delete->execute()) {
			echo "<script> alert('Registro eliminado correctamente de la base de datos.'); </script>";
		} else {
			echo "<script> alert('Error al eliminar el registro de la base de datos.'); </script>";
		}
	} else {
		echo "<script> alert('No se encontró el registro solicitado en la base de datos.'); </script>";
	}

	// Redirigir a la página principal
	echo "<script> location.href='ver_planeacion.php'; </script>";
?>