<?php 

include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$id = $_GET['sec'];
$fecha =  $_GET['fecha'];
// Consulta tabla clientes 

$sql = "SELECT * FROM registro WHERE secuencial_R = $id"; 
$resultado = mysqli_query($conn,$sql);
$Reg = mysqli_fetch_assoc($resultado);
$documento = $Reg['documento']; 
$entrada = $Reg['entrada']; 
$salida = $Reg['salida']; 
$servicio = $Reg['servicio'];
$secuencial = $Reg['secuencial_R'];
$concluido = $Reg['concluido'];
$impresiones = $Reg['cantidad'];
$secP = $Reg['secuencial_planes'];
$invitado = $Reg['invitado'];



$sql2 = "SELECT * FROM clientes WHERE documento = $documento"; 
$resultado2 = mysqli_query($conn,$sql2);
$Reg = mysqli_fetch_assoc($resultado2);
$nombre = $Reg['nombre']; 
$apellido = $Reg['apellido']; 
$telefono = $Reg['telefono']; 




include 'header.php';
?>
<body>

<form action="registro_modificar_bd.php" method="post">
	<input type="hidden" name="secuencial" value="<?php echo $secuencial; ?>">
	<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
	<input type="hidden" name="documento" value="<?php echo $documento; ?>">
  <div class="form-group row">
	  	
    <label for="inputText3" class="col-sm-2 col-form-label" >Registro:</label>
    <div class="col-sm-10">
		<fieldset disabled>
      <input type="text" class="form-control" id="inputText3" placeholder="registro" name="registro" value="<?php echo $secuencial; ?>"  required ><br>
			</fieldset>
	    </div>
		  
  </div>
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Nombre: </label>
    <div class="col-sm-10">
		<fieldset disabled>
      <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" value="<?php echo $nombre; ?>"  required ><br>
			</fieldset>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Apellido: </label>
    <div class="col-sm-10">
		<fieldset disabled>
      <input type="text" class="form-control" id="inputText3" placeholder="apellido" name="apellido" value="<?php echo $apellido; ?>"  ><br>
			</fieldset>
    </div>
  </div>
<div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
    <div class="col-sm-10">
		<fieldset disabled>
      <input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" value="<?php echo $telefono; ?>"  ><br>
			</fieldset>
    </div>	
	<div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Impresiones: </label>
    <div class="col-sm-10">
		  <input type="number" class="form-control" id="inputText3" placeholder="impresiones" name="impresiones" value="<?php echo $impresiones; ?>" ><br>
    </div>	
		<br>
    </div>	 
  </div>	
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Hora Entrada: </label>
    <div class="col-sm-10">
      <input type="datetime-local" class="form-control" id="inputText3" placeholder="entrada" name="entrada" value="<?php echo $entrada; ?>" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Hora Salida: </label>
    <div class="col-sm-10">
		  <input type="datetime-local" class="form-control" id="inputText3" placeholder="salida" name="salida" value="<?php echo $salida; ?>" ><br>
    </div>
	</div>
	
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Servicio: </label>
    <div class="col-sm-10">
      <!--<input type="text" class="form-control" id="inputText3" placeholder="suscripcion" name="suscripcion" >-->
<select name="servicio" class="form-select" aria-label="Default select example">
  
 <?php

    if ($servicio == 'cowork') { 
        echo "<option value='cowork' selected>cowork</option>";
		echo "<option value='sala'>sala reuniones</option>";
		
    }else {
		echo "<option value='sala' selected>sala reuniones</option>";
        echo "<option value='cowork' >cowork</option>";
		
    }			

			
?>	
	
	
</select><br>
		
		
	 </div> 
	</div>
	 
	
	<?php 
	
	
if (empty($invitado)) {
echo "<div class='form-group row'>
<label for='inputText3' class='col-sm-2 col-form-label'> Elige un Plan:  </label>
<div class='col-sm-10'>
<select name='cargaP' class='form-select' aria-label='Default select example'>";

$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento' AND  planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f;";

$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$sec=$row['secuencial_planes'];
	$fechai=$row['fecha_i'];
	$nombre=$row['nombre'];
	if($sec==$secP){
		echo "<option value='$sec' selected>$nombre - $fechai</option>";
	}else{
	echo "<option value='$sec'>$nombre - $fechai</option>";
			
	}
}
}else{
	
$sql3 = "SELECT * FROM clientes WHERE documento = $invitado"; 
$resultado3 = mysqli_query($conn,$sql3);
$Reg3 = mysqli_fetch_assoc($resultado3);
$nom_invitado = $Reg3['nombre']." ".$Reg3['apellido'];

	
echo "<div class='form-group row'>
    <label for='inputText3' class='col-sm-2 col-form-label'> Elige un Plan de $nom_invitado :  </label>
    <div class='col-sm-10'>
    <select name='cargaP' class='form-select' aria-label='Default select example'>";	
	
$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$invitado' AND  planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f;";

$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$sec=$row['secuencial_planes'];
	$fechai=$row['fecha_i'];
	$nombre=$row['nombre'];
	if($sec==$secP){
		echo "<option value='$sec' selected>$nombre - $fechai</option>";
	}else{
	echo "<option value='$sec'>$nombre - $fechai</option>";
	
	}
}	
	
	
	
	
	
}	
	
echo "</select>";	

 echo "<input type='hidden' name='invitado' value='$invitado'>";		

	
	

// Consulta SQL
$query = "SELECT * FROM planes_registro WHERE documento = '$documento' AND fecha_f >= '$fecha'";

$result = $conn->query($query);
	
// Verificar si se encontraron filas
if ($result->num_rows > 0) {
 echo "Cliente con Plan";
 echo "<input type='hidden' name='cond_cargaP' value='1'>";	
} else {
  echo "Ciente sin Plan";
echo "<input type='hidden' name='cond_cargaP' value='0'>";	
}	

	
		?>	
	
		</div>
		</div> 
	
  	 
 
	 
 
 <div class="d-grid gap-2 col-6 mx-auto">
	  
    <br><input type="submit"  class="btn btn-warning btn-lg "  value="Modificar Registro">
</div> 	 
</form>

	

	

</body>
</html>