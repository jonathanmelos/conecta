<?php
include 'conexion.php';
include 'header.php'; 


?>

<div class="container">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Documento</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
       <th scope="col">Teléfono</th>
	  <th scope="col">Suscripción</th>
	  <th scope="col">Modificar</th>
	  	
    </tr>
  </thead>
   <tbody>
	   
	  <?php
	   
$sql = "SELECT * FROM clientes  WHERE estado = 'A'";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$suscripcion =$row['suscripcion']; 
	
	if (empty($suscripcion)) {
  
		 echo "<tr class='popper-row'>";
    echo "<th scope='row'>" . $row['documento'] . "</th>";
	echo "<td>" . $row['nombre'] . "</td>";
	echo "<td>" . $row['apellido'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>SIN PLAN</td>";
	
	echo "<td><a href='clientes_modificar_r.php?id=" . $row['documento'] . "'>
	<button class='btn btn-warning'>Modificar</button></a></td>";
	echo "</tr>";
		
}else{
		
		
    echo "<tr class='popper-row'>";
    echo "<th scope='row'>" . $row['documento'] . "</th>";
	echo "<td>" . $row['nombre'] . "</td>";
	echo "<td>" . $row['apellido'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td><a href='clientes_plan.php?id=" . $row['suscripcion'] . "&documento=".$row['documento']."'>
	<button class='btn btn-success'>Ver Plan</button></a></td>";
	
	echo "<td><a href='clientes_modificar_r.php?id=" . $row['documento'] . "'>
	<button class='btn btn-warning'>Modificar</button></a></td>";
	echo "</tr>";
}
}
echo  "<table class='table table-striped'>";
	   




mysqli_close($conn); // Cierra la conexión a la base de datos

	   
?>
   





<div class="d-grid gap-2 col-6 mx-auto">
	 <a href="clientes_registro.php">
    <button type="button" class="btn btn-primary  btn-lg">Crear nuevo cliente</button>
</a> 
    </div>	



</div>		
</body>
</html>
<script> 
var popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
  trigger: 'focus'
})
</script>
