<?php
include('conexion.php');
$sec_lead = $_GET['sec_lead'];
$sql2 = "UPDATE leads SET nivel = 0 WHERE sec_lead = '$sec_lead' ";
$result2 = mysqli_query($conn,$sql2); 
header('Location: embudo.php');
?>