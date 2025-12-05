<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$sexo = $_POST['sexo'];
$estado = $_POST['estado'];
$ingresos = $_POST['ingresos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$emprendedor = $_POST['emprendedor'];
$tam_emp = $_POST['tam_emp'];
$necesidad = $_POST['necesidad'];
$medio = $_POST['medio'];
$fecha = $_POST['fecha'];
$intereses = $_POST['intereses'];
$campana = $_POST['campana'];
$tema = $_POST['tema'];
$observaciones = $_POST['observaciones'];
$area_negocio = $_POST['area_negocio'];

	// No existe un registro con el mismo nombre, realizar la inserción
$sql = "INSERT INTO leads (nombre, correo, direccion, telefono, fecha, estado, campana, tema, medio, edad, sexo, ingresos, intereses, emprendedor, empresa_tamano, area_negocio, necesidad, observaciones) VALUES ('$nombre', '$correo', '$direccion', '$telefono', '$fecha', '$estado', '$campana', '$tema', '$medio', '$edad', '$sexo', '$ingresos', '$intereses', '$emprendedor', '$tam_emp', '$area_negocio', '$necesidad', '$observaciones')";

mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: embudo.php');


?>