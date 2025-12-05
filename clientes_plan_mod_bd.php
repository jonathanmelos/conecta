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
$sec = $_POST['sec'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha = new DateTime($fecha_inicio);
$fecha->modify('+2 month');
$fecha_fin = $fecha->format('Y-m-d');

$consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', correo='$correo', direccion='$direccion', telefono='$telefono', suscripcion='A' WHERE documento='$documento' ";
$result = mysqli_query($conn, $consulta);

mysqli_query($conn, $consulta);

$sql = "UPDATE planes_registro SET codigo = '$suscripcion', fecha_i = '$fecha_inicio', fecha_f = '$fecha_fin' WHERE secuencial_planes = '$sec';";
mysqli_query($conn, $sql);


header('Location: clientes.php');


?>