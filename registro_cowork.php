<?php
include 'conexion.php';
date_default_timezone_set('America/Guayaquil');
$documento = $_GET['id'];
$cowork = $_GET['cowork'];
$sec = $_GET['sec'];
$entrada = date('Y-m-d H:i:s');
$fecha= date('Y-m-d');
$servicio = "cowork";
$estado = "C";

if($cowork==1){
	
	$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio FROM planes_registro 
INNER JOIN planes ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento' AND planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f ORDER BY planes_registro.secuencial_planes DESC 
LIMIT 1;";
	
$resultCE = mysqli_query($conn,$sqlCE);	
$Reg = mysqli_fetch_assoc($resultCE);
$sec_P = $Reg['secuencial_planes']; 


	
	$sql = "INSERT INTO registro (documento, entrada, servicio, estado, secuencial_planes ) VALUES ( '$documento', '$entrada', '$servicio', '$estado', '$sec_P' )";
	
mysqli_query($conn, $sql);


   
}else{
	
	$sql = "UPDATE registro SET salida = '$entrada', concluido = 1 WHERE secuencial_R = '$sec' ";
	mysqli_query($conn, $sql);
	
}
 

mysqli_close($conn); 
header('Location: registro.php'); 
?>