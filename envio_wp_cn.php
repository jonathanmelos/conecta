<?php
include('conexion.php');
$id = $_GET['id'];
$telef = $_GET['telef'];
$nombre = $_GET['nombre'];
echo $nombre;
$sql = "UPDATE calendario SET estado = 'C', telefono = '$telef'  WHERE id_cal = $id  ";
$result = mysqli_query($conn,$sql); 
$sql2 = "UPDATE leads SET telefono = '$telef' WHERE nombre LIKE '$nombre' ";
$result2 = mysqli_query($conn,$sql2); 
header('Location: calendario.php');
?>