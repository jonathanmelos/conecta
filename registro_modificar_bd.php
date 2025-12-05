<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$documento = $_POST['documento'];
$secuencial = $_POST['secuencial'];
$entrada = $_POST['entrada'];
$salida = $_POST['salida'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$impresiones = $_POST['impresiones'];
$cargaP = $_POST['cargaP'];
$cond_cargaP = $_POST['cond_cargaP'];
$invitado = $_POST['invitado'];

if (empty($invitado)) {

if ($cond_cargaP==1){
	//Calculo horas Cowork
	$sql3 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork'   AND  `secuencial_planes` = '$cargaP'";
	$result3 = mysqli_query($conn, $sql3);
	$total_segundos = mysqli_fetch_assoc($result3)['total_segundos'];
	$hours = floor($total_segundos / 3600);
    $minutes = floor(($total_segundos % 3600) / 60);
    $tiempo_usadoCW = sprintf('%02d:%02d', $hours, $minutes);
		
	$sql = "SELECT *  FROM `planes_registro` WHERE `secuencial_planes` = '$cargaP' ;";
    $result = mysqli_query($conn,$sql);
    $RegP = mysqli_fetch_assoc($result);
	$codigo = $RegP['codigo']; 
	
	$sql2 = "SELECT *  FROM `planes` WHERE `codigo` = '$codigo';";
    $result2 = mysqli_query($conn,$sql2);
    $Plan = mysqli_fetch_assoc($result2);
	$CW = $Plan['cowork'];
	$SR = $Plan['sala_reuniones'];
	
	//Resta horas contratadas por usadas 
	$co_segundos = $CW * 3600;
	$dif_segCW = $co_segundos - $total_segundos; //segundos que sobran
	
	$entrada_timestamp = strtotime($entrada);
	$salida_timestamp = strtotime($salida);
	$difference = $salida_timestamp - $entrada_timestamp;
	$hours = floor($difference / 3600);
	$minutes = floor(($difference / 60) % 60);
	$dif_es_h = sprintf('%02d:%02d', $hours, $minutes);
	
	$hoursCW = floor($dif_segCW / 3600);
	$minutesCW = floor(($dif_segCW / 60) % 60);
	$dif_segCWH = sprintf('%02d:%02d', 	$hoursCW, $minutesCW);
	
		
	if ($difference > $dif_segCW) {
		
						 
		$h_extra= $difference -  $dif_segCW;
		$hours = floor($h_extra / 3600);
		$minutes = floor(($h_extra / 60) % 60);
		$h_extraH = sprintf('%02d:%02d', $hours, $minutes);
	   
		$salida_timestamp = strtotime($salida);
		$new_timestamp = $salida_timestamp - $h_extra;
		$Hnueva_salida = date('H:i:s', $new_timestamp);
		
		$date = date('Y-m-d', strtotime($salida));
		$nueva_salida = $date . 'T' . $Hnueva_salida;

		
		$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio FROM planes_registro 
		INNER JOIN planes ON planes_registro.codigo = planes.codigo
		WHERE planes_registro.documento = '$documento' AND planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f ORDER BY planes_registro.secuencial_planes DESC 
		LIMIT 1;";
		$resultCE = mysqli_query($conn,$sqlCE);	
		$Reg = mysqli_fetch_assoc($resultCE);
		$sec_P = $Reg['secuencial_planes']; 
		
		$sql = "INSERT INTO registro (documento, entrada, salida, servicio, concluido, estado, secuencial_planes ) VALUES ( '$documento', '$nueva_salida', '$salida' , '$servicio', '1', 'C', '$sec_P' )";
		mysqli_query($conn, $sql);
		
		$consulta = "UPDATE registro SET entrada='$entrada', salida='$nueva_salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
		$result = mysqli_query($conn, $consulta);


	
	
}
	

else{
		
			
	$consulta = "UPDATE registro SET entrada='$entrada', salida='$salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
	$result = mysqli_query($conn, $consulta);
		
	}
}

elseif($cond_cargaP==0) {
	$consulta = "UPDATE registro SET entrada='$entrada', salida='$salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
	$result = mysqli_query($conn, $consulta);
}


}else{
	
if ($cond_cargaP==1){
	//Calculo horas Cowork
	$sql3 = "SELECT SUM(TIME_TO_SEC(hora)) as total_segundos FROM horas WHERE `servicio` = 'cowork'   AND  `secuencial_planes` = '$cargaP'";
	$result3 = mysqli_query($conn, $sql3);
	$total_segundos = mysqli_fetch_assoc($result3)['total_segundos'];
	$hours = floor($total_segundos / 3600);
    $minutes = floor(($total_segundos % 3600) / 60);
    $tiempo_usadoCW = sprintf('%02d:%02d', $hours, $minutes);
		
	$sql = "SELECT *  FROM `planes_registro` WHERE `secuencial_planes` = '$cargaP' ;";
    $result = mysqli_query($conn,$sql);
    $RegP = mysqli_fetch_assoc($result);
	$codigo = $RegP['codigo']; 
	
	$sql2 = "SELECT *  FROM `planes` WHERE `codigo` = '$codigo';";
    $result2 = mysqli_query($conn,$sql2);
    $Plan = mysqli_fetch_assoc($result2);
	$CW = $Plan['cowork'];
	$SR = $Plan['sala_reuniones'];
	
	//Resta horas contratadas por usadas 
	$co_segundos = $CW * 3600;
	$dif_segCW = $co_segundos - $total_segundos; //segundos que sobran
	
	$entrada_timestamp = strtotime($entrada);
	$salida_timestamp = strtotime($salida);
	$difference = $salida_timestamp - $entrada_timestamp;
	$hours = floor($difference / 3600);
	$minutes = floor(($difference / 60) % 60);
	$dif_es_h = sprintf('%02d:%02d', $hours, $minutes);
	
	$hoursCW = floor($dif_segCW / 3600);
	$minutesCW = floor(($dif_segCW / 60) % 60);
	$dif_segCWH = sprintf('%02d:%02d', 	$hoursCW, $minutesCW);
	
		
	if ($difference > $dif_segCW) {
		
						 
		$h_extra= $difference -  $dif_segCW;
		$hours = floor($h_extra / 3600);
		$minutes = floor(($h_extra / 60) % 60);
		$h_extraH = sprintf('%02d:%02d', $hours, $minutes);
	   
		$salida_timestamp = strtotime($salida);
		$new_timestamp = $salida_timestamp - $h_extra;
		$Hnueva_salida = date('H:i:s', $new_timestamp);
		
		$date = date('Y-m-d', strtotime($salida));
		$nueva_salida = $date . 'T' . $Hnueva_salida;

		
		$sqlCE = "SELECT planes_registro.secuencial_planes, planes_registro.documento, planes_registro.codigo, planes_registro.fecha_i, planes_registro.fecha_f, planes_registro.estado, planes.nombre, planes.cowork, planes.sala_reuniones, planes.impresiones, planes.evento, planes.precio FROM planes_registro 
		INNER JOIN planes ON planes_registro.codigo = planes.codigo
		WHERE planes_registro.documento = '$documento' AND planes_registro.estado = 'A' AND '$fecha' BETWEEN planes_registro.fecha_i AND planes_registro.fecha_f ORDER BY planes_registro.secuencial_planes DESC 
		LIMIT 1;";
		$resultCE = mysqli_query($conn,$sqlCE);	
		$Reg = mysqli_fetch_assoc($resultCE);
		$sec_P = $Reg['secuencial_planes']; 
		
		$sql = "INSERT INTO registro (documento, invitado, entrada, salida, servicio, concluido, estado, secuencial_planes ) VALUES ( '$documento','$invitado', '$nueva_salida', '$salida' , '$servicio', '1', 'C', '$sec_P' )";
		mysqli_query($conn, $sql);
		
		$consulta = "UPDATE registro SET entrada='$entrada', salida='$nueva_salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
		$result = mysqli_query($conn, $consulta);


	
	
}else{
		
			
	$consulta = "UPDATE registro SET entrada='$entrada', salida='$salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
	$result = mysqli_query($conn, $consulta);
		
	}
}else {
	$consulta = "UPDATE registro SET entrada='$entrada', salida='$salida', servicio='$servicio', cantidad='$impresiones', secuencial_planes='$cargaP' WHERE secuencial_R='$secuencial'";
	$result = mysqli_query($conn, $consulta);
}
	
	
	
	
}


header('Location: diario.php?fecha='. $fecha);



?>