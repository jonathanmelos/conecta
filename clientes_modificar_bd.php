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
$fecha->modify('+2 month');
$fecha_fin = $fecha->format('Y-m-d');

$consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', correo='$correo', direccion='$direccion', telefono='$telefono'  WHERE documento='$documento'";
$result = mysqli_query($conn, $consulta);

mysqli_query($conn, $consulta);

$consulta2 = "UPDATE planes_registro SET fecha_i='$fecha_inicio', fecha_f='$fecha_fin' WHERE documento='$documento' ";

$result2 = mysqli_query($conn, $consulta2);

mysqli_query($conn, $consulta);

	
header('Location: clientes.php');


?>