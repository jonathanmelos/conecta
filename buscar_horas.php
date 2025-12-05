<?php

include 'conexion.php';

// Obtener los valores de los campos de entrada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determinar el valor del límite en función de la longitud de la cadena de búsqueda
if (strlen($search) == 3) {
    $limit = 10;
} elseif (strlen($search) == 4) {
    $limit = 5;
} else {
    $limit = 3;
}

// Preparar una sentencia SQL para buscar en la tabla clientes
$stmt = $conn->prepare("SELECT documento, nombre, apellido FROM clientes WHERE documento LIKE CONCAT('%', ?, '%') OR nombre LIKE CONCAT('%', ?, '%') OR apellido LIKE CONCAT('%', ?, '%') LIMIT ?");
$stmt->bind_param("sssi", $search, $search, $search, $limit);

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