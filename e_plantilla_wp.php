<?php
include 'conexion.php';
$id = $_GET['id'];

$sql = "DELETE FROM plantilla WHERE id_plantilla  = '$id'";

mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: plantilla_wp.php');

?>