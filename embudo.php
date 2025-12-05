<?php
include 'conexion.php';
include 'header.php'; 
?>

<div class="container">
  <div class="row">
    <div class="col-md-4 col-lg-6"> 
      <form action="reporte_cliente_registros.php" method="post" autocomplete="off">
        <div class="form-group row">
          <label for="inputText3" class="col-sm-2 col-form-label">Lead:</label>
          <div class="col-sm-7">
            <input type="text" id="documento" class="form-control" placeholder="buscar lead" onkeyup="doSearch()">
            <br> 
          </div>	
        </div>	 
      </form>	
    </div>	 
    <div class="col-md-4 col-lg-3">	
      <a href="lead_registro.php">
        <button type="button" class="btn btn-primary btn-lg">Crear nuevo lead</button>
      </a> 
    </div>	
	  <div class="col-md-2 col-lg-3">	
      <a href="cargar_csv.php">
        <button type="button" class="btn btn-outline-info">Cargar CSV FB</button>
      </a> 
	 <a href="cargar_xls.php">
        <button type="button" class="btn btn-outline-info">Cargar Excel</button>
      </a> 	  
    </div>	 
  </div>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-contactos" role="tab" aria-controls="nav-contactos" aria-selected="true">contactos</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-prospectos" role="tab" aria-controls="nav-prospectos" aria-selected="false">prospectos</a>
	  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-clientes" role="tab" aria-controls="nav-clientes" aria-selected="false">Clientes</a> 
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-contactos" role="tabpanel" aria-labelledby="nav-home-tab">
	
	  <br>
  <div class="row">
    <div class="col-md-4 col-lg-6"> 
     <div class="form-group row">
       <div class="col-md-4 col-lg-3">	    
			  <h4 class='mb-3'> CONTACTOS </h4></label>
		</div> 
     </div>	 
     
    </div>	 
 	  <div class="col-md-2 col-lg-6">	
      <a href="p_llamada.php?ld=CT">
        <button type="button" class="btn btn-outline-secondary">Progamar llamada </button>
      </a> 
	 <a href="p_correo.php?ld=CT">
        <button type="button" class="btn btn-outline-secondary">Programar correo</button>
      </a> 
	 <a href="p_whatsapp.php?ld=CT">
        <button type="button" class="btn btn-outline-secondary">Programar whatsapp</button>
      </a> 	  
    </div>	 
  </div>	  
	  
	  <?php
echo "
<br>


<table class='table table-striped' id='tabla-clientes'>
  <thead>
    <tr>
      <th scope='col'>Nombre</th>
      <th scope='col'>Teléfono</th>
	  <th scope='col'>Estado</th>
	  <th scope='col'>Medio</th>
	  <th scope='col'>Ver más</th>	
	  <th scope='col'>Cambiar estado</th>	
		
    </tr>
  </thead>
   <tbody>

";
	
$sql = "SELECT * FROM leads  WHERE estado = 'CT'";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$sec_lead = $row['sec_lead'];
	$estado =$row['estado'];

	if($estado == 'PR'){
		$estado_v = 'Prospecto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	
	elseif($estado == 'CT'){
		$estado_v = 'Contacto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	elseif($estado == 'CL'){
		$estado_v = 'Cliente';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a>";
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
	$barra = $row['nivel'];
	if($barra >= 0 && $barra < 29){
		$color = "bg-info";
	}
	elseif($barra >= 30 && $barra < 60){
		$color = "bg-success";
	}
	elseif($barra >= 61 && $barra < 99){
		$color = "bg-warning";
	}
	elseif($barra >= 100){
		$color = "bg-danger";
	}
		
	
	echo "<tr class='popper-row' id='cliente-".$row['sec_lead']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $estado_v ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<div class='progress'>
	<div class='progress-bar ".$color."' role='progressbar' style='width: ".$barra."%' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100'></div>
  </div></td>";
	echo "<td>" . $medio_v . "</td>";	
	echo "<td><a href='lead_info.php?id=" . $row['sec_lead']."'>
	<button class='btn btn-primary'>MÁS INFO</button></a></td>";
	
	echo "<td>$bt_estado</td>";
	echo "</tr>";
}
   
echo "</tbody>
</table>"

	   
?>
	
	</div>
  
	<div class="tab-pane fade" id="nav-prospectos" role="tabpanel" aria-labelledby="nav-profile-tab">
		

	  <br>
  <div class="row">
    <div class="col-md-4 col-lg-6"> 
     <div class="form-group row">
       <div class="col-md-4 col-lg-3">	    
			  <h4 class='mb-3'> PROSPECTOS </h4></label>
		</div> 
     </div>	 
     
    </div>	 
 	  <div class="col-md-2 col-lg-6">	
      <a href="p_llamada.php?ld=PR">
        <button type="button" class="btn btn-outline-secondary">Progamar llamada </button>
      </a> 
	 <a href="p_correo.php?ld=PR">
        <button type="button" class="btn btn-outline-secondary">Programar correo</button>
      </a> 
	 <a href="p_whatsapp.php?ld=PR">
        <button type="button" class="btn btn-outline-secondary">Programar whatsapp</button>
      </a> 	  
    </div>	 
  </div>			
	<?php
echo "
<table class='table table-striped' id='tabla-clientes'>
  <thead>
    <tr>
      <th scope='col'>Nombre</th>
      <th scope='col'>Teléfono</th>
	  <th scope='col'>Estado</th>
	  <th scope='col'>Medio</th>
	  <th scope='col'>Ver más</th>	
	  <th scope='col'>Cambiar estado</th>	
		
    </tr>
  </thead>
   <tbody>

";
	
$sql = "SELECT * FROM leads  WHERE estado = 'PR'";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$sec_lead = $row['sec_lead'];
	$estado =$row['estado'];

	if($estado == 'PR'){
		$estado_v = 'Prospecto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	
	elseif($estado == 'CT'){
		$estado_v = 'Contacto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	elseif($estado == 'CL'){
		$estado_v = 'Cliente';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a>";
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
	
	echo "<tr class='popper-row' id='cliente-".$row['sec_lead']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $estado_v . "</td>";
	echo "<td>" . $medio_v . "</td>";	
	echo "<td><a href='lead_info.php?id=" . $row['sec_lead']."'>
	<button class='btn btn-primary'>MÁS INFO</button></a></td>";
	
	echo "<td>$bt_estado</td>";
	echo "</tr>";
		

}
	   
echo "</tbody>
</table>"

	   
?>
	
	</div>
 <div class="tab-pane fade" id="nav-clientes" role="tabpanel" aria-labelledby="nav-profile-tab">
 <br>
  <div class="row">
    <div class="col-md-4 col-lg-6"> 
     <div class="form-group row">
       <div class="col-md-4 col-lg-3">	    
			  <h4 class='mb-3'> CLIENTES </h4></label>
		</div> 
     </div>	 
     
    </div>	 
 	  <div class="col-md-2 col-lg-6">	
      <a href="p_llamada.php?ld=CL">
        <button type="button" class="btn btn-outline-secondary">Progamar llamada </button>
      </a> 
	 <a href="p_correo.php?ld=CL">
        <button type="button" class="btn btn-outline-secondary">Programar correo</button>
      </a> 
	 <a href="p_whatsapp.php?ld=CL">
        <button type="button" class="btn btn-outline-secondary">Programar whatsapp</button>
      </a> 	  
    </div>	 
  </div>				 
	 
	<?php
echo "
  <table class='table table-striped' id='tabla-clientes'>
  <thead>
    <tr>
      <th scope='col'>Nombre</th>
      <th scope='col'>Teléfono</th>
	  <th scope='col'>Estado</th>
	  <th scope='col'>Medio</th>
	  <th scope='col'>Ver más</th>	
	  <th scope='col'>Cambiar estado</th>	
		
    </tr>
  </thead>
   <tbody>

";
	
$sql = "SELECT * FROM leads  WHERE estado = 'CL'";
$result = mysqli_query($conn,$sql);  
while($row = mysqli_fetch_assoc($result)) {
	$sec_lead = $row['sec_lead'];
	$estado =$row['estado'];

	if($estado == 'pr'){
		$estado_v = 'Prospecto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	
	elseif($estado == 'CT'){
		$estado_v = 'Contacto';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_c.php?id=$sec_lead&estado=CL'><button class='btn btn-success'>Cliente</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a> ";
		}
	elseif($estado == 'CL'){
		$estado_v = 'Cliente';
		$bt_estado = "<a href='lead_modificar_e.php?id=$sec_lead&estado=CT'><button class='btn btn-info'>Contácto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_e.php?id=$sec_lead&estado=PR'><button class='btn btn-warning'>Prospecto</button></a>&nbsp; &nbsp; &nbsp; <a href='lead_modificar_b.php?id=$sec_lead&estado=CL'><button class='btn btn-danger'>Eliminar</button></a>";
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
	
	echo "<tr class='popper-row' id='cliente-".$row['sec_lead']."'>";
    echo "<th scope='row'>" . $row['nombre'] . "</th>";
    echo "<td>" . $row['telefono'] . "</td>";
	echo "<td>" . $estado_v . "</td>";
	echo "<td>" . $medio_v . "</td>";	
	echo "<td><a href='lead_info.php?id=" . $row['sec_lead']."'>
	<button class='btn btn-primary'>MÁS INFO</button></a></td>";
	
	echo "<td>$bt_estado</td>";
	echo "</tr>";
		

}
	   
echo "</tbody>
</table>"

	   
?>
	
	</div>
</div>   
	  
</div>		
</body>
</html>
 <script>
    $(document).ready(function(){
      // Activar las pestañas al hacer clic en ellas
      $('#myTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
      })
    });
  </script>
<script> 
	
function doSearch() {
  var search = document.getElementById('documento').value.toLowerCase();
  var rows = document.querySelectorAll('#tabla-clientes tbody tr');

  for (var i = 0; i < rows.length; i++) {
    var documento = rows[i].querySelector('th').textContent.toLowerCase();
    var nombre = rows[i].querySelector('td:nth-child(2)').textContent.toLowerCase();
    var apellido = rows[i].querySelector('td:nth-child(3)').textContent.toLowerCase();

    if (documento.includes(search) || nombre.includes(search) || apellido.includes(search)) {
      rows[i].style.display = '';
    } else {
      rows[i].style.display = 'none';
    }
  }
}
</script>

