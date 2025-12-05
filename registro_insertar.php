<?php
include 'conexion.php';

$documento = $_POST['documento'];
$entrada = $_POST['entrada'];
$salida = $_POST['salida'];
$cantidad = $_POST['cantidad'];
$servicio = $_POST['servicio'];

$sql = "INSERT INTO registro (documento, entrada, salida, cantidad, servicio) VALUES ( '$documento', '$entrada', '$salida', '$cantidad', '$servicio')";

if (mysqli_query($conn, $sql)) {
    echo "Datos insertados correctamente";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

header('Location: registro.php');
?>