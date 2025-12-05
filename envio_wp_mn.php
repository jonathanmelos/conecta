<?php
include('conexion.php');
$id = $_GET['id'];
$sql = "UPDATE calendario SET estado = 'C' WHERE id_cal = $id";
$result = mysqli_query($conn,$sql); 
header('Location: calendario.php');
?>