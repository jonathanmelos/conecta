<?php 
include('conexion.php');
include 'header.php';
 $id = $_GET['id'];
 $sec_lead = $_GET['sec_lead'];
 $telef = $_GET['telef'];
 $sql = "SELECT * FROM calendario WHERE id_cal = $id";
$result = mysqli_query($conn,$sql);  
$row = mysqli_fetch_assoc($result);
$nombre =$row['nombre']; 


$sql2 = "UPDATE leads SET nivel = nivel + 34 WHERE sec_lead = '$sec_lead' ";
$result2 = mysqli_query($conn,$sql2); 
 ?>
<body>
	
	<div class="container">
	<div class="abs-center">
		<h4 class="mb-3">Enviaste un Whatsapp a: </h4>
		<h5 class="mb-3"> <?php echo $nombre; ?></h5>
        <h5 class="mb-3"> <?php echo $telef; ?></h5>
<table>
  
  <tr>
    <td><a href="envio_wp_mn.php?id=<?php echo $id ?>">
	<button class="btn btn-success">Enviado y conservar el número   </button></a></td>
     <td><a href="envio_wp_cn.php?id=<?php echo $id ?>&telef=<?php echo $telef ?>&nombre=<?php echo $nombre ?>">
	<button class="btn btn-primary">Enviado y corregir el número   </button></a></td>
  </tr>
</table>
		
	
	
			
		</div>
		
	</div>	
</body>
</html>