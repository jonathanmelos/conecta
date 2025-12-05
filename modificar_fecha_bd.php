<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$sec = $_POST['sec'];
$fi = $_POST['fecha_i'];
$ff = $_POST['fecha_f'];
$documento = $_POST['documento'];



$consulta2 = "UPDATE planes_registro SET fecha_i='$fi', fecha_f='$ff' WHERE secuencial_planes='$sec' ";

$result2 = mysqli_query($conn, $consulta2);

mysqli_query($conn, $consulta2);

header('Location: reporte_detalle_r.php?documento='. $documento. '&sec=' . $sec);


?>