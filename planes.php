<?php
include 'conexion.php';
$sql = "SELECT * FROM planes";
$result = mysqli_query($conn,$sql);
include 'header.php'; 
?>


<div class="container">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Plan</th>
      <th scope="col">Horas Cowork</th>
      <th scope="col">Horas Sala Reuniones</th>
      <th scope="col">Impresiones</th>
	  <th scope="col">Evento</th>
	  <th scope="col">Precio</th>
	  <th scope="col">Modificar</th>
	  <th scope="col">Eliminar</th>	
		
    </tr>
  </thead>
  <tbody>
	  <?php
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
    echo "<td>" . $row['cowork'] . "</td>";
    echo "<td>" . $row['sala_reuniones'] . "</td>";
    echo "<td>" . $row['impresiones'] . "</td>";
    echo "<td>" . $row['evento'] . "</td>";
    echo "<td>" . $row['precio'] . "</td>";
	echo "<td><a href='planes_modificar.php?id=" . $row['codigo'] . "'>
	<button class='btn btn-warning'>Modificar</button></a></td>";
	
	echo "<td><a href='planes_eliminar.php?id=" . $row['codigo'] . "'>
	<button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "</tr>";
	
}

echo "</table>";

mysqli_close($conn);
?>
  
  </tbody>
</table>	
	
<div class="d-grid gap-2 col-6 mx-auto">
	 <a href="planes_registro.php">
    <button type="button" class="btn btn-primary btn-lg">Crear nuevo plan</button>
</a> 
    </div>		

</div>	
	</body>
</html>


	