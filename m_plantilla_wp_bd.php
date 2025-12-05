<?php 
include 'conexion.php';
$info =  $_POST['info'];
$id =  $_POST['id'];

$sql = "UPDATE plantilla SET info = '$info' WHERE id_plantilla = '$id'";
mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: plantilla_wp.php');

?>