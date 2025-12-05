<?php
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fecha =  date('Y-m-d');


$documento = $_POST['documento'];
$secuencial = $_POST['secuencial'];

$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio FROM planes_registro 
INNER JOIN planes ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento' AND planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f ORDER BY planes_registro.secuencial_planes DESC 
LIMIT 1;";
	
$resultCE = mysqli_query($conn,$sqlCE);	
$Reg = mysqli_fetch_assoc($resultCE);
$sec_P = $Reg['secuencial_planes']; 



$consulta = "UPDATE registro SET invitado='$documento', secuencial_planes='$sec_P' WHERE secuencial_R ='$secuencial'";

$result = mysqli_query($conn, $consulta);

header('Location: registro.php');
?>