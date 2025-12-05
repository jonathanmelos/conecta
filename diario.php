<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fecha = $_GET['fecha'];

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
<!-- Alerta lateral -->
<div id="customAlert" class="custom-alert">
  <h3 class="alert-heading">No lo olvides!</h3>
  <h5 class="text-warning">Registros Pendientes de Aprobación.</h5>
	
<table class="table table-striped" style="font-size: 0.8em;">
        <thead>
            <tr>
                <th>Nombre y Apellido</th>
                <th>Fecha</th>
                <th>Servicio</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $sqlCE = "SELECT clientes.nombre, clientes.apellido, DATE(registro.entrada) as fecha, registro.servicio
            FROM clientes 
            INNER JOIN registro 
            ON clientes.documento = registro.documento
            WHERE registro.estado = 'C' AND registro.concluido = 1
            ORDER BY registro.entrada DESC";

            $result = $conn->query($sqlCE);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"]." ".$row["apellido"] . "</td>";
                    echo "<td><a href='diario.php?fecha=".$row["fecha"]."'>" . $row["fecha"] . "</a></td>";
                    echo "<td>" . $row["servicio"] . "</td>";
                    echo "</tr>";
                }
            } 
            ?>
        </tbody>
    </table>


  <hr>
  <h5 class="text-danger">Registros no conluidos.</h5>
	
<table class="table table-striped" style="font-size: 0.8em;">
        <thead>
            <tr>
                <th>Nombre y Apellido</th>
                <th>Fecha</th>
                <th>Servicio</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $sqlCE = "SELECT clientes.nombre, clientes.apellido, DATE(registro.entrada) as fecha, registro.servicio
            FROM clientes 
            INNER JOIN registro 
            ON clientes.documento = registro.documento
            WHERE registro.estado = 'C' AND registro.concluido = 0
            ORDER BY registro.entrada DESC";

            $result = $conn->query($sqlCE);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"]." ".$row["apellido"] . "</td>";
                    echo "<td><a href='diario.php?fecha=".$row["fecha"]."'>" . $row["fecha"] . "</a></td>";
                    echo "<td>" . $row["servicio"] . "</td>";
                    echo "</tr>";
                }
            } 
            ?>
        </tbody>
    </table>
  <button type="button" class="btn-close" aria-label="Close"></button>
</div>

<div class="container">
	
	
		<h4 class="mb-3"> CLIENTES COWORK DIARIO</h4>
	
<form action="diario.php" method="get">
	<div class="input-group mb-3">
    <label for="inputText3" class="col-sm-2 col-form-label" >Día:</label>
    
      <input type="date" class="form-control" id="inputText3" placeholder="fecha" name="fecha" value="<?php echo $fecha?>">  <div class="input-group-append">
		<input type="submit" class="btn btn-primary btn-lg " value="Consultar">
      </div>	
	
  
</div>	
  </div>
	
</form>	
<table class="table table-striped">
  <thead>
    <tr>
	  <th scope="col" class="col-3">Nombre y Apellido </th>
      <th scope="col">Telefono</th>
        <th scope="col">Entrada</th>   
		<th scope="col">Salida</th>
		<th scope="col">Horas Usadas</th> 
		<th scope="col">Servicio</th>
		<th scope="col">Impresiones</th>
		<th scope="col">Modificar</th>   
		<th scope="col">Eliminar</th>
		<th scope="col">Aprobar</th>
		
    </tr>
  </thead>
  <tbody>
    <?php
//meta consulta de registros por concluirs botones cowork 
	
$sqlCE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.entrada) = '$fecha' AND registro.servicio = 'cowork' AND registro.concluido = '0'
AND registro.estado = 'C'
ORDER BY registro.documento";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$impresiones=$row['cantidad'];
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
	echo "<td>".$impresiones."</td>";	
	echo "<td><a href='registro_modificar.php?sec=" . $secuencial . "&fecha=".$fecha."'>
            <button class='btn btn-warning' >Modificar</button></a></td>";	
	echo "<td><a href='registro_eliminar.php?sec=" . $secuencial . "&fecha=".$fecha."'>
            <button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "<td>
            <button class='btn btn-daner' >concluir</button></td>";	
    echo "</tr>";
 }  
	
}

//meta consulta de registros concluidos botones cowork 
			 
$sqlCS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.salida) = '$fecha' AND registro.servicio = 'cowork' AND registro.concluido = '1'
AND registro.estado = 'C'
ORDER BY registro.documento";
	
$resultCS = mysqli_query($conn,$sqlCS);
	  
	  while($row = mysqli_fetch_assoc($resultCS)) {
	$impresiones=$row['cantidad'];
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
	echo "<td>".$impresiones."</td>";		
	echo "<td><a href='registro_modificar.php?sec=" . $secuencial ."&fecha=".$fecha."'>
            <button class='btn btn-warning' >Modificar</button></a></td>";	
	echo "<td><a href='registro_eliminar.php?sec=" . $secuencial . "&hora=".$horas_formateado."&fecha=".$fecha."'>
            <button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "<td><a href='registro_aprobar.php?sec=" . $secuencial . "&hora=".$horas_formateado."&fecha=".$fecha."'>
            <button class='btn btn-success' >Por Aprobar</button></a></td>";	
    echo "</tr>";
 }     
	
}
			 
//meta consulta de registros por concluirse botones sala
			 
$sqlSE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.entrada) = '$fecha' AND registro.servicio = 'sala' AND registro.concluido = '0'
AND registro.estado = 'C'
ORDER BY registro.documento";
	
$resultSE = mysqli_query($conn,$sqlSE);	  
while($row = mysqli_fetch_assoc($resultSE)) {
	$impresiones=$row['cantidad'];
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
	$secuencial = $row['secuencial_R'];
	
	
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
	echo "<td>".$impresiones."</td>";		
	echo "<td><a href='registro_modificar.php?sec=" . $secuencial . "&fecha=".$fecha."'>
            <button class='btn btn-warning' >Modificar</button></a></td>";	
	echo "<td><a href='registro_eliminar.php?sec=" . $secuencial . "&fecha=".$fecha."'>
	
            <button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "<td>
            <button class='btn btn-daner' >concluir</button></td>";		
    echo "</tr>";
 }  
	
}

//meta consulta de registros concluidos botones sala
			 
$sqlSS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE DATE(registro.salida) = '$fecha' AND registro.servicio = 'sala' AND registro.concluido = '1'
AND registro.estado = 'C'
ORDER BY registro.documento";
	
$resultSS = mysqli_query($conn,$sqlSS);
	  
	  while($row = mysqli_fetch_assoc($resultSS)) {
	$impresiones=$row['cantidad'];
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
	echo "<td>".$impresiones."</td>";		
	echo "<td><a href='registro_modificar.php?sec=" . $secuencial . "&fecha=".$fecha."'>
            <button class='btn btn-warning' >Modificar</button></a></td>";	
	echo "<td><a href='registro_eliminar.php?sec=" . $secuencial . "&hora=".$horas_formateado."&fecha=".$fecha."'>
            <button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "<td><a href='registro_aprobar.php?sec=" . $secuencial . "&hora=".$horas_formateado."&fecha=".$fecha."'>
            <button class='btn btn-success' >Por Aprobar</button></a></td>";	
			
    echo "</tr>";
 }     
	
}	  
	  
	?>
	  </tbody>
</table>
			
</div>    
    </body>
	   
</html>
<?php 
mysqli_close($conn);
include 'footer.php'; ?>
	