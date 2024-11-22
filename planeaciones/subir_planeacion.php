<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  { 
    if ($_FILES['archivo']['name'] != "" && $_FILES['archivo']['size'] != 0)
      { 
        $nom_file=$_FILES['archivo']['name'];
        $size_arch=$_FILES['archivo']['size'];
        $extencion_arch=pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        $directorio=pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
        $ruta_file=$directorio."../files/".$nom_file;

        if ( ($extencion_arch=="doc") || ($extencion_arch=="docx") || ($extencion_arch=="pdf") || ($extencion_arch=="xls") || ($extencion_arch=="xlsx"))
            { 
          
              //funcion para subir el archivo al servidor
              $archivo_upload=move_uploaded_file ($_FILES['archivo']['tmp_name'], "files/".$nom_file);

              if ($archivo_upload)
              {
                
                require_once("../conexion/conexion.php");
                $consulta = "INSERT INTO planeaciones 
                (subido_por, docente_encargado, nombre_materia, grado, periodo, fecha_creacion, hora_creacion, archivo, aprobacion, aprobado_por, estatus, nom_arch, size_arch, ruta, extencion) 
                VALUES 
                (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$nom_file', '$size_arch', '$ruta_file', '$extencion_arch')";
            
                //ejecutar la consulta en mysqli procedimental
                $resultado=$conn->query($consulta);
                 

                //Enviar al control al archivo visualizar 
                if($resultado) 
                  {
                    echo "<script> alert('Planeacion agregada');
                                        location.href='ver_planeacion.php'; 
                          </script> ";
                  } 
                else 
                  {
                    echo "<script> alert('Error al agregar Planeacion, verifique por favor ...'); 
                                </script> ";
                  }

              }
              else
              {
                echo "<script> alert('No se ha podido copiar el archivo al servidor');</script>";
              }

                    
            }
        } 
    else 
     {  
        echo "<script> alert('No se ha seleccionado un archivo para SUBIR');</script>"; 
     }  

}
?>
<!DOCTYPE html>
<html>  
<head>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subir Planeacion</title>
  <link rel="stylesheet" href="../estilos.css">
</head>
<body>
  <!-- Barra de navegación -->
  <nav class="navbar">
    <div class="navbar-left">
      <button class="menu-toggle" id="menu-toggle">☰</button>
      <ul class="navbar-menu" id="navbar-menu">
        <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
        <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
        <li><a href="../constancias/constancias.php" class="navbar-link">Constancias</a></li>
      </ul>
    </div>
    <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
  </nav>
  
  <div class="plan-container">
    <div class="plan-header">
      <h3 class="plan-title">Subir Planeacion</h3>
    </div>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
      <table class="plan-table">
        <tr>
          <td>Seleccionar Archivo</td>
          <td>
            <input name="archivo" type="file" class="file-input">  
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button type="submit" name="enviar" class="plan-button">Subir</button>
            <button type="reset" name="borrar" class="plan-button plan-reset">Cancelar</button>
          </td>
        </tr>
      </table>
      <input type="hidden" name="us" value="<?php echo $us; ?>">
      <input type="hidden" name="ps" value="<?php echo $ps; ?>">
    </form>
    <hr>
    <a href="ver_planeacion.php" class="plan-link">Ver Planeaciones</a>
  </div>
</body>
</html>
