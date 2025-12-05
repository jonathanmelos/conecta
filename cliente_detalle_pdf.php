<?php
include 'conexion.php';
$fecha = date('Y-m-d');
$documento = $_GET['documento'];
$secuencial = $_GET['secuencial'];
$U_CW = $_GET['cw'];
$U_S = $_GET['sala'];
$U_I = $_GET['impr'];
ob_start();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
  <head>
	 <script src="http://<?php echo $_SERVER['HTTP_HOST']?>/conecta_sistema/js/color-modes.js"></script>
     <script src="http://<?php echo $_SERVER['HTTP_HOST']?>/conecta_sistema/js/popper.min"></script>	 

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jonathan Melo">
    <meta name="generator" content="QW1.0">
    <title>Gestion Conecta Coworking</title>
   

<link href="http://<?php echo $_SERVER['HTTP_HOST']?>/conecta_sistema/css/bootstrap.min.css" rel="stylesheet">
<link href="http://<?php echo $_SERVER['HTTP_HOST']?>/conecta_sistema/css/popper.min" >
<link href="http://<?php echo $_SERVER['HTTP_HOST']?>/conecta_sistema/css/estilo.css" > 
	  
    <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}	
</style>

   
    <link href="http://<?php echo $_SERVER['HTTP_HOST']?>/sistema/pricing.css" rel="stylesheet">
 
  </header>
<div class="container py-3">
  
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      
        <img src='http://<?php echo $_SERVER['HTTP_HOST']?>/sistema/images/logo.jpg' alt='logo' style='width: 150px; height: 65px;'>
     
   </div>
</div>	
<div class="container">
<?php 
/*/ Consulta tabla clientes 
$sql = "SELECT * FROM clientes WHERE documento = $documento" ; 
$result = mysqli_query($conn,$sql);
    $Cli = mysqli_fetch_assoc($result);
    $nombre = $Cli['nombre']; 
    $apellido = $Cli['apellido']; 
    $correo2 = $Cli['correo'];
    $direccion = $Cli['direccion'];
    $telefono2 = $Cli['telefono'];
    $suscripcion = $Cli['suscripcion'];
    $fechaCli = $Cli['fecha'];*/

?> 
<div class="row">
 <div class="col-md-7 col-lg-4">
  
    <h5 class="card-title"><?php echo $nombre." ".$apellido ?></h5>
    <p class="card-text">Documento: <?php echo $documento; ?> / Correo: <?php echo $correo2; ?> / Teléfono:  <?php echo $telefono2; ?></p>
    <br>
 </div> 


</div>  
<?php
$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.fecha_i, planes_registro.fecha_f , planes.cowork, planes.sala_reuniones, planes.impresiones, planes.nombre  
FROM planes_registro
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento  = '$documento' AND planes_registro.secuencial_planes = '$secuencial'
ORDER BY planes_registro.fecha_i ASC";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$cod=$row['secuencial_planes'];
	$nombre=$row['nombre'];
	$fi = $row['fecha_i'];
	$ff = $row['fecha_f'];
    $cowork = $row['cowork'];
    $sala = $row['sala_reuniones'];
    $impresiones = $row['impresiones'];
	$sec = $row['secuencial_planes'];

	
echo "
<div class='col-md-5 col-lg-8 order-md-last'>
    <h4 class='d-flex justify-content-between align-items-center mb-3'>
        <span class='text-primary'>Plan </span>
    </h4>	
    
    <ul class='list-group mb-3'>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
<table>
  <tr>
    <td>Plan</td>
    <td> <b> $nombre</b></td>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><b> Horas  </b></td>
    <td>&nbsp;&nbsp;<b> Cowork</b>  </td>
    <td>&nbsp;&nbsp;<b> Sala  </b>  </td>
    <td>&nbsp;&nbsp;<b> Impresiones </b>  </td>
  </tr>
  <tr>
    <td>Fecha de Inicio</td>
    <td>&nbsp;&nbsp;   $fi</td>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><b>contradas</b></td>
    <td>&nbsp;&nbsp; $cowork:00</td>
    <td>&nbsp;$sala:00</td>
    <td>&nbsp;$impresiones</td>
  </tr>
  <tr>
    <td>Fecha Finalizacion</td>
    <td>&nbsp;&nbsp;   $ff</td>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><b>usadas</b></td>
    <td>&nbsp;&nbsp;$U_CW</td>
    <td>&nbsp;&nbsp;$U_S</td>
    <td>&nbsp;&nbsp;$U_I</td>
  </tr>
</table>
</li>
</ul>
</div>" ;

	
	
echo "<table class='table table-striped'>
  <thead>
    <tr>
	  <th scope='col' class='col-3'>Cliente </th>
       <th scope='col'>Entrada</th>   
		<th scope='col'>Salida</th>
		<th scope='col'>Horas Usadas</th> 
		<th scope='col'>Servicio</th>
		<th scope='col'>Imp</th>
		<th scope='col'>Estado</th>   
		
    </tr>
  </thead>";
	$sqlCE = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 

	
   echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> en cowork</td>
    <td> en cowork </td>
    <td>cowork</td>
	<td>$impresiones</td>
	<td> en uso </td>
	</tr>";
		
 }  
	


//meta consulta de registros concluidos botones cowork 
			 
$sqlCS = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
    $concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
    $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
		  
	
	
    echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> $salida</td>
    <td> $horas_formateado </td>
    <td>cowork</td>
	<td>$impresiones</td>
	<td> Concluido y Aprobado </td>
	</tr>";
		
  
	
}
		
$sqlCS = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
    $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
		  
	
    echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> $salida</td>
    <td> $horas_formateado </td>
    <td>cowork</td>
	<td>$impresiones</td>
	<td> Por Aprobar </td>
	</tr>";	  

}
			 		   
//meta consulta de registros por concluirse botones sala
			 
$sqlSE = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$secuencial = $row['secuencial_R'];
	
	 echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> en sala </td>
    <td> en sala< </td>
    <td>sala</td>
	<td>$impresiones</td>
	<td> en uso </td>
	</tr>";
	
    	
}

//meta consulta de registros por concluirse botones sala
			 
$sqlSE = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 
	$secuencial = $row['secuencial_R'];
	
	
	echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> en sala </td>
    <td> en sala< </td>
    <td>sala</td>
	<td>$impresiones</td>
	<td> Por aprobar</td>
	</tr>";
	
   	
}

		   
//meta consulta de registros concluidos botones sala
			 
$sqlSS = "SELECT clientes.nombre, clientes.apellido, registro.entrada, registro.salida, registro.cantidad, registro.documento, registro.servicio, registro.secuencial_R, registro.concluido, registro.invitado, registro.cantidad
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
	$concluido=$row['concluido'];
	$invitado=$row['invitado'];	 	  
	 $horas = strtotime($salida) - strtotime($entrada);
    $horas = $horas / (60 * 60);	  
	$horas_formateado = date('G:i', mktime(0, round($horas * 60)));
	if ($entrada = $fecha ){
		
		
	echo "<tr>
    <td> $documento </td>
	<td> $entrada </td>
    <td> $salida </td>
    <td> $horas_formateado  </td>
    <td>sala</td>
	<td>$impresiones</td>
	<td> Concluido y Aprobado</td>
	</tr>";
		
   }     

	  
}	  

echo "</table>
</tbody>
</table>";	

}


?>

</div>	
</body>
</html>
<?php 
$html=ob_get_clean();
echo $html;
require_once '../sistema/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options -> set(array('isRemoteEnabled' => true));
$dompdf -> setOptions($options);

$dompdf -> loadHtml($html);
$dompdf ->setPaper('A4','portrait');
$dompdf ->render();
$dompdf -> stream("reporte.pdf",array("Attachmet"=> false));
?>