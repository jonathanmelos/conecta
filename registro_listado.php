<?php
include 'conexion.php';
$sql = "SELECT * FROM registro";
$result = mysqli_query($conn,$sql);
include 'header.php';
?>

<table>
<tr><th>documento</th><th>entrada</th><th>salida</th><th>cantidad</th><th>servicio</th></tr>
<?php
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['documento'] . "</td>";
    echo "<td>" . $row['entrada'] . "</td>";
    echo "<td>" . $row['salida'] . "</td>";
    echo "<td>" . $row['cantidad'] . "</td>";
    echo "<td>" . $row['servicio'] . "</td>";
    echo "</tr>";
}

echo "</table>";

	
	
	
mysqli_close($conn);
?>
<a href="registro_registro.php">
    <button type="button" class="btn btn-warning">Nuevo registro</button>
</a>	

	
	
</body>
</html>