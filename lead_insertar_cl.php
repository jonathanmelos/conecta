<?php
include 'header.php';
include 'conexion.php';
$sec_lead = $_POST['sec_lead'];
$cedula =  $_POST['cedula'];
$sql = "UPDATE leads SET
            documento	 = '$cedula',
			estado = 'CL'
        WHERE sec_lead = '$sec_lead'";

mysqli_query($conn, $sql);
?>
<body>
	
	<div class="container">
	<div class="abs-center">
		<h4 class="mb-3">Elige una opción para el ingreso</h4>
		
<table>
  
  <tr>
    <td><a href="clientes_registro_horas_l.php?sec_lead=<?php echo $sec_lead ?>">
	<button class="btn btn-success">Cliente por horas    </button></a></td>
     <td><a href="clientes_registro_plan_l.php?sec_lead=<?php echo $sec_lead ?>">
	<button class="btn btn-primary">Cliente con Plan    </button></a></td>
  </tr>
</table>
		
	
	
			
		</div>
		
	</div>	
</body>
</html>