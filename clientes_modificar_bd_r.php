<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$suscripcion = $_POST['suscripcion'];

 

$consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', correo='$correo', direccion='$direccion', telefono='$telefono', suscripcion='$suscripcion' WHERE documento='$documento'";
$result = mysqli_query($conn, $consulta);



if (mysqli_query($conn, $consulta)) {
  
} else {
    
}
header('Location: clientes_r.php');


?>