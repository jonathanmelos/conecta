<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fechaActual =  date('Y-m-d');
$documento = $_GET['documento'];
$documento2 = $_GET['documento'];
$sec = $_GET['sec'];
include 'header.php'; 
$fecha =  date('Y-m-d');
		
// Consulta tabla clientes 

$sql = "SELECT * FROM clientes WHERE documento = $documento"; 
$result = mysqli_query($conn,$sql);

 
    $Cli = mysqli_fetch_assoc($result);
	$documentoCLi = $Cli['documento']; 
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 
	$correo = $Cli['correo'];
	$direccion = $Cli['direccion'];
	$telefono = $Cli['telefono'];
	$fechaCli = $Cli['fecha'];

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

?>

<div class="container">
 <div class="row">
    <div class="col-md-7 col-lg-9">
        <h4 class="mb-3">Registros del Plan</h4>
        <form class="needs-validation" novalidate>
          <div class="row g-3">
       <table id="tabla" class="table table-striped">
  <thead>
    <tr>
	  <th scope="col" class="col-3">Cliente </th>
       <th scope="col">Entrada</th>   
		<th scope="col">Salida</th>
		<th scope="col">Horas Usadas</th> 
		<th scope="col">Servicio</th>
		<th scope="col">Imp</th>
		<th scope="col">Estado</th>   
		
    </tr>
  </thead>
	   <?php
//meta consulta de registros por concluirs botones cowork 
	
$sqlCE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes = '$sec' AND registro.servicio = 'cowork' AND registro.concluido = '0'
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

	
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	 echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entradaHora ."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> en cowork</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>en cowork </td>";	
    echo "<td>cowork</td>";	
	echo "<td>".$impresiones."</td>";	
	echo "<td> en uso </td>";	
    echo "</tr>";
 }  
	


//meta consulta de registros concluidos botones cowork 
			 
$sqlCS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes = '$sec' AND registro.servicio = 'cowork' AND registro.concluido = '1'
AND registro.estado = 'A'
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
		  
	
	
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entrada."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salida. "</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
    echo "<td>cowork</td>";	
	echo "<td>".$impresiones."</td>";	
	echo "<td> Concluido y Aprobado</td>";			  
    echo "</tr>";
    
	
}
		
$sqlCS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes = '$sec' AND registro.servicio = 'cowork' AND registro.concluido = '1'
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
		  
	
	
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entrada."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salida. "</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
    echo "<td>cowork</td>";	
	echo "<td>".$impresiones."</td>";	
	echo "<td> Por aprobar </td>";		  
	
    echo "</tr>";
    
	
}
			 		   
//meta consulta de registros por concluirse botones sala
			 
$sqlSE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes = '$sec' AND registro.servicio = 'sala' AND registro.concluido = '0'
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
	
	
	
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entrada2."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> en sala</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>en sala </td>";	
    echo "<td>sala</td>";
	echo "<td>".$impresiones."</td>";
	echo "<td> en uso </td>";
    echo "</tr>";
 
	
}

//meta consulta de registros por concluirse botones sala
			 
$sqlSE = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes = '$sec' AND registro.servicio = 'sala' AND registro.concluido = '1'
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
	
	
	
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "&nbsp;".$row['apellido'] . "<br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " .$entrada."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> en sala</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''>en sala </td>";	
    echo "<td>sala</td>";
	echo "<td>".$impresiones."</td>";
	echo "<td> Por aprobar </td>";
    echo "</tr>";
 
	
}

		   
//meta consulta de registros concluidos botones sala
			 
$sqlSS = "SELECT clientes.nombre, clientes.apellido, clientes.telefono  , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
FROM clientes 
INNER JOIN registro 
ON clientes.documento = registro.documento
WHERE registro.secuencial_planes='$sec' AND registro.servicio = 'sala' AND registro.concluido = '1'
AND registro.estado = 'A'
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
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " ."$entrada2"."</td>";
    echo "<td><img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salida. "</td>";
     echo "<td><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
    echo "<td>sala</td>";
	echo "<td>".$impresiones."</td>";	
	echo "<td> Concluido y Aprobado</td>";	

			
    echo "</tr>";
 }     
	
}	  
$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento2' AND  planes_registro.secuencial_planes = '$sec';";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
$row = mysqli_fetch_assoc($resultCE);
	
	//tabla registro_planes
	$sec=$row['secuencial_planes'];
	$doc=$row['documento'];		
	$cod=$row['codigo'];
	$fi=$row['fecha_i'];
	$ff=$row['fecha_f'];
		
	//tabla planes	
	$n=$row['nombre'];
	$co=$row['cowork'];
	$sr=$row['sala_reuniones'];
	$i=$row['impresiones'];
	$e=$row['evento'];
	$p=$row['precio'];
	
	// Función para colocar la fecha actualizada en palabras
	$fecha = new DateTime($ff);
	setlocale(LC_TIME, 'es_MX');
	$fechaprox = strftime('%d de %B de %Y', $fecha->getTimestamp());
	
	// Calculo Impresiones

	$date = new DateTime($fechaActual);
	$date->modify('+1 day');
	$fechaSumada = $date->format('Y-m-d');
	$sql4 = "SELECT SUM(cantidad) AS total FROM `registro` WHERE `documento` = '$doc' AND `secuencial_planes` = '$sec' AND `entrada` BETWEEN '$fi' AND '$ff' AND estado NOT LIKE 'E'";
	
	$result4 = $conn->query($sql4);
    $row = $result4->fetch_assoc();
    $totalImpresiones = $row['total'];
    $ImpresionesDif = $i-$totalImpresiones; 
	
	//Calculo horas Cowork
	$sql3 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$doc' AND `secuencial_planes` = '$sec'";
	$result3 = mysqli_query($conn, $sql3);
	$total_segundos = mysqli_fetch_assoc($result3)['total_segundos'];
	$hours = floor($total_segundos / 3600);
    $minutes = floor(($total_segundos % 3600) / 60);
    $tiempo_usadoCW = sprintf('%02d:%02d', $hours, $minutes);
  	
	//Resta horas contratadas por usadas 
	$co_segundos = $co * 3600;
	$dif_segCW = $co_segundos - $total_segundos;
	$hoursDCW = floor($dif_segCW / 3600);
	$minutesDCW = floor(($dif_segCW % 3600) / 60);
	$tiempo_difCW = sprintf('%02d:%02d', $hoursDCW, $minutesDCW);
	
		//Calculo horas Sala Reuniones
	$sql5 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'sala' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$doc' AND `secuencial_planes` = '$sec'";
	$result5 = mysqli_query($conn, $sql5);
	$total_segundosS = mysqli_fetch_assoc($result5)['total_segundos'];
	$hoursS = floor($total_segundosS / 3600);
    $minutesS = floor(($total_segundosS % 3600) / 60);
    $tiempo_usadoS = sprintf('%02d:%02d', $hoursS, $minutesS);
  	
	//Resta horas contratadas por usadas 
	$sr_segundos = $sr * 3600;
	$dif_segSR = $sr_segundos - $total_segundosS;
	$hoursSR = floor($dif_segSR / 3600);
	$minutesSR = floor(($dif_segSR % 3600) / 60);
	$tiempo_difSR = sprintf('%02d:%02d', $hoursSR, $minutesSR);
	
	//dias restantes para terminar el plan 
	$fechaActualD = new DateTime($fechaActual);
	$fechaproxD = new DateTime($ff);
	$diferencia = $fechaActualD->diff($fechaproxD);
	$dias_restantes = $diferencia->days;
	
	if($dias_restantes<5){
		
		$dias_termina = "<b class='text-danger'>$dias_restantes</b>";
		
	}elseif ($dias_restantes > 5 && $dias_restantes < 10){
		$dias_termina = "$dias_restantes";
		
	}else{
		$dias_termina = "$dias_restantes";
			
	}	  
	?>	   
		   
  </tbody>
 </table>		   
                    
         <button  class="btn btn-primary mb-2" id="descargar">Descargar Excel</button> 

<?php 

// Definir las fechas como objetos DateTime
$fechaActualR = new DateTime($fechaActual);
$ffR = new DateTime($ff);

// Calcular la diferencia
$diferencia = $fechaActualR->diff($ffR);

// Verificar si la fecha futura ya pasó o está en el futuro
if ($fechaActualR > $ffR) {
    echo "Plan vencido";
} else {
    echo "Faltan " . $diferencia->days . " días para concluir el plan" ;
}
echo "<br>"; 

// Porcetanteje horas usadas coworking
$tiempoTotalHorasC = $co ; 
$minutosTotalC = $tiempoTotalHorasC * 60;
$tiempoUsadoC = $tiempo_usadoCW;
list($horasUsadoC, $minutosUsadoC) = explode(":", $tiempoUsadoC);
$minutosUsadoC = ($horasUsadoC * 60) + $minutosUsadoC;

// Verificar si el tiempo total en horas es 0
if ($tiempoTotalHorasC == 0) {
    echo "No se ha contratado horas de coworking";
} else {
    // Convertir el tiempo usado a minutos
    list($horasUsadoC, $minutosUsadoC) = explode(":", $tiempoUsadoC);
    $minutosUsadoC = ($horasUsadoC * 60) + $minutosUsadoC;

    // Verificar si el tiempo usado supera el tiempo total
    if ($minutosUsadoC > $minutosTotalC) {
        echo "Horas de Coworking agotadas";
    } else {
        // Calcular el porcentaje de tiempo usado
        $porcentajeUsadoC = ($minutosUsadoC / $minutosTotalC) * 100;
        $porcentajeUsadoCE = round($porcentajeUsadoC);
        echo "Se ha usado el " . round($porcentajeUsadoC, 2) . "% de horas de Sala de reuniones.";
		echo " <div class='progress'>
            <div class='progress-bar' id='progressBar' role='progressbar' style='width: $porcentajeUsadoC%;' aria-valuenow='$porcentajeUsadoC' aria-valuemin='0' aria-valuemax='100'>
                $porcentajeUsadoCE %
            </div>
			</div>";
    }
}
echo "<br>"; 

// Porcetanteje horas usadas sala de reuniones
$tiempoTotalHorasS = $sr; 
$minutosTotalS = $tiempoTotalHorasS * 60;
$tiempoUsadoS = $tiempo_usadoS;
list($horasUsadoS, $minutosUsadoS) = explode(":", $tiempoUsadoS);
$minutosUsadoS = ($horasUsadoS * 60) + $minutosUsadoS;

// Verificar si el tiempo total en horas es 0
if ($tiempoTotalHorasS == 0) {
    echo "No se ha contratado horas de Sala de Reuniones";
} else {
    // Convertir el tiempo usado a minutos
    list($horasUsadoS, $minutosUsadoS) = explode(":", $tiempoUsadoS);
    $minutosUsadoS = ($horasUsadoS * 60) + $minutosUsadoS;

    // Verificar si el tiempo usado supera el tiempo total
    if ($minutosUsadoS > $minutosTotalS) {
        echo "Horas de Sala de Reuniones agotadas";
    } else {
        // Calcular el porcentaje de tiempo usado
        $porcentajeUsadoS = ($minutosUsadoS / $minutosTotalS) * 100;
		$porcentajeUsadoSE = round($porcentajeUsadoS);
        echo "Se ha usado el " . round($porcentajeUsadoS, 2) . "% de horas de Sala de reuniones.";
		echo " <div class='progress'>
            <div class='progress-bar' id='progressBar' role='progressbar' style='width: $porcentajeUsadoS%;' aria-valuenow='$porcentajeUsadoS' aria-valuemin='0' aria-valuemax='100'>
                $porcentajeUsadoSE %
            </div>
			</div>";
    }
}
  

?>

	
	<script>
        document.getElementById('descargar').addEventListener('click', function(event) {
            // Prevenir el comportamiento predeterminado del botón
            event.preventDefault();

            // Referencia a la tabla HTML
            var tabla = document.getElementById('tabla');

            // Crear una hoja de cálculo
            var wb = XLSX.utils.table_to_book(tabla, {sheet: "Sheet1"});

            // Descargar el archivo Excel
            XLSX.writeFile(wb, 'reporte.xlsx');

          
        });
    </script>		
          </div>

          
         </form>
      </div>
	<div class='col-md-5 col-lg-3 order-md-last'>
	<form action="reporte_cliente_registros.php" method="post">
		<input type="hidden" name="documento" value="<?php echo $documento ?>">
		<button type="submit" class="btn btn-primary mb-2">Regresar Historial Planes</button><br>
		</form>	
        
    <br>
	
	<div class="col-sm-12">	
	

    
    <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
                <h3 class="my-0"> Datos cliente </h3>
                	  
				 
		</div></li>
<li class="list-group-item d-flex justify-content-between lh-sm">
    <div>
        <h6 class="my-0">Nombres y Apellido</h6>
        <span class="text-body-secondary">
            <?php echo $nombre."&nbsp".$apellido?>
        </span>
    </div>	
</li>
<li class="list-group-item d-flex justify-content-between lh-sm">
    <div>
        <h6 class="my-0">Correo</h6>
        <span class="text-body-secondary">
           <?php echo $correo ?></span>
        
    </div>
</li>
<li class="list-group-item d-flex justify-content-between lh-sm">
    <div>
        <h6 class="my-0">Teléfono</h6>
        <span class="text-body-secondary">
            <?php echo $telefono ?> </span>
      </div>	
</li>

</ul>
 </div>	
	 <div class='col-sm-12'>	
	
<?php


echo "
    
    <ul class='list-group mb-3'>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h3 class='my-0'> $n</h6>
				<small class='text-body-secondary'>Incia el plan el: <br> $fi <br>
				  </small>
                	 <small class='text-body-secondary'> <a href='modificar_fecha.php?documento=$documento2&sec=$sec'> Vencimiento mensual  el: </a> <br> $ff <br>
				  </small>
				
					  
				 
		</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en COWORK</h6>
        <span class='text-body-secondary'>
            Contratadas:  $co:00 
            <br>Usadas:  $tiempo_usadoCW 
            <br>Restantes: $tiempo_difCW
        </span>
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en Sala Reuniones</h6>
        <span class='text-body-secondary'>
            Contratadas: $sr:00</span>
        <br>Usadas:  $tiempo_usadoS
        <br>Restantes: $tiempo_difSR 



    </div>
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Cantidad Impresiones</h6>
        <span class='text-body-secondary'>
            Contratadas: $i </span>
        <br>Usadas:  $totalImpresiones
        <br>Restantes:  $ImpresionesDif  
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Eventos Connecta</h6>
    </div>
    <span class='text-body-secondary'>$e</span>
</li>
<li class='list-group-item d-flex justify-content-between'>
    <span>Precio</span>
    <strong> $p </strong>
</li>
</ul>";
	
?>
</div>	
</div>
</div>


</div>
	
	

<?php
				

mysqli_close($conn); 
	   
?>
   
</div>		
</body>
 
</html>

