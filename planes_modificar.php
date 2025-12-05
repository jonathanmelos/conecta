<?php 
include 'conexion.php';
// Obtener el ID del registro a modificar
$id = $_GET['id'];

// Crear la consulta SQL para obtener los datos del registro
$consulta = "SELECT * FROM planes WHERE codigo = $id";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $consulta);

// Verificar si se encontró el registro
if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del registro
    $registro = mysqli_fetch_assoc($resultado);
	
include 'header.php'; 
?>
<!doctype html>
<body>
<div class="mb-3">

	
    <form action="planes_modificar_bd.php" method="post">
        <input type="hidden" name="id" value="<?php echo $registro['codigo']; ?>">
        <label for="exampleFormControlInput1" class="form-label">Nombre del Plan: </label>
		<input type="text" name="nombre" class="form-control" placeholder="modifica el nombre del Nuevo Plan" required value="<?php echo $registro['nombre']; ?>" >
        <label for="exampleFormControlInput1" class="form-label">Horas en Cowork: </label>
		<input type="number" name="cowork" class="form-control" value="<?php echo $registro['cowork']; ?>" >
        <label for="exampleFormControlInput1" class="form-label">Horas en Sala Reuniones:</label>
		<input type="number" name="sala_reuniones" class="form-control" value="<?php echo $registro['sala_reuniones']; ?>" >
        <label for="exampleFormControlInput1" class="form-label">Impresiones mensuales:</label>
		<input type="number" name="impresiones" class="form-control" value="<?php echo $registro['impresiones']; ?>" >
        <label for="exampleFormControlInput1" class="form-label">Horas evento Conecta:</label>
		<input type="number" name="evento" class="form-control" value="<?php echo $registro['evento']; ?>" >
	</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
	    <span class="input-group-text">Precio: $ </span>
  </div>
  <input type="text" name="precio" class="form-control" aria-label="Amount (to the nearest dollar)" required value="<?php echo $registro['precio']; ?>" >
</div>
 <div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit"  class="btn btn-warning btn-lg "  value="Actualizar Plan">
</div>       
       </form>
    <?php
} else {
    echo "Registro no encontrado";
}
?>	
	</div>	
</html>