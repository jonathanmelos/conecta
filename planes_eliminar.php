<?php
// Conexión a la base de datos

include 'conexion.php';

// Obtener el ID del registro a eliminar
$id = $_GET['id'];

// Crear la consulta SQL para eliminar el registro
$consulta = "DELETE FROM planes WHERE codigo = $id";

// Ejecutar la consulta
if (mysqli_query($conn, $consulta)) {
   
} else {
   
}

header('Location: planes.php');


?>