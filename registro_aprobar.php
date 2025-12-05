<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fecha = date('Y-m-d');
$fecha2 = $_GET['fecha'];
$id = $_GET['sec'];
$hora = $_GET['hora'];

// Consulta tabla clientes 

$sql = "SELECT * FROM registro WHERE secuencial_R = $id"; 
$resultado = mysqli_query($conn,$sql);
$Reg = mysqli_fetch_assoc($resultado);
$documento = $Reg['documento']; 
$invitado = $Reg['invitado']; 
$servicio = $Reg['servicio'];
$secuencial = $Reg['secuencial_R'];
$SecPLan = $Reg['secuencial_planes'];



if($servicio == 'cowork'){
	if (empty($invitado)) {
  $sql = "INSERT INTO horas (secuencial, servicio, fecha, hora, documento,secuencial_planes) VALUES ('$secuencial', '$servicio', '$fecha', '$hora', '$documento', '$SecPLan')";
   mysqli_query($conn, $sql);
}else{
$sql = "INSERT INTO horas (secuencial, servicio, fecha, hora, documento,secuencial_planes) VALUES ('$secuencial', '$servicio', '$fecha', '$hora', '$invitado', '$SecPLan')";
   mysqli_query($conn, $sql);
}
}else{
	$sql = "INSERT INTO horas (secuencial, servicio, fecha, hora, documento,secuencial_planes) VALUES ('$secuencial', '$servicio', '$fecha', '$hora', '$documento', '$SecPLan')";
   mysqli_query($conn, $sql);
	
}





$consulta = "UPDATE registro SET estado='A', secuencial_planes='$SecPLan' WHERE secuencial_R='$secuencial'";
$result = mysqli_query($conn, $consulta);

mysqli_close($conn);

header('Location: diario.php?fecha='. $fecha2);
?>