<?php 
date_default_timezone_set('America/Guayaquil');
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$fecha = date('Y-m-d');
$query = "SELECT codigo, nombre FROM planes"; // Consulta SQL para obtener los valores de las filas "codigo" y "nombre"
$result = mysqli_query($conn, $query); // Ejecuta la consulta

include 'header.php';
?>
<body>

<form action="clientes_insertar.php" method="post">
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label" >Documento:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="cédula / pasaporte" name="documento" required ><br>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Nombre: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" required><br>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Apellido: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="apellido" name="apellido" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputText3" placeholder="correo" name="correo" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="direccion" name="direccion" ><br>
    </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" ><br>
    </div>	 
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Suscripción: </label>
    <div class="col-sm-10">
      <!--<input type="text" class="form-control" id="inputText3" placeholder="suscripcion" name="suscripcion" >-->
		<select name="suscripcion" class="form-select" aria-label="Default select example">
  <option selected   >Elige un plan</option>
 <?php

while ($row = mysqli_fetch_assoc($result)) { // Recorre los resultados de la consulta
    echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>"; 
	// Crea un elemento option para cada resultado
}
?>	
</select>
		<br>
    </div>	 
  </div>	 
	 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Fecha de Inicio: </label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="inputText3" placeholder="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha ?>"><br>
    </div>	 
  </div>
	 
 
<div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit" class="btn btn-primary btn-lg " value="Registar Cliente Plan">
</div>	
	 
	 
</form>

	

	

</body>
</html>