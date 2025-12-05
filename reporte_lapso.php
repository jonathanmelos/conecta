<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fecha_i = $_GET['fecha_i'];
$fecha = $_GET['fecha'];
$busqueda = $_GET['busqueda'];
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
?>

<div class="container">
		
	
<form action="reporte_lapso.php" method="get">
	<div class="input-group mb-3">
    <label for="inputText3" class="col-sm-2 col-form-label" >Desde:</label>
      <input type="date" class="form-control" id="inputText3" placeholder="fecha_i" name="fecha_i" value="<?php echo $fecha_i?>"> &nbsp;&nbsp;&nbsp;&nbsp; 
	<label for="inputText3" class="col-sm-2 col-form-label" >Hasta:</label>	
	 <input type="date" class="form-control" id="inputText3" placeholder="fecha" name="fecha" value="<?php echo $fecha?>"> 	&nbsp;&nbsp;&nbsp;&nbsp; 
		
  <select class="form-control" id="inputGroupSelect04" name="busqueda">
    <option >Selecciona &#8659</option>
    <option value="reg">Registros</option>
    <option value="plan">Planes</option>
    </select>
  <div class="input-group-append">
    <input type="submit" class="btn btn-primary " value="Consultar">
  </div>
</div>	 
		
     
		</div>	
</form>		
  



    <?php
	if ($busqueda=="reg"){
		
		echo "
	<h4 class='mb-3'>  Registros por fecha</h4>	
		
<table class='table table-striped'>
  <thead>
    <tr>
	  <th scope='col' class='col-3'>Nombre y Apellido </th>
      <th scope='col'>Fecha</th>
        <th scope='col'>Entrada</th>   
		<th scope='col'>Salida</th>
		<th scope='col'>Uso</th>
		<th scope='col'>Servicio</th>
		<th scope='col'>Impresión</th>
		<th scope='col'>Estado</th>
		
				
    </tr>
  </thead>
  <tbody>";
	
		
$sqlCE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.estado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.entrada) BETWEEN '$fecha_i' AND  '$fecha'  AND registro.servicio = 'cowork' 
ORDER BY registro.documento";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];	  
	$entradaHora = date('H:i:s', strtotime($entrada2));	 
	$fecha_EN = date('d/m/Y', strtotime($entrada2));	
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));
	$secuencial = $row['secuencial_R'];
	$telefono=$row['telefono'];
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$estadoBD=$row['estado'];	
//diferencia tiempo uso 
$entrada_dt = DateTime::createFromFormat('H:i:s', $entradaHora);
$salida_dt = DateTime::createFromFormat('H:i:s', $salidaHora);
$diferencia = $entrada_dt->diff($salida_dt);
$horas = $diferencia->format('%h');
$minutos = $diferencia->format('%i');
$segundos = $diferencia->format('%s');
$usos = $horas * 3600 + $minutos * 60 + $segundos;
$uso = gmdate('H:i:s', $usos);	
	

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
	echo "<td>$fecha_EN</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>".$salidaHora." </td>";	
	echo "<td>".$uso." </td>";	
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
WHERE DATE(registro.entrada) BETWEEN '$fecha_i' AND  '$fecha'  AND registro.servicio = 'sala' 
ORDER BY registro.documento";
	
$resultSE = mysqli_query($conn,$sqlSE);	  
while($row = mysqli_fetch_assoc($resultSE)) {
	$impresion=$row['cantidad'];
	$id=$row['secuencial_R'];
	$documento = $row['documento'];
	$entrada = $row['entrada'];
	$entrada2 = $row['entrada'];
	$fecha_EN = date('d/m/Y', strtotime($entrada2));
	$entradaHora = date('H:i:s', strtotime($entrada2));	  
	$salida = $row['salida'];
	$salida2 = $row['salida'];	  
	$salidaHora = date('H:i:s', strtotime($salida2));
	$telefono=$row['telefono'];
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$estadoBD=$row['estado'];	
	//diferencia tiempo uso 
$entrada_dt = DateTime::createFromFormat('H:i:s', $entradaHora);
$salida_dt = DateTime::createFromFormat('H:i:s', $salidaHora);
$diferencia = $entrada_dt->diff($salida_dt);
$horas = $diferencia->format('%h');
$minutos = $diferencia->format('%i');
$segundos = $diferencia->format('%s');
$usos = $horas * 3600 + $minutos * 60 + $segundos;
$uso = gmdate('H:i:s', $usos);	
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
	echo "<td>".$fecha_EN."</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>".$salidaHora. "</td>";	
	echo "<td>".$uso." </td>";		
    echo "<td>sala</td>";	
	echo "<td>".$impresion."</td>";		
	echo "<td>".$estadoBDI."</td>";
    echo "</tr>";
 }  
	
}
	  
	  
	  
	echo "</tbody></table>";
}
			 elseif($busqueda=="plan"){
		
		echo "
		<h4 class='mb-3'>  Planes  por fecha</h4>	
<table class='table table-striped'>
  <thead>
    <tr>
	  <th scope='col' class='col-3'>Nombre y Apellido </th>
        <th scope='col'>Fecha Inicio</th>   
		<th scope='col'>Fecha Concluye</th>
		<th scope='col'>Plan</th>
		<th scope='col'>Precio</th>
		
				
    </tr>
  </thead>
  <tbody>";
	
	
$sqlCE ="SELECT clientes.nombre AS nombre_cliente, clientes.apellido, planes_registro.fecha_i, planes_registro.fecha_f, planes.nombre AS nombre_plan, planes.precio 
FROM planes_registro 
INNER JOIN clientes 
ON planes_registro.documento = clientes.documento 
INNER JOIN planes ON planes_registro.codigo = planes.codigo 
WHERE DATE(planes_registro.fecha_i) BETWEEN '$fecha_i' AND '$fecha' ORDER BY 
`planes_registro`.`fecha_i` ASC;";			 
				 
				 
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$nombre=$row['nombre_cliente'];
	$apellido=$row['apellido'];
	$fecha_i = $row['fecha_i'];
	$fecha_f = $row['fecha_f'];
	$plan_n = $row['nombre_plan'];	
	$plan_p = $row['precio'];
	//diferencia tiempo uso 
$entrada_dt = DateTime::createFromFormat('H:i:s', $entradaHora);
$salida_dt = DateTime::createFromFormat('H:i:s', $salidaHora);
$diferencia = $entrada_dt->diff($salida_dt);
$horas = $diferencia->format('%h');
$minutos = $diferencia->format('%i');
$segundos = $diferencia->format('%s');
$usos = $horas * 3600 + $minutos * 60 + $segundos;
$uso = gmdate('H:i:s', $usos);		
	

    echo "<tr>";
    echo "<td>" . $nombre . "&nbsp;".$apellido . "<br>";		
   		"</td>";
    echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$fecha_i ."</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>".$fecha_f." </td>";	
	echo "<td>".$uso." </td>";	
	echo "<td>".$plan_n."</td>";		
	echo "<td>".$plan_p."</td>";	
	echo "</tr>";
 
	
}				 
				 
	echo "</tbody></table>";		 
		
	}		
	?>
	
	

			
</div>    
    </body>
	   
</html>
<?php 
mysqli_close($conn);
include 'footer.php'; ?>
	