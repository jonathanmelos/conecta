<?php
include 'conexion.php';
$sec_lead = $_GET['id'];
$estado = $_GET['estado'];


	$sql = "UPDATE leads SET
            estado = '$estado'
        WHERE sec_lead = '$sec_lead'";

mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: embudo.php');


?>