<?php
include 'conexion.php';
date_default_timezone_set('America/Guayaquil');
$entrada = date('Y-m-d H:i:s');
$fecha= date('Y-m-d');
$documento = $_POST['documento2'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$servicio = $_POST['servicio'];
$invitado = $_POST['documento'];

$sql = "INSERT INTO clientes (documento, nombre, apellido, correo, direccion, telefono, fecha, estado) VALUES ('$documento', '$nombre', '$apellido', '$correo', '$direccion', '$telefono', '$fecha', 'A' )";
	
mysqli_query($conn, $sql);


$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio FROM planes_registro 
INNER JOIN planes ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$invitado' AND planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f ORDER BY planes_registro.secuencial_planes DESC 
LIMIT 1;";
	
$resultCE = mysqli_query($conn,$sqlCE);	
$Reg = mysqli_fetch_assoc($resultCE);
$sec_P = $Reg['secuencial_planes']; 


$sql2 = "INSERT INTO registro (documento, invitado, entrada, servicio, concluido, estado, secuencial_planes ) VALUES ('$documento', '$invitado', '$entrada', '$servicio', '0', 'C','$sec_P')";

mysqli_query($conn, $sql2);

mysqli_close($conn);

header('Location: registro.php');
?>