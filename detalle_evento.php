<?php
date_default_timezone_set('America/Guayaquil'); // Establecer la zona horaria a America/Guayaquil
include 'conexion.php';
include 'header.php'; 
$fecha=$_GET['fecha'];
setlocale(LC_TIME, 'es_ES'); // Establecer el locale en español
$timestamp = strtotime($fecha); // Convertir la fecha a un timestamp
$nombreDia = strftime('%A', $timestamp); // Obtener el nombre completo del día en español

?>

<div class="container">
<div class="row">
<div class="col-md-5 col-lg-9"> 
	<h3><?php echo $nombreDia."&nbsp;&nbsp; ".$fecha ?></h3><br>
	</div>	
	</div>
  <div class="row">
    <div class="col-md-5 col-lg-9"> 
      <form action="reporte_cliente_registros.php" method="post" autocomplete="off">
        <div class="form-group row">
          <label for="inputText3" class="col-sm-2 col-form-label">Evento:</label>
          <div class="col-sm-5">
            <input type="text" id="documento" class="form-control" placeholder="buscar evento" onkeyup="doSearch()">
            <br> 
          </div>	
        </div>	 
      </form>	
    </div>	 
    <div class="col-md-5 col-lg-3">	
      <a href="clientes_registro.php">
        <!--<button type="button" class="btn btn-primary btn-lg">Mail Masivo</button>-->
      </a> 
    </div>	
  </div>
<table class="table table-striped" id="tabla-clientes">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Motivo</th>
       <th scope="col">Teléfono</th>
	  <th scope="col">Mensaje</th>	
	<th scope="col">Acción</th>		
		
    </tr>
  </thead>
   <tbody>
	   
	  <?php
	   
$sql = "SELECT * FROM `calendario` WHERE `fecha` LIKE '%$fecha%' AND estado = 'P'ORDER BY `fecha` ASC ";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$accion =$row['accion']; 
	if ($accion=="ll"){
		echo "<tr class='popper-row' id='cliente-".$row['id_cal']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
	echo "<td>" . $row['motivo'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $row['mensaje'] . "</td>";	
	echo "<td><a href='telf.php?id=" .$row['id_cal'] ."&sec_lead=".$row['sec_lead']."'>
	<button class='btn btn-warning'>Llamada telf</button></a></td>";
	echo "</tr>";
	}elseif($accion=="wp"){
		
		echo "<tr class='popper-row' id='cliente-".$row['id_cal']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
	echo "<td>" . $row['motivo'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $row['mensaje'] . "</td>";	
  echo "<td><a href='wp.php?id=" .$row['id_cal'] ."&sec_lead=".$row['sec_lead']."'>
  <button class='btn btn-success'>Ev Whatasapp</button></a></td>";
	echo "</tr>";
	}elseif($accion=="co"){
		
		echo "<tr class='popper-row' id='cliente-".$row['id_cal']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
	echo "<td>" . $row['motivo'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $row['mensaje'] . "</td>";	
  echo "<td><a href='correo.php?id=" .$row['id_cal'] ."&sec_lead=".$row['sec_lead']."'>
	<button class='btn btn-primary'>Enviar Correo</button></a></td>";
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

