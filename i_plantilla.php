<?php 
include 'conexion.php';
$nombre = $_POST['nombre'];
$info =  $_POST['info'];

$sql = "INSERT INTO plantilla (nombre, info ) VALUES ('$nombre', '$info')";
mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: plantilla_wp.php');

?>