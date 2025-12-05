<?php
// Conexión a la base de datos

include 'conexion.php';

// Obtener el ID del registro a eliminar
$id = $_GET['sec'];
$fecha2 = $_GET['fecha'];

$consulta = "UPDATE registro SET estado='E' WHERE secuencial_R='$id'";


// Ejecutar la consulta
if (mysqli_query($conn, $consulta)) {
   
} else {
    
}

header('Location: diario.php?fecha='. $fecha2);


?>