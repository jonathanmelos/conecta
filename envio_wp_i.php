<?php 
include('conexion.php');
include 'header.php';
 $id = $_GET['id'];
 $telef = $_GET['telef'];
 $sql = "SELECT * FROM leads WHERE sec_lead = $id";
$result = mysqli_query($conn,$sql);  
$row = mysqli_fetch_assoc($result);
$nombre =$row['nombre']; 

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