<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$suscripcion = $_POST['suscripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha = new DateTime($fecha_inicio);
$fecha->modify('+1 month');
$fecha_fin = $fecha->format('Y-m-d');

$consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', correo='$correo', direccion='$direccion', telefono='$telefono', suscripcion='A' WHERE documento='$documento' ";
$result = mysqli_query($conn, $consulta);

mysqli_query($conn, $consulta);


$sql = "INSERT INTO planes_registro (documento, codigo, fecha_i, fecha_f, estado) VALUES ( '$documento', '$suscripcion', '$fecha_inicio','$fecha_fin', 'A')";
	mysqli_query($conn, $sql);

	
header('Location: clientes.php');


?>