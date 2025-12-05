<?php
//variables get
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
include 'header.php'; 
$fechaActual = date('Y-m-d');
$documento = $_POST['documento'];


// Consulta tabla clientes 

$sql = "SELECT * FROM clientes WHERE documento = $documento" ; 
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
 
    $Cli = mysqli_fetch_assoc($result);
	$documentoCLi = $Cli['documento']; 
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 
	$correo = $Cli['correo'];
	$direccion = $Cli['direccion'];
	$telefono = $Cli['telefono'];
	$suscripcion = $Cli['suscripcion'];
	$fechaCli = $Cli['fecha'];
	
} else {
    echo "Registro no encontrado";
}

// Consulta tabla planes registro
$consultaP = "SELECT * FROM planes_registro WHERE documento = $documento";
$resultadoP = mysqli_query($conn, $consultaP);
     $registroP = mysqli_fetch_assoc($resultadoP);
	$fecha_i = $registroP['fecha_i']; 
    $fecha_f = $registroP['fecha_f']; 
?> 
<div class="container">
 <div class="row">
    <div class="col-md-7 col-lg-4">
        <h4 class="mb-3">Datos del Cliente</h4>
        <form class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
			<fieldset disabled>
              <label for="firstName" class="form-label">Nombre</label>
              <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $nombre ?>">
             </fieldset>
            </div>

            <div class="col-sm-6">
			<fieldset disabled>	
              <label for="lastName" class="form-label">Apellido</label>
               <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $apellido ?>">
              </fieldset>
            </div>
			<div class="col-12">
			<fieldset disabled>	
              <label for="address" class="form-label">Documento</label>
              <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $documento ?>">
			</fieldset>	
             </div>
           <div class="col-12">
			<fieldset disabled>	
              <label for="address" class="form-label">Correo</label>
              <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $correo ?>">
			</fieldset>	
             </div>
			 <div class="col-12">
			<fieldset disabled>	
              <label for="address" class="form-label">Dirección</label>
              <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $direccion ?>">
			</fieldset>	
             </div>  
 			<div class="col-12">
			<fieldset disabled>	
              <label for="address" class="form-label">Teléfono</label>
              <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $telefono ?>">
			</fieldset>	
             </div> 
                    
            
          </div>

          
         </form>
      </div>



<?php

if (empty($suscripcion)) {
  echo "<div class='col-md-5 col-lg-8 order-md-last'>
        <h4 class='d-flex justify-content-between align-items-center mb-3'>
          <span class='text-primary'>Cliente Sin Plan</span>
           </h4>
	<div>";	
} 

else 

{ 
echo "<div class='col-md-5 col-lg-8 order-md-last'>
    <h4 class='d-flex justify-content-between align-items-center mb-3'>
        <span class='text-primary'>Historial Planes </span>
    </h4>	
    

    <ul class='list-group mb-3'>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
<table  class='table table-hover'> <thead> <tr> 
<th scope='col'>COD</th> 
<th scope='col'>Plan</th> 
<th scope='col'>Fecha Inicio</th> 
<th scope='col'>Fecha Fin</th> 
</tr> </thead> 
<tbody>";

$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.fecha_i, planes_registro.fecha_f , planes.nombre 
FROM planes_registro
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento  = '$documento' 
ORDER BY planes_registro.fecha_i ASC";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	$cod=$row['secuencial_planes'];
	$nombre=$row['nombre'];
	$fi = $row['fecha_i'];
	$ff = $row['fecha_f'];

echo "
<tr onclick=\"window.location.href='reporte_detalle_r.php?documento=$documento&sec=$cod';\" > 
<th scope='row'>$cod</th> 
<td>$nombre</td> 
<td>$fi</td> 
<td>$ff</td> 
</tr>" ;
}
echo "	
</tbody> 
	</table>
        </li>
    </ul>
</div>"	;

}
				

mysqli_close($conn); 
	   
?>

</div>	 
   
</div>


</body>
 
</html>

