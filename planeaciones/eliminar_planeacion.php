<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
   
   <meta charset="utf-8">
	<title>Eliminar</title>
</head>

<?php 
	include_once("conectar.php");

	$id_planeacion = $_GET['id_planeacion'];

	// 1. Consulta para obtener el nombre del archivo
	$consulta_archivo = "SELECT nom_arch FROM planeaciones WHERE id_planeacion = '$id_planeacion'";
	$result = mysqli_query($conn, $consulta_archivo);
	
	if ($result && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$nombre_archivo = $row['nom_arch'];
		
	$resultado=$con->query($consulta);

	if ($fila =$resultado->fetch_assoc())
		{

			$borrar_file=unlink("files/".$fila['nom_archivo']);

			$consulta="delete from planeaciones where id_planeacion='$id_planeacion'";
			$resultado=$con->query($consulta);
			
			if ($resultado) 
				{
					echo "<script> alert('Registro eliminado correctamente'); </script> ";
				}
				else 
				{
					echo "<script> alert('Error fallo la eliminación, verifique ...'); </script> ";
				}
				echo "<script> location.href='ver_planeacion.php'; </script> ";

		}
?>