<?php
// Conexión a la base de datos

include 'conexion.php';

// Obtener el ID del registro a eliminar
$id = $_GET['id'];

// Crear la consulta SQL para eliminar el registro
$consulta = "DELETE FROM clientes WHERE documento = $id";

$consulta = "UPDATE clientes SET estado='E' WHERE documento='$id'";
$result = mysqli_query($conn, $consulta);

// Ejecutar la consulta
if (mysqli_query($conn, $consulta)) {
   
} else {
    
}

header('Location: clientes.php');


?>