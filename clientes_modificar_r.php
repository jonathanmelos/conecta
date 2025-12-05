<?php 

include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$id = $_GET['id'];

// Consulta tabla clientes 

$sql = "SELECT * FROM clientes WHERE documento = $id"; 
$resultado = mysqli_query($conn,$sql);
if (mysqli_num_rows($resultado) > 0) {
 
    $Cli = mysqli_fetch_assoc($resultado);
	$documentoCLi = $Cli['documento']; 
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 
	$correo = $Cli['correo'];
	$direccion = $Cli['direccion'];
	$telefono = $Cli['telefono'];
	$suscripcion = $Cli['suscripcion'];
	
} else {
    echo "Registro no encontrado";
}


$query = "SELECT codigo, nombre FROM planes"; // Consulta SQL para obtener los valores de las filas "codigo" y "nombre"
$result = mysqli_query($conn, $query); // Ejecuta la consulta

include 'header.php';
?>
<body>

<form action="clientes_modificar_bd_r.php" method="post">
	<input type="hidden" name="documento" value="<?php echo $documentoCLi; ?>">
  <div class="form-group row">
	  	
    <label for="inputText3" class="col-sm-2 col-form-label" >Documento:</label>
    <div class="col-sm-10">
		<fieldset disabled>
      <input type="text" class="form-control" id="inputText3" placeholder="cédula / pasaporte" name="documentoCLi" value="<?php echo $documentoCLi; ?>"  required ><br>
			</fieldset>
	    </div>
		  
  </div>
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Nombre: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" value="<?php echo $nombre; ?>"  required ><br>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Apellido: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="apellido" name="apellido" value="<?php echo $apellido; ?>"  ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputText3" placeholder="correo" name="correo" value="<?php echo $correo; ?>" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="direccion" name="direccion" value="<?php echo $direccion; ?>" ><br>
    </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" value="<?php echo $telefono; ?>"  ><br>
    </div>	 
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Suscripción: </label>
    <div class="col-sm-10">
      <!--<input type="text" class="form-control" id="inputText3" placeholder="suscripcion" name="suscripcion" >-->
<select name="suscripcion" class="form-select" aria-label="Default select example">
  
 <?php
	
if (empty($suscripcion)) {
	 echo "<option value=''> no tiene plan</option>"; //
	
   while ($row = mysqli_fetch_assoc($result)) {
    $codigo = $row['codigo'];
    $plan = $row['nombre'];
    
        echo "<option value='" . $codigo . "'>" . $plan . "</option>"; // Crea un elemento option no seleccionado para el resultado actual
   }	
	
	
} else {
    while ($row = mysqli_fetch_assoc($result)) {
    $codigo = $row['codigo'];
    $plan = $row['nombre'];
    if ($codigo == $suscripcion) { // Verifica si el valor de $codigo es diferente al valor de $suscripcion
        echo "<option value='" . $codigo . "' selected>" . $plan . "</option>"; // Crea un elemento option para cada resultado
    }else {
        echo "<option value='" . $codigo . "'>" . $plan . "</option>"; // Crea un elemento option no seleccionado para el resultado actual
    }
}	
}	
			
		

			
?>	
	
</select>
		<br>
    </div>	 
  </div>	 
 
	 
 
 <div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit"  class="btn btn-warning btn-lg "  value="Actualizar Cliente">
</div> 	 
</form>

	

	

</body>
</html>