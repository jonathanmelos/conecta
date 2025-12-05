<?php
include 'conexion.php';
include 'header.php'; 


?>

<div class="container">
  <div class="row">
    <div class="col-md-5 col-lg-9"> 
      <form action="reporte_cliente_registros.php" method="post" autocomplete="off">
        <div class="form-group row">
          <label for="inputText3" class="col-sm-2 col-form-label">Cliente:</label>
          <div class="col-sm-5">
            <input type="text" id="documento" class="form-control" placeholder="buscar cliente" onkeyup="doSearch()">
            <br> 
          </div>	
        </div>	 
      </form>	
    </div>	 
    <div class="col-md-5 col-lg-3">	
      <a href="clientes_registro.php">
        <button type="button" class="btn btn-primary btn-lg">Crear nuevo cliente</button>
      </a> 
    </div>	
  </div>
<table class="table table-striped" id="tabla-clientes">
  <thead>
    <tr>
      <th scope="col">Documento</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
       <th scope="col">Teléfono</th>
	   <th scope="col">Modificar</th>
	  <th scope="col">Eliminar</th>	
		
    </tr>
  </thead>
   <tbody>
	   
	  <?php
	   
$sql = "SELECT * FROM clientes  WHERE estado = 'A'";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$suscripcion =$row['suscripcion']; 
	
	if (empty($suscripcion)) {
  
	echo "<tr class='popper-row' id='cliente-".$row['documento']."'>";
    echo "<th scope='row'>" . $row['documento'] . "</th>";
	echo "<td>" . $row['nombre'] . "</td>";
	echo "<td>" . $row['apellido'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td><a href='clientes_plan.php?id=" . $row['suscripcion'] . "&documento=".$row['documento']."'>
	<button class='btn btn-primary'>SUSCRIBIR</button></a></td>";
	
	echo "<td><a href='clientes_modificar.php?id=" .$row['documento'] . "'>
	<button class='btn btn-warning'>Modificar</button></a></td>";
	echo "<td><a href='clientes_eliminar.php?id=" . $row['documento'] . "'>
	<button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "</tr>";
		
}else{
		
		
    echo "<tr class='popper-row' id='cliente-".$row['documento']."'>";
    echo "<th scope='row'>" . $row['documento'] . "</th>";
	echo "<td>" . $row['nombre'] . "</td>";
	echo "<td>" . $row['apellido'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td><a href='clientes_plan.php?id=" . $row['suscripcion'] . "&documento=".$row['documento']."'>
	<button class='btn btn-success'>VER PLAN</button></a></td>";
	
	echo "<td><a href='clientes_modificar.php?id=" . $row['documento'] . "'>
	<button class='btn btn-warning'>Modificar</button></a></td>";
	echo "<td><a href='clientes_eliminar.php?id=" . $row['documento'] . "'>
	<button class='btn btn-danger' >Eliminar</button></a></td>";
	echo "</tr>";
}
}
	   

mysqli_close($conn); // Cierra la conexión a la base de datos
	   
?>
   
</tbody>
</table>







</div>		
</body>
</html>
<script> 
function doSearch() {
  var search = document.getElementById('documento').value.toLowerCase();
  var rows = document.querySelectorAll('#tabla-clientes tbody tr');

  for (var i = 0; i < rows.length; i++) {
    var documento = rows[i].querySelector('th').textContent.toLowerCase();
    var nombre = rows[i].querySelector('td:nth-child(2)').textContent.toLowerCase();
    var apellido = rows[i].querySelector('td:nth-child(3)').textContent.toLowerCase();

    if (documento.includes(search) || nombre.includes(search) || apellido.includes(search)) {
      rows[i].style.display = '';
    } else {
      rows[i].style.display = 'none';
    }
  }
}


</script>

