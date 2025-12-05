<?php
//variables get
date_default_timezone_set('America/Guayaquil');
include 'conexion.php';
$fechaActual =  date('Y-m-d');
$documento = $_GET['documento'];
$id = $_GET['id'];
include 'header.php'; 
		
// Consulta tabla clientes 

$sql = "SELECT * FROM clientes WHERE documento = $documento"; 
$result = mysqli_query($conn,$sql);


    $Cli = mysqli_fetch_assoc($result);
	$documentoCLi = $Cli['documento']; 
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 
	$correo = $Cli['correo'];
	$direccion = $Cli['direccion'];
	$telefono = $Cli['telefono'];
	$fechaCli = $Cli['fecha'];
	$suscripcion = $Cli['suscripcion'];


?>

<div class="container">
 <div class="row">
    <div class="col-md-7 col-lg-8">
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
	<div class='col-md-5 col-lg-4 order-md-last'>

	<?php 
	if (empty($suscripcion)) {
		echo "<div class='col-md-5 col-lg-8 order-md-last'>
			  
		  <div>";	
	  } 
	  
	  else { 
	  echo "<div class='col-md-5 col-lg-8 order-md-last'>
		  <h4 class='d-flex justify-content-between align-items-center mb-3'>
			  <span class='text-primary'>Historial Planes </span>
		  </h4>	
		  
	  

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
       
</div>"	;
	}
	?>
	<h4 class='d-flex justify-content-between align-items-center mb-3'>
        <span class='text-primary'>Planes Vigentes </span>
    </h4>	
	 <div class='col-sm-12'>	
	<a class='btn btn-primary btn-lg btn-block' href='clientes_plan_n.php?id=<?php echo $documentoCLi ?>' role='button'>Nuevo plan</a>
		</div><br>
<?php
	
$sql7 = "SELECT *  FROM planes_registro WHERE fecha_i > '$fechaActual' AND  documento = '$documento';";
$result7 = mysqli_query($conn,$sql7);
$consulta7 =mysqli_num_rows($result7);					 
	
if(empty($consulta7)) {

$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento' AND  planes_registro.estado = 'A' AND '$fechaActual' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f;";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	
	//tabla registro_planes
	$sec=$row['secuencial_planes'];
	$cod=$row['codigo'];
	$fi=$row['fecha_i'];
	$ff=$row['fecha_f'];
		
	//tabla planes	
	$n=$row['nombre'];
	$co=$row['cowork'];
	$sr=$row['sala_reuniones'];
	$i=$row['impresiones'];
	$e=$row['evento'];
	$p=$row['precio'];
	
	// Función para colocar la fecha actualizada en palabras
	$fecha = new DateTime($ff);
	setlocale(LC_TIME, 'es_MX');
	$fechaprox = strftime('%d de %B de %Y', $fecha->getTimestamp());
	
	// Calculo Impresiones

	$date = new DateTime($fechaActual);
	$date->modify('+1 day');
	$fechaSumada = $date->format('Y-m-d');
	$sql4 = "SELECT SUM(cantidad) AS total FROM `registro` WHERE `documento` = '$documento' AND `secuencial_planes` = '$sec' AND `entrada` BETWEEN '$fi' AND '$ff' AND estado NOT LIKE 'E'";
	
	$result4 = $conn->query($sql4);
    $row = $result4->fetch_assoc();
    $totalImpresiones = $row['total'];
    $ImpresionesDif = $i-$totalImpresiones; 
	
	//Calculo horas Cowork
	$sql3 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$documento' AND `secuencial_planes` = '$sec'";
	$result3 = mysqli_query($conn, $sql3);
	$total_segundos = mysqli_fetch_assoc($result3)['total_segundos'];
	$hours = floor($total_segundos / 3600);
    $minutes = floor(($total_segundos % 3600) / 60);
    $tiempo_usadoCW = sprintf('%02d:%02d', $hours, $minutes);
  	
	//Resta horas contratadas por usadas 
	$co_segundos = $co * 3600;
	$dif_segCW = $co_segundos - $total_segundos;
	$hoursDCW = floor($dif_segCW / 3600);
	$minutesDCW = floor(($dif_segCW % 3600) / 60);
	$tiempo_difCW = sprintf('%02d:%02d', $hoursDCW, $minutesDCW);
	
		//Calculo horas Sala Reuniones
	$sql5 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'sala' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$documento' AND `secuencial_planes` = '$sec'";
	$result5 = mysqli_query($conn, $sql5);
	$total_segundosS = mysqli_fetch_assoc($result5)['total_segundos'];
	$hoursS = floor($total_segundosS / 3600);
    $minutesS = floor(($total_segundosS % 3600) / 60);
    $tiempo_usadoS = sprintf('%02d:%02d', $hoursS, $minutesS);
  	
	//Resta horas contratadas por usadas 
	$sr_segundos = $sr * 3600;
	$dif_segSR = $sr_segundos - $total_segundosS;
	$hoursSR = floor($dif_segSR / 3600);
	$minutesSR = floor(($dif_segSR % 3600) / 60);
	$tiempo_difSR = sprintf('%02d:%02d', $hoursSR, $minutesSR);
	
	//dias restantes para terminar el plan 
	$fechaActualD = new DateTime($fechaActual);
	$fechaproxD = new DateTime($ff);
	$diferencia = $fechaActualD->diff($fechaproxD);
	$dias_restantes = $diferencia->days;
	
	$detalle = "<a class='btn btn-outline-info' href='detalle_registro.php?documento=$documentoCLi&sec=$sec' role='button'>Detalle Registro</a>";
	$modificar = "<a class='btn btn-info' href='clientes_plan_mod.php?documento=$documentoCLi&sec=$sec' role='button'>Modificar</a>";
	
	if($dias_restantes<5){
		
		$dias_termina = "<b class='text-danger'>$dias_restantes</b>";
		$boton_termina = "<a class='btn btn-outline-success' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";
	}elseif ($dias_restantes > 5 && $dias_restantes < 10){
		$dias_termina = "$dias_restantes";
		$boton_termina = "<a class='btn btn-outline-warning' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";
	}else{
		$dias_termina = "$dias_restantes";
		$boton_termina = "<a class='btn btn-outline-danger' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";		
	}

		
	echo "
    
    <ul class='list-group mb-3'>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h3 class='my-0'> $n $modificar </h3>
				
                	 <small class='text-body-secondary'>Vencimiento mensual el: <br> $fechaprox <br>
				  </small>
				  $detalle
				  <br> 
				  
			<h6 class='my-0'> <br>Faltan $dias_termina días para concluir el plan </h6>				  
				  <div class='row g-3'>
				  <div class='col-sm-12'>
				  $boton_termina
				  </div>
				  </div> 
		</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en COWORK</h6>
        <span class='text-body-secondary'>
            Contratadas:  $co:00 
            <br>Usadas:  $tiempo_usadoCW 
            <br>Restantes: $tiempo_difCW
        </span>
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en Sala Reuniones</h6>
        <span class='text-body-secondary'>
            Contratadas: $sr:00</span>
        <br>Usadas:  $tiempo_usadoS
        <br>Restantes: $tiempo_difSR 
    </div>
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Cantidad Impresiones</h6>
        <span class='text-body-secondary'>
            Contratadas: $i </span>
        <br>Usadas:  $totalImpresiones
        <br>Restantes:  $ImpresionesDif  
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Eventos Connecta</h6>
    </div>
    <span class='text-body-secondary'>$e</span>
</li>
<li class='list-group-item d-flex justify-content-between'>
    <span>Precio</span>
    <strong> $p </strong>
</li>
</ul>";
	
}	
	
}
else
{
	
$sql8F = "SELECT *  FROM planes_registro WHERE fecha_i > '$fechaActual' AND  documento = '$documento';";
$result8F = mysqli_query($conn,$sql8F);
$RegPF = mysqli_fetch_assoc($result8F);
$secPlanF = $RegPF['secuencial_planes']; 	

$sqlCEF = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.secuencial_planes = '$secPlanF' ;";

$resultCEF = mysqli_query($conn,$sqlCEF);	  
while($rowF = mysqli_fetch_assoc($resultCEF)) {

	//tabla registro_planes
	$secF=$rowF['secuencial_planes'];
	$codF=$rowF['codigo'];
	$fiF=$rowF['fecha_i'];
	$ffF=$rowF['fecha_f'];

	//tabla planes	
	$nF=$rowF['nombre'];
	$coF=$rowF['cowork'];
	$srF=$rowF['sala_reuniones'];
	$iF=$rowF['impresiones'];
	$eF=$rowF['evento'];
	$pF=$rowF['precio'];

	// Función para colocar la fecha actualizada en palabras
	$fechaiF = new DateTime($fiF);
	setlocale(LC_TIME, 'es_MX');
	$fechainiF = strftime('%d de %B de %Y', $fechaiF->getTimestamp());

	// Función para colocar la fecha actualizada en palabras
	$fechaF = new DateTime($ffF);
	setlocale(LC_TIME, 'es_MX');
	$fechaproxF = strftime('%d de %B de %Y', $fechaF->getTimestamp());

	// Calculo Impresiones

	$dateF = new DateTime($fechaActual);
	$dateF->modify('+1 day');
	$fechaSumadaF = $dateF->format('Y-m-d');
	$sql4F = "SELECT SUM(cantidad) AS total FROM `registro` WHERE `documento` = '$documento' AND `secuencial_planes` = '$secF' AND `entrada` BETWEEN '$fiF' AND '$ffF' AND estado NOT LIKE 'E'";

	$result4F = $conn->query($sql4F);
    $rowF = $result4F->fetch_assoc();
    $totalImpresionesF = $rowF['total'];
    $ImpresionesDifF = $iF-$totalImpresionesF; 

	//Calculo horas Cowork
	$sql3F = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork' AND `fecha` BETWEEN '$fiF' AND '$ffF' AND `documento` = '$documento' AND `secuencial_planes` = '$secF'";
	$result3F = mysqli_query($conn, $sql3F);
	$total_segundosFF = mysqli_fetch_assoc($result3F)['total_segundos'];
	$hoursFF = floor($total_segundosFF / 3600);
    $minutesFF = floor(($total_segundosFF % 3600) / 60);
    $tiempo_usadoCWF = sprintf('%02d:%02d', $hoursFF, $minutesFF);

	//Resta horas contratadas por usadas 
	$co_segundosFF = $coF * 3600;
	$dif_segCWF = $co_segundosFF - $total_segundosFF;
	$hoursDCWF = floor($dif_segCWF / 3600);
	$minutesDCWF = floor(($dif_segCWF % 3600) / 60);
	$tiempo_difCWF = sprintf('%02d:%02d', $hoursDCWF, $minutesDCWF);

    //Calculo horas Sala Reuniones
    $sql5FF= "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'sala' AND `fecha` BETWEEN '$fiF' AND '$ffF' AND `documento` = '$documento' AND `secuencial_planes` = '$secF'";
    $result5FF= mysqli_query($conn, $sql5FF);
    $total_segundosSF= mysqli_fetch_assoc($result5FF)['total_segundos'];
    $hoursSF= floor($total_segundosSF / 3600);
    $minutesSF= floor(($total_segundosSF % 3600) / 60);
    $tiempo_usadoSF= sprintf('%02d:%02d', $hoursSF, $minutesSF);

    //Resta horas contratadas por usadas 
    $sr_segundosFF= $srF * 3600;
    $dif_segSRFF= $sr_segundosFF - $total_segundosSF;
    $hoursSRFF= floor($dif_segSRFF / 3600);
    $minutesSRFF= floor(($dif_segSRFF % 3600) / 60);
    $tiempo_difSRFF= sprintf('%02d:%02d', $hoursSRFF, $minutesSRFF);

    //dias restantes para terminar el plan 
    $fechaActualDF= new DateTime($fechaActual);
    $fechaproxDF= new DateTime($ffF);
    $diferenciaFF= $fechaActualDF->diff($fechaproxDF);
    $dias_restantesFF= $diferenciaFF->days;
	
	$detalle2 = "<a class='btn btn-outline-warning' href='plan_iniciar.php?sec=$secPlanF' role='button'>Iniciar Plan</a>";
	
    if($dias_restantesFF<5){
$dias_terminaF = "<b class='text-danger'>$dias_restantesFF</b>";
$boton_terminaF = "<a class='btn btn-outline-danger' href='clientes_plan_reno.php?id=$documentoF&cod=$codF' role='button'>Renovar</a>";
}elseif ($dias_restantesFF > 5 && $dias_restantesFF < 10){
    $dias_terminaF = "$dias_restantesF";
    
}else{
    $dias_terminaF = "$dias_restantesFF";
   		
}

	
echo "
<ul class='list-group mb-3'>
    <li class='list-group-item d-flex justify-content-between lh-sm'>
        <div>
            <h3 class='my-0'> $nF </h3>
            <h5 class='my-0'> INCIA EL $fechainiF </h5>
            <small class='text-body-secondary'>Vencimiento mensual el: <br> $fechaproxF <br>
            </small>
            $detalle2
            <br>
            <h6 class='my-0'> <br>Faltan $dias_terminaF días para concluir el plan </h6>				  
            <div class='row g-3'>
                <div class='col-sm-12'>
                </div>
            </div> 
        </li>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h6 class='my-0'>Horas en COWORK</h6>
                <span class='text-body-secondary'>
                    Contratadas:  $coF:00 
                    <br>Usadas:  $tiempo_usadoCWF 
                    <br>Restantes: $tiempo_difCWF
                </span>
            </div>	
        </li>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h6 class='my-0'>Horas en Sala Reuniones</h6>
                <span class='text-body-secondary'>
                    Contratadas: $srF:00</span>
                <br>Usadas:  $tiempo_usadoSF
                <br>Restantes: $tiempo_difSRFF 
            </div>
        </li>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h6 class='my-0'>Cantidad Impresiones</h6>
                <span class='text-body-secondary'>
                    Contratadas: $iF </span>
                <br>Usadas:  0
                <br>Restantes:  $iF  
            </div>	
        </li>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h6 class='my-0'>Eventos Connecta</h6>
            </div>
            <span class='text-body-secondary'>$eF</span>
        </li>
        <li class='list-group-item d-flex justify-content-between'>
            <span>Precio</span>
            <strong> $pF </strong>
        </li>
    </ul>";
	

}					 
//fin plan futuro 
	
$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, 
planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio 
FROM planes_registro 
INNER JOIN planes 
ON planes_registro.codigo = planes.codigo
WHERE planes_registro.documento = '$documento' AND  planes_registro.estado = 'A' AND '$fechaActual' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f;";
	
$resultCE = mysqli_query($conn,$sqlCE);	  
while($row = mysqli_fetch_assoc($resultCE)) {
	
	//tabla registro_planes
	$sec=$row['secuencial_planes'];
	$cod=$row['codigo'];
	$fi=$row['fecha_i'];
	$ff=$row['fecha_f'];
		
	//tabla planes	
	$n=$row['nombre'];
	$co=$row['cowork'];
	$sr=$row['sala_reuniones'];
	$i=$row['impresiones'];
	$e=$row['evento'];
	$p=$row['precio'];
	
	// Función para colocar la fecha actualizada en palabras
	$fecha = new DateTime($ff);
	setlocale(LC_TIME, 'es_MX');
	$fechaprox = strftime('%d de %B de %Y', $fecha->getTimestamp());
	
	// Calculo Impresiones

	$date = new DateTime($fechaActual);
	$date->modify('+1 day');
	$fechaSumada = $date->format('Y-m-d');
	$sql4 = "SELECT SUM(cantidad) AS total FROM `registro` WHERE `documento` = '$documento' AND `secuencial_planes` = '$sec' AND `entrada` BETWEEN '$fi' AND '$ff' AND estado NOT LIKE 'E'";
	
	$result4 = $conn->query($sql4);
    $row = $result4->fetch_assoc();
    $totalImpresiones = $row['total'];
    $ImpresionesDif = $i-$totalImpresiones; 
	
	//Calculo horas Cowork
	$sql3 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$documento' AND `secuencial_planes` = '$sec'";
	$result3 = mysqli_query($conn, $sql3);
	$total_segundos = mysqli_fetch_assoc($result3)['total_segundos'];
	$hours = floor($total_segundos / 3600);
    $minutes = floor(($total_segundos % 3600) / 60);
    $tiempo_usadoCW = sprintf('%02d:%02d', $hours, $minutes);
  	
	//Resta horas contratadas por usadas 
	$co_segundos = $co * 3600;
	$dif_segCW = $co_segundos - $total_segundos;
	$hoursDCW = floor($dif_segCW / 3600);
	$minutesDCW = floor(($dif_segCW % 3600) / 60);
	$tiempo_difCW = sprintf('%02d:%02d', $hoursDCW, $minutesDCW);
	
		//Calculo horas Sala Reuniones
	$sql5 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'sala' AND `fecha` BETWEEN '$fi' AND '$ff' AND `documento` = '$documento' AND `secuencial_planes` = '$sec'";
	$result5 = mysqli_query($conn, $sql5);
	$total_segundosS = mysqli_fetch_assoc($result5)['total_segundos'];
	$hoursS = floor($total_segundosS / 3600);
    $minutesS = floor(($total_segundosS % 3600) / 60);
    $tiempo_usadoS = sprintf('%02d:%02d', $hoursS, $minutesS);
  	
	//Resta horas contratadas por usadas 
	$sr_segundos = $sr * 3600;
	$dif_segSR = $sr_segundos - $total_segundosS;
	$hoursSR = floor($dif_segSR / 3600);
	$minutesSR = floor(($dif_segSR % 3600) / 60);
	$tiempo_difSR = sprintf('%02d:%02d', $hoursSR, $minutesSR);
	
	//dias restantes para terminar el plan 
	$fechaActualD = new DateTime($fechaActual);
	$fechaproxD = new DateTime($ff);
	$diferencia = $fechaActualD->diff($fechaproxD);
	$dias_restantes = $diferencia->days;
	
	$detalle = "<a class='btn btn-outline-info' href='detalle_registro.php?documento=$documentoCLi&sec=$sec' role='button'>Detalle Registro</a><br>";

	
	if($dias_restantes<5){
		
		$dias_termina = "<b class='text-danger'>$dias_restantes</b>";
		$boton_termina = "<a class='btn btn-outline-success' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";
	}elseif ($dias_restantes > 5 && $dias_restantes < 10){
		$dias_termina = "$dias_restantes";
		$boton_termina = "<a class='btn btn-outline-warning' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";
	}else{
		$dias_termina = "$dias_restantes";
		$boton_termina = "<a class='btn btn-outline-danger' href='clientes_plan_reno.php?id=$documento&cod=$cod' role='button'>Renovar</a>";		
	}

		
	echo "
    
    <ul class='list-group mb-3'>
        <li class='list-group-item d-flex justify-content-between lh-sm'>
            <div>
                <h3 class='my-0'> $n <a class='btn btn-outline-info' href='detalle_registro.php?documento=$documentoCLi&sec=$sec' role='button'>modificar</a>r</h6>
                	 <small class='text-body-secondary'>Vencimiento mensual el: <br> $fechaprox <br>
				  </small>
				  
				  
				  <br>
			<h6 class='my-0'> <br>Faltan $dias_termina días para concluir el plan </h6>				  
				  <div class='row g-3'>
				  <div class='col-sm-12'>
				  $boton_termina
				  </div>
				  </div> 
		</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en COWORK</h6>
        <span class='text-body-secondary'>
            Contratadas:  $co:00 
            <br>Usadas:  $tiempo_usadoCW 
            <br>Restantes: $tiempo_difCW
        </span>
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Horas en Sala Reuniones</h6>
        <span class='text-body-secondary'>
            Contratadas: $sr:00</span>
        <br>Usadas:  $tiempo_usadoS
        <br>Restantes: $tiempo_difSR 
    </div>
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Cantidad Impresiones</h6>
        <span class='text-body-secondary'>
            Contratadas: $i </span>
        <br>Usadas:  $totalImpresiones
        <br>Restantes:  $ImpresionesDif  
    </div>	
</li>
<li class='list-group-item d-flex justify-content-between lh-sm'>
    <div>
        <h6 class='my-0'>Eventos Connecta</h6>
    </div>
    <span class='text-body-secondary'>$e</span>
</li>
<li class='list-group-item d-flex justify-content-between'>
    <span>Precio</span>
    <strong> $p </strong>
</li>
</ul>";
	
}		
	
	
	
}
?>
</div>	
</div>
</div>


</div>
	
	

<?php
				

mysqli_close($conn); 
	   
?>
   
</div>		
</body>
 
</html>

