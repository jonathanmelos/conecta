<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$cowork = $_POST['cowork'];
$sala_reuniones = $_POST['sala_reuniones'];
$impresiones = $_POST['impresiones'];
$evento = $_POST['evento'];
$precio = $_POST['precio'];

$sql = "INSERT INTO planes (nombre, cowork, sala_reuniones, impresiones, evento, precio) VALUES ( '$nombre', '$cowork', '$sala_reuniones', '$impresiones', '$evento', '$precio')";

if (mysqli_query($conn, $sql)) {
    
} else {
   
}

mysqli_close($conn);

header('Location: planes.php');
?>