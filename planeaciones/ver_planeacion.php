<?php
          include_once("conectar.php");
 
          $consulta="select id_planeacion,nom_archivo,size_arch,ruta,extension from planeaciones";
          $resultado=$con->query($consulta);  
          echo "<br><h3 align=center> Planeaciones</h3>";
          echo "<hr>";
          echo "<table align=center border=1>";
          echo "<tr>";
          echo "<td>No.</td>";
          echo "<td>Planeacion</td>";   
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

            echo "<a href='subir_file.php'><h3 align=center >Volver</h3></a>";
?>

