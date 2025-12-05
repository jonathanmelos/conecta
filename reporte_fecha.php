<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fecha = $_GET['fecha'];
$estado = $_GET['estado'];

// Obtener los valores de los campos de entrada
$documentoJSON = isset($_GET['documento']) ? $_GET['documento'] : '';
$nombreJSON = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellidoJSON = isset($_GET['apellido']) ? $_GET['apellido'] : '';

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparar una sentencia SQL para buscar en la tabla clientes
$stmt = $conn->prepare("SELECT documento, nombre, apellido FROM clientes WHERE documento LIKE CONCAT('%', ?, '%') AND nombre LIKE CONCAT('%', ?, '%') AND apellido LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("sss", $documentoJSON, $nombreJSON, $apellidoJSON);

// Ejecutar la sentencia SQL
$stmt->execute();

// Vincular el resultado a variables
$stmt->bind_result($documentoJSONR, $nombreJSONR, $apellidoJSONR);

// Crear un arreglo para almacenar los resultados
$results = [];

// Obtener todos los resultados
while ($stmt->fetch()) {
    // Agregar el resultado al arreglo
    $resultsJSON[] = [
        'documento' => $documentoJSONR,
        'nombre' => $nombreJSONR,
        'apellido' => $apellidoJSONR,
    ];
}

$json = json_encode($resultsJSON);

// Cerrar la sentencia y la conexión
$stmt->close();

// Decodificar el contenido del archivo JSON
$datos = json_decode($json, true);


include 'header.php'; 


// consulta total horas cowork diarias


$sqlCW = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(hora))) AS total_horas 
        FROM `horas` 
        WHERE `fecha` LIKE '%$fecha%' AND `servicio` = 'COWORK'";

$result = $conn->query($sqlCW);

$result->num_rows > 0;
$row = $result->fetch_assoc();
$totalDiaCowork = $row['total_horas'];

// consulta total horas sala  diarias


$sqlSALA = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(hora))) AS total_horas 
        FROM `horas` 
        WHERE `fecha` LIKE '%$fecha%' AND `servicio` = 'SALA'";

$resultS = $conn->query($sqlSALA);

$resultS->num_rows > 0;
$rowS = $resultS->fetch_assoc();
$totalDiaSala = $rowS['total_horas'];

?>

<div class="container">
		<h4 class="mb-3"> CLIENTES COWORK DIARIO</h4>
	
<form action="reporte_fecha.php" method="get">
	<div class="input-group mb-3">
    <label for="inputText3" class="col-sm-2 col-form-label" >Día:</label>
    <input type="hidden" name="estado" value="%" >
      <input type="date" class="form-control" id="inputText3" placeholder="fecha" name="fecha" value="<?php echo $fecha?>">  <div class="input-group-append">
		 
		<input type="submit" class="btn btn-primary btn-lg " value="Consultar">
      </div>	
</form>		
  
</div>	
	<div class="d-flex justify-content-center">
	<div class="input-group mb-3">
		<div class="row">
    <div class="col-md-6 col-lg-2"> 
		<a href="reporte_fecha.php?estado=%&fecha=<?php echo $fecha ?>">
        <button class="btn btn-outline-info" >TODOS</button></a></td> 
	</div>
	  
	<div class="col-md-6 col-lg-3"> 
		<a href="reporte_fecha.php?estado=A&fecha=<?php echo $fecha ?>">
        <button class="btn btn-outline-success" >APROBADOS</button></a></td> 
	</div>
	<div class="col-md-6 col-lg-4"> 
		<a href="reporte_fecha.php?estado=C&fecha=<?php echo $fecha ?>">
        <button class="btn btn-outline-warning" >POR APROBAR</button></a></td> 
	</div>
	<div class="col-md-6 col-lg-3"> 
		<a href="reporte_fecha.php?estado=E&fecha=<?php echo $fecha ?>">
        <button class="btn btn-outline-danger" >ELIMINADOS</button></a></td> 
	</div>
  </div>
  </div>
</div>


<table class="table table-striped">
  <thead>
    <tr>
	  <th scope="col" class="col-3">Nombre y Apellido </th>
      <th scope="col">Telefono</th>
        <th scope="col">Entrada</th>   
		<th scope="col">Salida</th>
		<th scope="col">Horas Usadas</th> 
		<th scope="col">Servicio</th>
		<th scope="col">Impresión</th>
		<th scope="col">Estado</th>
		
				
    </tr>
  </thead>
  <tbody>
    <?php

$sqlCE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.estado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.entrada) = '$fecha' AND registro.servicio = 'cowork' AND registro.concluido = '0'
AND registro.estado LIKE '$estado'
ORDER BY registro.documento";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];	  
	$entradaHora = date('H:i:s', strtotime($entrada2));	  
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));
	$secuencial = $row['secuencial_R'];
	$telefono=$row['telefono'];
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$estadoBD=$row['estado'];	
	if($estadoBD=="C"){
		$estadoBDI = "POR APROBAR";}
	if($estadoBD=="A"){
		$estadoBDI = "AROBADO";}
	if($estadoBD=="E"){
		$estadoBDI = "ELIMINADO";}
	
	
	if ($entrada = $fecha ){
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td>$telefono</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> en cowork</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>en cowork </td>";	
    echo "<td>cowork</td>";	
	echo "<td>".$impresion."</td>";		
	echo "<td>".$estadoBDI."</td>";	
	echo "</tr>";
	

 }  

}

$sqlCS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.estado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.salida) = '$fecha' AND registro.servicio = 'cowork' AND registro.concluido = '1'
AND registro.estado LIKE '$estado'
ORDER BY registro.documento";
	
$resultCS = mysqli_query($conn,$sqlCS);
	  
	  while($row = mysqli_fetch_assoc($resultCS)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];	  
	$entradaHora = date('H:i:s', strtotime($entrada2));	  
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));
	$secuencial = $row['secuencial_R'];
	$telefono=$row['telefono'];	  
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
    $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
	$estadoBD=$row['estado'];	
	if($estadoBD=="C"){
		$estadoBDI = "POR APROBAR";}
	if($estadoBD=="A"){
		$estadoBDI = "AROBADO";}
	if($estadoBD=="E"){
		$estadoBDI = "ELIMINADO";}  
	
	if ($entrada = $fecha ){
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td>$telefono</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salidaHora. "</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
    echo "<td>cowork</td>";	
	echo "<td>".$impresion."</td>";		
	echo "<td>".$estadoBDI."</td>";		
	
    echo "</tr>";
 }     
	
}

$sqlSE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.estado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.entrada) = '$fecha' AND registro.servicio = 'sala' AND registro.concluido = '0'
AND registro.estado LIKE '$estado'
ORDER BY registro.documento";
	
$resultSE = mysqli_query($conn,$sqlSE);	  
while($row = mysqli_fetch_assoc($resultSE)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];	  
	$entradaHora = date('H:i:s', strtotime($entrada2));	  
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));
	$telefono=$row['telefono'];
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$secuencial = $row['secuencial'];
	$estadoBD=$row['estado'];	
	if($estadoBD=="C"){
		$estadoBDI = "POR APROBAR";}
	if($estadoBD=="A"){
		$estadoBDI = "AROBADO";}
	if($estadoBD=="E"){
		$estadoBDI = "ELIMINADO";}
	
	
	if ($entrada = $fecha ){
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td>$telefono</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> en sala</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>en sala </td>";	
    echo "<td>sala</td>";	
	echo "<td>".$impresion."</td>";		
	echo "<td>".$estadoBDI."</td>";
    echo "</tr>";
 }  
	
}
	  
$sqlSS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.estado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.salida) = '$fecha' AND registro.servicio = 'sala' AND registro.concluido = '1'
AND registro.estado LIKE '$estado'
ORDER BY registro.documento";
	
$resultSS = mysqli_query($conn,$sqlSS);
	  
	  while($row = mysqli_fetch_assoc($resultSS)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];	  
	$entradaHora = date('H:i:s', strtotime($entrada2));	  
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));		  
	$secuencial = $row['secuencial_R'];
	$telefono=$row['telefono'];	  
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
	 $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);	  
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
	$estadoBD=$row['estado'];	
	if($estadoBD=="C"){
		$estadoBDI = "POR APROBAR";}
	if($estadoBD=="A"){
		$estadoBDI = "AROBADO";}
	if($estadoBD=="E"){
		$estadoBDI = "ELIMINADO";}
		  
	if ($entrada = $fecha ){
  echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td>$telefono</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salidaHora. "</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
    echo "<td>sala</td>";	
	echo "<td>".$impresion."</td>";		
	echo "<td>".$estadoBDI."</td>";
			
    echo "</tr>";
 }     
	
}	  
			 
			 
	  ?>
	  </tbody>
</table>
		<button class="btn btn-primary btn-lg " onclick="sumarHoras()">Sumar horas</button>
    <div><h4>Total horas:  <span id="totalHoras"></span> </h4></div>	
</div>    
    </body>
	   
</html>
<?php 
mysqli_close($conn);
include 'footer.php'; ?>
	