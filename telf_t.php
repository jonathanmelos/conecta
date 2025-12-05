<?php
include('conexion.php');
$id = $_GET['id'];
$sec_lead = $_GET['sec_lead'];
$sql2 = "UPDATE leads SET nivel = nivel + 15 WHERE sec_lead = '$sec_lead' ";
$result2 = mysqli_query($conn,$sql2); 
$sql = "UPDATE calendario SET estado = 'C'  WHERE id_cal = $id  ";
$result = mysqli_query($conn,$sql); 
header('Location: calendario.php');
?>