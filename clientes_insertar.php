<?php
include 'conexion.php';
date_default_timezone_set('America/Guayaquil');
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$suscripcion = $_POST['suscripcion'];
$fecha_inicio =  $_POST['fecha_inicio'];
$fecha = new DateTime($fecha_inicio);
$fecha->modify('+1 month');
$fecha_fin = $fecha->format('Y-m-d');


$fecha =  date('Y-m-d');

	
$sql = "INSERT INTO clientes (documento, nombre, apellido, correo, direccion, telefono, suscripcion, fecha, estado ) VALUES ('$documento', '$nombre', '$apellido', '$correo', '$direccion', '$telefono', 'A', '$fecha', 'A')";
mysqli_query($conn, $sql);

$sql2 = "INSERT INTO planes_registro (documento, codigo, fecha_i, fecha_f, estado ) VALUES ('$documento', '$suscripcion', '$fecha_inicio', '$fecha_fin', 'A' )";
mysqli_query($conn, $sql2);


mysqli_close($conn);

header('Location: clientes.php');


?>