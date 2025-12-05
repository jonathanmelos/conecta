<?php

include 'conexion.php';
// Obtener los valores de los campos de entrada
$documento = isset($_GET['documento']) ? $_GET['documento'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';



// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparar una sentencia SQL para buscar en la tabla clientes
$stmt = $conn->prepare("SELECT documento, nombre, apellido FROM clientes WHERE documento LIKE CONCAT('%', ?, '%') AND nombre LIKE CONCAT('%', ?, '%') AND apellido LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("sss", $documento, $nombre, $apellido);

// Ejecutar la sentencia SQL
$stmt->execute();

// Vincular el resultado a variables
$stmt->bind_result($documentoResult, $nombreResult, $apellidoResult);

// Crear un arreglo para almacenar los resultados
$results = [];

// Obtener todos los resultados
while ($stmt->fetch()) {
    // Agregar el resultado al arreglo
    $results[] = [
        'documento' => $documentoResult,
        'nombre' => $nombreResult,
        'apellido' => $apellidoResult,
    ];
}

// Devolver los resultados en formato JSON
header('Content-Type: application/json');
echo json_encode($results);

// Cerrar la sentencia y la conexión
$stmt->close();
$conn->close();

?>