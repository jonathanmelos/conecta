<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';

$fecha = date('Y-m-d');
$fechaInicio = $fechaInicio ?? $fecha; // Si $fechaInicio es null, usa la fecha actual
$fechaFin = $fechaFin ?? $fecha;       // Si $fechaFin es null, usa la fecha actual
$secPlanes = $secPlanes ?? 0;
$horasCoworkContratadas = $horasCoworkContratadas ?? 0;
$horasSalaContratadas = $horasSalaContratadas ?? 0;

$sql = "SELECT * FROM planes_registro  WHERE estado = 'A'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $sec_planes = $row['secuencial_planes'];
    $fecha_i_planes = $row['fecha_i'];
    $fecha_f_planes = $row['fecha_f'];
    $documento = $row['documento'];

    if ($fecha_f_planes <= $fecha) {
        // Actualiza la fila a "F" si la fecha está vencida
        $updateSql = "UPDATE planes_registro SET estado = 'F' WHERE secuencial_planes = '$sec_planes'";
        mysqli_query($conn, $updateSql);
		// Actualiza la fila a "F" si la fecha está vencida
		$updateSqlCli = "UPDATE clientes SET suscripcion = 'F' WHERE documento = '$documento'";
		mysqli_query($conn, $updateSqlCli);


    } 
}



include 'header.php'; 

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


<div class="row">
	 <div class="col-md-5 col-lg-6">
		 <h4 class="mb-3">Busca un cliente</h4>
		 <div class="row g-3">
			 <div class="col-sm-3">
				 <label for="firstName" class="form-label">Documento:</label>
			</div>
			 <div class="col-sm-9">	 
				 <input type="text" id="documento" class="form-control" >
		 	</div>
			 <div class="col-sm-3">
				 <label for="firstName" class="form-label">Nombre:</label>
			</div>
			 <div class="col-sm-9">	 
				 <input type="text" id="nombre" class="form-control" >
		    </div>
			<div class="col-sm-3">
				<label for="firstName" class="form-label">Apellido:</label>
			</div>
			 <div class="col-sm-9">	
				<input type="text" id="apellido" class="form-control" >
			</div>
		 </div>

	</div>
	 <div class="col-md-5 col-lg-6">
	  <h4 class="mb-3">Resultados de la búsqueda</h4>
		<div id="results2">
			 
			 </div> 
	<div class="d-grid gap-2 col-6 mx-auto">
	 
    </div>		 
	 </div>
</div>	
<!-- Alerta lateral -->
<div id="customAlert" class="custom-alert">
  <h3 class="alert-heading">No lo olvides!</h3>
   <?php 
$fechaActual = date('Y-m-d');
$documento = $_GET['doc'];



if (!empty($documento) && $documento != 0) {
    $sql = "
        SELECT 
            pr.secuencial_planes, pr.documento, pr.codigo, pr.fecha_i, pr.fecha_f, pr.estado, 
            p.nombre, p.cowork, p.sala_reuniones, p.impresiones, p.evento, p.precio,
            c.nombre AS nombre_cliente, c.apellido, c.correo, c.direccion, c.telefono, c.fecha AS fecha_cliente
        FROM planes_registro pr
        INNER JOIN planes p ON pr.codigo = p.codigo
        INNER JOIN clientes c ON pr.documento = c.documento
        WHERE pr.documento = '$documento' 
        AND pr.estado = 'A' 
        AND '$fechaActual' BETWEEN pr.fecha_i AND pr.fecha_f
    ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "No se encontraron planes activos.";
        exit;
    }

    // Variables de plan y cliente
    $secPlanes = $row['secuencial_planes'];
    $nombreCliente = $row['nombre_cliente'];
    $fechaInicio = $row['fecha_i'];
    $fechaFin = $row['fecha_f'];
    $horasCoworkContratadas = $row['cowork'];
    $horasSalaContratadas = $row['sala_reuniones'];

    echo '<h5 class="text-danger">Estado Actual del Plan de: <br>' . $nombreCliente . '</h5>';
} else {

}




function calcularHorasUsadas($conn, $servicio, $fechaInicio, $fechaFin, $documento, $secPlanes, $horasContratadas) {
    $sqlHoras = "
        SELECT SUM(TIME_TO_SEC(hora)) AS total_segundos 
        FROM horas 
        WHERE servicio = '$servicio' 
        AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' 
        AND documento = '$documento' 
        AND secuencial_planes = '$secPlanes'
        
    ";
    $resultHoras = mysqli_query($conn, $sqlHoras);
    $totalSegundosUsados = mysqli_fetch_assoc($resultHoras)['total_segundos'] ?? 0;
    
    $horasUsadas = floor($totalSegundosUsados / 3600);
    $minutosUsados = floor(($totalSegundosUsados % 3600) / 60);
    $tiempoUsado = sprintf('%02d:%02d', $horasUsadas, $minutosUsados);
    
    // Verificar si las horas contratadas son mayores a 0 antes de calcular el porcentaje

    if ($horasContratadas > 0) {
        $segundosContratados = $horasContratadas * 3600;
        $porcentajeUsado = ($totalSegundosUsados / $segundosContratados) * 100;

        // Mostrar progreso
        if ($porcentajeUsado >= 100) {
            echo "Horas de $servicio agotadas";
        } else {
            echo "Se ha usado el " . round($porcentajeUsado, 2) . "% de horas de $servicio.<br>";
        }

        // Barra de progreso
        echo "<div class='progress'>
            <div class='progress-bar' role='progressbar' style='width: " . min($porcentajeUsado, 100) . "%;' 
                aria-valuenow='" . min($porcentajeUsado, 100) . "' aria-valuemin='0' aria-valuemax='100'>
                " . round(min($porcentajeUsado, 100), 2) . "%
            </div>
        </div><br>";
    } else {
        echo "No se han contratado horas para $servicio.<br>";
    }
}


// Calcular horas usadas para Coworking y Sala de Reuniones
calcularHorasUsadas($conn, 'cowork', $fechaInicio, $fechaFin, $documento, $secPlanes, $horasCoworkContratadas);
calcularHorasUsadas($conn, 'sala', $fechaInicio, $fechaFin, $documento, $secPlanes, $horasSalaContratadas);

// Cálculo de días restantes
$fechaActualD = new DateTime($fechaActual);
$fechaFinD = new DateTime($fechaFin);
$diferencia = $fechaActualD->diff($fechaFinD);
$diasRestantes = $diferencia->days;
$diasTermina = $diasRestantes < 5 ? "<b class='text-danger'>$diasRestantes</b>" : $diasRestantes;

echo "Días restantes para concluir el plan: $diasTermina <br>";
  
  ?>

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


  <hr>
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
	
	
	
  <button type="button" class="btn-close" aria-label="Close"></button>
</div>

<div class="container">
		<h4 class="mb-3"> CLIENTES COWORK DIARIO</h4>
<table class="table table-striped">
  <thead>
    <tr>
	  <th scope="col" class="col-3">Nombre y Apellido </th>
         <th scope="col">Cowork</th>
        <th scope="col">Sala Reuniones</th>   
		<th scope="col">Impresiones</th>  
		<th scope="col" class="col-2">Horas usadas</th>
		<th scope="col">Servicio</th>
		
    </tr>
  </thead>
  <tbody>
	  
    <?php

$sqlCE = "SELECT clientes.nombre, clientes.apellido , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido,
registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	
	

	if ($entrada = $fecha ){
    echo "<tr>";
    echo "<td>" ."<a href='agregar_invitado.php?invitado=" .$documento."&sec=".$secuencial."' class='link-primary' style= 'text-decoration:none'>". $row['nombre'] . "&nbsp;".$row['apellido'] . "<img src='images/mas.png' alt='agregar' style='width: 20px; height: 20px;''></a><br>";		
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
		
	echo "<img src='images/pertenece.png' alt='invitado por' style='width: 20px; height: 20px;'' '=''>" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"</td>";
	echo "<td><a href='registro_cowork.php?id=" .$documento."&sec=".$secuencial."&cowork=0'>
	<button class='btn btn-warning'>Usando Cowork</button></a>
	</td>";
     echo "<td><a href='registro_sala.php?id=" .$documento ."&sala=1'>
            <button class='btn btn-info'>Registrar Horas Sala</button></a></td>";
	echo "<td><a href='registro_impresion.php?id=" . $documento . "&sec=".$secuencial."'>
            <button class='btn btn-info'>Registrar Impresión ".$impresiones."</button></a></td>";
  	echo "<td> <img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " . $entradaHora ." <br> <img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> EN USO<br></td>";	
	echo "<td>cowork</td>";		
    echo "</tr>";
 }  
	
}

$sqlCS = "SELECT clientes.nombre, clientes.apellido , registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	  
    $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
		  
	
	if ($entrada = $fecha ){
    echo "<tr>";
      echo "<td>" ."<a href='agregar_invitado.php?invitado=" .$documento."&sec=".$secuencial."' class='link-primary' style= 'text-decoration:none'>". $row['nombre'] . "&nbsp;".$row['apellido'] . "<img src='images/mas.png' alt='agregar' style='width: 20px; height: 20px;''></a><br>";	
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "&#8212;" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"<img src='images/mas.png' alt='Salida' style='width: 20px; height: 20px;''> agregar </td>";
	echo "<td><a href='registro_cowork.php?id=" .$documento."&cowork=1'>
	         <button class='btn btn-info'>Registrar Horas</button></a></td>";
     echo "<td><a href='registro_sala.php?id=" .$documento ."&sala=1'>
            <button class='btn btn-info'>Registrar Horas Sala</button></a></td>";
       
  echo "<td><a href='registro_impresion.php?id=" . $documento . "&sec=".$secuencial."'>
            <button class='btn btn-info'>Registrar Impresión ".$impresiones."</button></a></td>";
     
         
	echo "<td><img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " . 	$entradaHora ." <br> <img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> ".$salidaHora. "<br><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
	echo "<td>cowork</td>";		
    echo "</tr>";
 }     
	
}

$sqlSE = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido,
registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$secuencial = $row['secuencial_R'];
	
	
	if ($entrada = $fecha ){
    echo "<tr>";
     echo "<td>" ."<a href='agregar_invitado.php?invitado=" .$documento."&sec=".$secuencial."' class='link-primary' style= 'text-decoration:none'>". $row['nombre'] . "&nbsp;".$row['apellido'] . "<img src='images/mas.png' alt='agregar' style='width: 20px; height: 20px;''></a><br>";			
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "&#8212;" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"<img src='images/mas.png' alt='Salida' style='width: 20px; height: 20px;''> agregar </td>";
	echo "<td><a href='registro_cowork.php?id=" .$documento."&cowork=1'>
            <button class='btn btn-info'>Registrar Horas</button></a></td>";
		
     echo "<td><a href='registro_sala.php?id=" .$documento ."&sec=".$secuencial."&sala=0'>
            <button class='btn btn-warning'>Usando Sala Reuniones</button></a></td>";
		
    
    echo "<td><a href='registro_impresion.php?id=" . $documento . "&sec=".$secuencial."'>
            <button class='btn btn-info'>Registrar Impresión ".$impresiones."</button></a></td>";
     
  	echo "<td> <img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''>" . $entradaHora ." <br> <img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;''> EN USO<br></td>";	
	echo "<td>sala</td>";		
    echo "</tr>";
 }  
	
}
	  
$sqlSS = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido,
registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
	 $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);	  
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
	if ($entrada = $fecha ){
    echo "<tr>";
     echo "<td>" ."<a href='agregar_invitado.php?invitado=" .$documento."&sec=".$secuencial."' class='link-primary' style= 'text-decoration:none'>". $row['nombre'] . "&nbsp;".$row['apellido'] . "<img src='images/mas.png' alt='agregar' style='width: 20px; height: 20px;''></a><br>";			
    foreach ($datos as $dato) {
    if ($dato['documento'] == $invitado) {
        echo "&#8212;" . $dato['nombre'] . "&nbsp;". $dato['apellido'] . "\n";}
    } ;
		"<img src='images/mas.png' alt='Salida' style='width: 20px; height: 20px;''> agregar</td>";
	echo "<td><a href='registro_cowork.php?id=" .$documento."&cowork=1'>
            <button class='btn btn-info'>Registrar Horas</button></a></td>";
     echo "<td><a href='registro_sala.php?id=" .$documento ."&sala=1'>
            <button class='btn btn-info'>Registrar Horas Sala</button></a></td>";
       
  echo "<td><a href='registro_impresion.php?id=" . $documento . "&sec=".$secuencial."'>
            <button class='btn btn-info'>Registrar Impresión ".$impresiones."</button></a></td>";
     
  
	echo "<td> <img src='images/entrada.png' alt='Entrada' style='width: 20px; height: 20px;''> " . $entradaHora ." <br> <img src='images/salida.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$salidaHora. "<br><img src='images/total_horas.png' alt='Entrada' style='width: 20px; height: 20px;''> ".$horas_formateado . "</td>";	
	echo "<td>sala</td>";		
    echo "</tr>";
 }     
	
}	  
	  
	?>
	  </tbody>
</table>

</div>    

    </body>
<script>



// Función para realizar la búsqueda y actualizar los resultados
function doSearch() {
    // Obtener los valores de los campos de entrada
    var documento = document.getElementById('documento').value;
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;

    // Enviar una solicitud AJAX al archivo search.php para realizar la búsqueda
    fetch('buscar.php?documento=' + encodeURIComponent(documento) + '&nombre=' + encodeURIComponent(nombre) + '&apellido=' + encodeURIComponent(apellido))
        .then(function(response) {
            return response.json();
        })
        .then(function(results) {
            // Crear una tabla para mostrar los resultados
            var table = '<table class="table table-striped">';
            table += ' <thead><tr><th scope="col">Documento</th><th scope="col" >Nombre</th><th>Apellido</th><th scope="col">Seleccionar</th></tr> </thead>';
            for (var i = 0; i < results.length; i++) {
                table += '<tr>';
                table += '<td>' + results[i].documento + '</td>';
                table += '<td>' + results[i].nombre + '</td>';
                table += '<td>' + results[i].apellido + '</td>';
				table += '<td><a href="registro_cowork_busqueda.php?id='+results[i].documento+'&cowork=1"><button class="btn btn-outline-info">cowork</button></a></td>';
				table += '<td><a href="registro_sala_busqueda.php?id='+results[i].documento+'&sala=1"><button class="btn btn-outline-info">sala</button></a></td>';
                table += '</tr>';
            }
		    
				    
            table += '</table>';
			table += '<a href="clientes_registro.php"><button type="button" class="btn btn-primary ">Crear nuevo cliente</button></a>';
            // Mostrar la tabla en el contenedor de resultados
            document.getElementById('results2').innerHTML = table;
        });
}

// Agregar controladores de eventos input a los campos de entrada
document.getElementById('documento').addEventListener('input', doSearch);
document.getElementById('nombre').addEventListener('input', doSearch);
document.getElementById('apellido').addEventListener('input', doSearch);
</script>
	   

	  </html>
<?php 
mysqli_close($conn);
include 'footer.php'; ?>
	