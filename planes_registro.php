<?php 
include 'header.php';
?>
<body>
<div class="mb-3">
	
<form action="planes_insertar.php" method="post">
    <label for="exampleFormControlInput1" class="form-label">Nombre del Plan: </label>
	<input type="text" name="nombre" class="form-control" placeholder="crea el nombre del Nuevo Plan" required >
	<label for="exampleFormControlInput1" class="form-label">Horas en Cowork: </label>
    <input type="number" name="cowork" class="form-control" >
	<label for="exampleFormControlInput1" class="form-label">Horas en Sala Reuniones:</label>
    <input type="number" name="sala_reuniones" class="form-control" >
	<label for="exampleFormControlInput1" class="form-label">Impresiones mensuales:</label>
    <input type="number" name="impresiones" class="form-control" >
	<label for="exampleFormControlInput1" class="form-label">Horas evento Conecta:</label>
    <input type="number" name="evento" class="form-control" >
	
    </div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
	    <span class="input-group-text">Precio: $ </span>
  </div>
  <input type="text" name="precio" class="form-control" aria-label="Amount (to the nearest dollar)" required >
</div>
	
	
<div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit" class="btn btn-primary btn-lg " value="Crear nuevo Plan">
</div>	
</form>

</div>


	
</body>
</html>