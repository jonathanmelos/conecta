<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
	
<?php
// Obtener el contenido del archivo JSON
$json = file_get_contents('buscar.php');

// Decodificar el contenido del archivo JSON
$datos = json_decode($json, true);

// Recorrer el arreglo de datos y mostrar los datos en una tabla
echo "<table>";
foreach ($datos as $dato) {
    echo "<tr>";
    echo "<td>" . $dato['documento'] . "</td>";
    echo "<td>" . $dato['nombre'] . "</td>";
    echo "<td>" . $dato['apellido'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>