<?php
include 'conexion.php';
date_default_timezone_set('America/Guayaquil');
$documento = $_GET['id'];
$sala = $_GET['sala'];
$sec = $_GET['sec'];
$entrada = date('Y-m-d H:i:s');
$servicio = "sala";
$estado = "C";

if($sala==1){
	
	$sql = "INSERT INTO registro (documento, entrada,servicio,estado ) VALUES ( '$documento', '$entrada', '$servicio','$estado')";
	mysqli_query($conn, $sql);
	
}else{

	$sql = "UPDATE registro SET salida = '$entrada', concluido = 1 WHERE secuencial_R = '$sec' ";
	mysqli_query($conn, $sql);
}



mysqli_close($conn);

header('Location: registro.php');
?>