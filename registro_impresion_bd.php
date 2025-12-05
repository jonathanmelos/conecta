<?php
include 'conexion.php';


$impresion = $_POST['impresion'];
$secuencial = $_POST['secuencial'];



$sql = "SELECT * FROM registro WHERE secuencial_R = $secuencial"; 
$resultado = mysqli_query($conn,$sql);
$Reg = mysqli_fetch_assoc($resultado);
$impresionBD = $Reg['cantidad'];


$sumaImp = $impresionBD + $impresion; 

$consulta = "UPDATE registro SET cantidad='$sumaImp' WHERE secuencial_R='$secuencial'";
$result = mysqli_query($conn, $consulta);
header('Location: registro.php');
?>