<?php
          include_once("conectar.php");
 
          $consulta="select id_planeacion, subido_por, docente_encargado, nombre_materia, grado, periodo, fecha_creacion, hora_creacion, archivo, aprobacion, aprobado_por, estatus, nom_arch, size_arch, ruta, extencion from planeaciones";
          $resultado=$con->query($consulta);  
          echo "<br><h3 align=center> Planeaciones</h3>";
          echo "<hr>";
          echo "<table align=center border=1>";
          echo "<tr>";
          echo "<td>#</td>";
          echo "<td>Subido Por</td>";
          echo "<td>Docente</td>"; 
          echo "<td>Materia</td>"; 
          echo "<td>Grado</td>";
          echo "<td>Periodo</td>"; 
          echo "<td>Fecha</td>"; 
          echo "<td>Hora</td>"; 
          echo "<td>Archivo</td>"; 
          echo "<td>Aprobacion</td>"; 
          echo "<td>Aprobado Por</td>"; 
          echo "<td>Estatus</td>"; 
          echo "<td>Archivo</td>"; 
          echo "<td>Tamaño</td>";
          echo "<td>Ruta</td>";
          echo "<td>Extensión</td>";
          echo "<td>Acciones</td>";
          echo "</tr>";
        
         while ($fila=$resultado->fetch_assoc()) 
            {
              echo "<tr>";
              echo "<td>".$fila['id_planeacion'] ."</td><td>".$fila['nom_archivo']."</td><td>".$fila['size_arch']."</td>";
              echo "<td><a href = ".$fila['ruta']." target='_blank'>".$fila['ruta']."</a></td>";
              echo "<td>".$fila['extension'] ."</td>";
              echo "<td><a href = eliminar_planeacion.php?id_planeacion=".$fila['id_planeacion'].">Eliminar</a></td>";
              echo "</tr>";
            }
            echo "</table>";
            echo "<hr>";

            echo "<a href='subir_planeacion.php'><h3 align=center >Volver</h3></a>";
?>

