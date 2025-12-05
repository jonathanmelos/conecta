<?php
include 'conexion.php';

date_default_timezone_set('America/Guayaquil');
$sql = "SELECT * FROM registro";
$result = mysqli_query($conn,$sql);

$consult = "SELECT * FROM clientes";
$resultado = mysqli_query($conn,$consult);


$entrada = date('Y-m-d');

//solo el registro del día de hoy 
echo $entrada;
 	$sqlFecha = "SELECT * FROM registro WHERE DATE(entrada)='$entrada'";
    $result3 = $conn->query($sqlFecha);
	
$documento2 = "1720859055";
$entrada2 = date('Y-m-d');
$servicio = "cowork";   
	   
 // Create a new SQL query to check if the values exist in the registro table
 $sql2 = "SELECT * FROM registro WHERE documento='$documento2' AND DATE(entrada)='$entrada2
' AND servicio='$servicio'";
    $result2 = $conn->query($sql2);
   

include 'header.php';
?>



<table>
<tr><th>documento</th><th>entrada</th><th>salida</th><th>cantidad</th><th>servicio</th></tr>
<?php
	
	
   
   while($row = mysqli_fetch_assoc($result3)) {
	$servicio = $row['servicio'];
	$documentoC = $row['documento'];
	
		
        if ($documentoC == "1720859055") {
            echo "<tr>";
    echo "<td>" . $documentoC. "</td>";
    echo "<td>" . $row['entrada'] . "</td>";
    echo "<td>" . $row['salida'] . "</td>";
    echo "<td>" . $row['cantidad'] . "</td>";
    echo "<td>" . $servicio . " usando </td>";
    echo "</tr>";
       
    }else{
	    echo "<tr>";
    echo "<td>" . $documentoC. "</td>";
    echo "<td>" . $row['entrada'] . "</td>";
    echo "<td>" . $row['salida'] . "</td>";
    echo "<td>" . $row['cantidad'] . "</td>";
    echo "<td>" . $servicio . " </td>";
    echo "</tr>";
   }
		
	
}
		
	echo "</table>";


 	   
?>
<a href="registro_registro.php">
    <button type="button" class="btn btn-warning">Nuevo registro</button>
</a>	

<div class="container">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Documento</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
       <th scope="col">Horas Cowork</th>
	  <th scope="col">Horas Sala Reuniones</th>
	  <th scope="col">Impresiones</th>
	  <th scope="col">Evento</th>	
		
    </tr>
  </thead>
   <tbody>
	   
	  <?php

	   
    // Check if the query returned any results
    if ($result2->num_rows > 0) {
        // The values were found in the registro table, so run the provided query
        while($row = mysqli_fetch_assoc($resultado)) {
			$documentoCli=$row['documento'];
			echo "<th scope='row'>" . $documentoCli . "</th>";
					
			if($documentoCli==$documentoC){
			echo "<tr class='popper-row'>";
            echo "<th scope='row'>" . $documentoCli . "</th>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['apellido'] . "</td>";

            echo "<td><a href='registro_cowork.php?id=" . $row['documento'] ."'>
            <button class='btn btn-warning'>Registrar Horas</button></a></td>";

            echo "<td><a href='registro_sala.php?id=" . $row['documento'] ."'>
            <button class='btn btn-info'>Registrar Horas Sala</button></a></td>";
            echo "<td><a href='registro_impresion.php?id=" . $row['documento'] . "'>
            <button class='btn btn-info'>Registrar Impresión</button></a></td>";
            echo "<td><a href='registro_evento.php?id=" . $row['documento'] . "'>
            <button class='btn btn-info' >Registar Evento</button></a></td>";
            echo "</tr>";
				
			}
			
			
            
			
			
        }
    } else {
        // The values were not found in the registro table
        echo "No results found";
    }



echo  "<table class='table table-striped'>";
	   
  // Close the statement and connection
    //$stmt->close();
  

mysqli_close($conn); // Cierra la conexión a la base de datos

	?>   	
	
</body>
</html>