<?php

$servername = "localhost";
$database = "conecta";
$username = "root";
$password = "";

// Paso 1: crear una conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "conecta");

// Paso 2: crear una consulta SQL basada en el valor ingresado en el campo de búsqueda
if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    $sql = "SELECT * FROM clientes WHERE documento LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%';";
    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Buscador de clientes</title>
	<script>
		function buscarClientes() {
			// Obtener el valor de búsqueda ingresado por el usuario
			var busqueda = document.getElementById("busqueda").value;

			// Crear un objeto XMLHttpRequest para hacer la búsqueda en segundo plano
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					// Actualizar la tabla de resultados con los datos devueltos por el servidor
					document.getElementById("tabla-resultados").innerHTML = this.responseText;
				}
			};
			xhr.open("GET", "buscador.php?buscar=" + busqueda, true);
			xhr.send();
		}
	</script>
</head>
<body>

	<h2>Buscador de clientes</h2>

	<!-- Paso 4: crear un formulario que incluya un campo de búsqueda y un botón de enviar -->
	<form>
		<label for="busqueda">Buscar:</label>
		<input type="text" id="busqueda" name="busqueda">
		<button type="button" onclick="buscarClientes()">Buscar</button>
	</form>

	<!-- Paso 6: crear una tabla HTML y mostrar los resultados de la consulta SQL -->
	<?php if (isset($result)): ?>
		<table id="tabla-resultados">
			<tr>
				<th>Documento</th>
				<th>Nombre</th>
				<th>Apellido</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($result)): ?>
				<tr>
					<td><?php echo $row['documento']; ?></td>
					<td><?php echo $row['nombre']; ?></td>
					<td><?php echo $row['apellido']; ?></td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php endif; ?>

</body>
</html>
