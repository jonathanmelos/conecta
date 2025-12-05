<?php 
include 'conexion.php';
include 'header.php';
$ld = $_GET['ld'];
?>
<div class="container">
	<div class="row">	
	<div class="col-md-7 col-lg-6">
<h4 class="d-flex justify-content-between align-items-center mb-3"> 
		<span class="text-primary">Organizar llamada:  </span></h4> <br>
		
<form action="p_llamada_in.php" method="post">
	<input type="hidden" class="form-control" id="accion" name="accion" value="ll" >
  	<div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Fecha</label>
    <div class="form-group col-md-8">
       <input type="datetime-local" class="form-control" id="fecha" name="fecha" >
	</div>
  </div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label"> Motivo </label>
    <div class="form-group col-md-8">	
    <input type="text" class="form-control" id="motivo" name="motivo" >
	<small id="emailHelp" class="form-text text-muted">Por qué o para qué se va a llamar </small>
    </div>
</div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Mensaje</label>
    <div class="form-group col-md-8">	
    <input type="text" class="form-control" id="mensaje" name="mensaje" >
	<small id="emailHelp" class="form-text text-muted">Qué mensaje queremos comunicar </small> 
	</div>
  </div>
<div class="form-group row">
    <div class="form-group col-md-12">
		<br>
      <button type="submit" class="btn btn-primary btn-lg btn-block ">Programar Llamada</button>		
	</div>
 </div>	

	
	
			
		</div>
	<div class="col-md-5 col-lg-6 order-md-last">
	<h4 class="d-flex justify-content-between align-items-center mb-3"> 
		<span class="text-primary">Programar llamada a:  </span></h4>	
		


<?php
echo "
<br>


<table class='table table-striped' id='tabla-clientes'>
  <thead>
    <tr>
	  <th scope='col'>Aprobar</th>	
      <th scope='col'>Nombre</th>
      <th scope='col'>Teléfono</th>
	  <th scope='col'>Estado</th>
	  <th scope='col'>Medio</th>	
		
    </tr>
  </thead>
   <tbody>

";
$sql = "SELECT * FROM leads WHERE estado = '$ld' AND nivel <100 AND telefono IS NOT NULL AND telefono <> ''";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$sec_lead = $row['sec_lead'];
	$estado =$row['estado'];

	if($estado == 'PR'){
		$estado_v = 'Prospecto';
		}
	
	elseif($estado == 'CT'){
		$estado_v = 'Contacto';

		}
	elseif($estado == 'CL'){
		$estado_v = 'Cliente';

		}
	$medio =$row['medio'];
	if($medio == 'fb'){
		$medio_v = 'Facebook';
		}
	elseif($medio == 'in'){
		$medio_v = 'Instagram';
		}
	elseif($medio == 'tk'){
		$medio_v = 'Tiktok';
		}
	elseif($medio == 'web'){
		$medio_v = 'Web';
		}
	elseif($medio == 'wp'){
		$medio_v = 'Whatsapp';
		}	
	
	elseif($medio == 'rf'){
		$medio_v = 'Referido';
		}
	elseif($medio == 'ot'){
		$medio_v = 'otro';
		}	
	
	
	echo "<tr class='popper-row' id='cliente-".$row['sec_lead']."' onclick=\"toggleCheckbox('checkbox-".$row['sec_lead']."')\" >";
    echo "<td><input type='checkbox' name='clientes[]' value='".$row['sec_lead']."'  id='checkbox-".$row['sec_lead']."'  checked></td><th scope='row'>" . $row['nombre'] . "</th>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $estado_v . "</td>";
	echo "<td>" . $medio_v . "</td>";	
	echo "</tr>";
}
   
echo "</tbody>
</table>"

	   
?>	
</form>		
	<script>
function toggleCheckbox(checkboxId) {
  var checkbox = document.getElementById(checkboxId);
  checkbox.checked = !checkbox.checked;
}
</script>	
		</div>	
		</div>
	</div>
</html>