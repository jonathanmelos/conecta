<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$cowork = $_POST['cowork'];
$sala_reuniones = $_POST['sala_reuniones'];
$impresiones = $_POST['impresiones'];
$evento = $_POST['evento'];
$precio = $_POST['precio'];

// Crear la consulta SQL para actualizar el registro
$consulta = "UPDATE planes SET nombre = '$nombre', cowork = '$cowork', sala_reuniones = '$sala_reuniones', impresiones = '$impresiones', evento = '$evento', precio = '$precio' WHERE codigo = $id";

// Ejecutar la consulta
if (mysqli_query($conn, $consulta)) {
   
} else {
    
}
header('Location: planes.php');
?>