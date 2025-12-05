<?php
include 'conexion.php';
// Obtener el valor del parámetro id_plantilla desde la URL
$id_plantilla = $_GET['id_plantilla'];

// Realizar la consulta a la base de datos
$sql = "SELECT * FROM plantilla WHERE id_plantilla = $id_plantilla";
$result = $conn->query($sql);

// Obtener los resultados de la consulta
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  // Devolver los datos en formato JSON
  header('Content-Type: application/json');
  echo json_encode($row);
} else {
  echo "No se encontraron resultados";
}
?>
