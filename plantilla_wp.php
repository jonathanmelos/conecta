<?php 
include 'conexion.php';
include 'header.php';
?>
<body>
	
	<div class="container">
    <div class="row">
    <div class="col-md-4 col-lg-6"> 
      
    </div>	 
    <div class="col-md-4 col-lg-3">	
       
    </div>	
	  <div class="col-md-2 col-lg-3">	
      <a href="n_plantilla_wp.php">
        <button type="button" class="btn btn-primary btn-lg">Crear nueva plantilla</button>
      </a>
    </div>	 
  </div>   
	<div class="abs-center">
		<h4 class="mb-3">Plantillas de Whatsapp</h4>
		
        <table class="table table-striped" id="tabla-clientes">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Texto</th>	   
      <th scope="col">Modificar</th>
	  <th scope="col">Eliminar</th>	
		
    </tr>
  </thead>
   <tbody>
   <?php
	   
       $sql = "SELECT * FROM plantilla ";
       $result = mysqli_query($conn,$sql);  
       while($row = mysqli_fetch_assoc($result)) {
           $nombre =$row['nombre']; 
           $info =$row['info']; 
           $id_plantilla =$row['id_plantilla']; 
           echo "<tr class='popper-row' id='cliente-".$row['id_plantilla']."'>";
           echo "<th scope='row'>" . $row['nombre'] . "</th>";
           echo "<td>" . $row['info'] . "</td>";
           echo "<td><a href='m_plantilla_wp.php?id=" .$row['id_plantilla'] . "'>
           <button class='btn btn-warning'>Modificar</button></a></td>";
           echo "<td><a href='e_plantilla_wp.php?id=" . $row['id_plantilla'] . "'>
           <button class='btn btn-danger' >Eliminar</button></a></td>";
           echo "</tr>";
           
       }
              
       
       mysqli_close($conn); // Cierra la conexión a la base de datos
              
       ?>   
	  
</tbody>
</table>		
		</div>
		
	</div>	
</body>
</html>