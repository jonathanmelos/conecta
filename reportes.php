<?php 
date_default_timezone_set('America/Guayaquil');
$hoy = date('Y-m-d');
$fecha_i = $fecha_i = date('Y-m-01', strtotime($hoy));
include 'header.php';
?>
<body>
	
	<div class="container">
	<div class="abs-center">
		<h4 class="mb-3">Elige una opción para visualizar reportes</h4>
		
<table>
  
  <tr>
    <td><a href="reporte_fecha.php?estado=%25&fecha=<?php echo $hoy ?>">
	<button class="btn btn-success">Registros por Día   </button></a></td>
     <td><a href="reporte_cliente.php">
	<button class="btn btn-primary">Historia Cliente  </button></a></td>
	  <td><a href="reporte_lapso.php?estado=%25&fecha_i=<?php echo $fecha_i ?>&busqueda=a&fecha=<?php echo $hoy ?>">
	<button class="btn btn-warning">Por fecha </button></a></td>
  </tr>
</table>
		
	
	
			
		</div>
		
	</div>	
</body>
</html>