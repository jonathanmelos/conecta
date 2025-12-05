<?php 
date_default_timezone_set('America/Guayaquil');
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$sec_lead = $_GET['id'];
include 'header.php';
$sql = "SELECT * FROM leads WHERE sec_lead = $sec_lead";
$resultado = mysqli_query($conn, $sql);
$datos = mysqli_fetch_assoc($resultado);
$nombre = $datos['nombre'];
$edad = $datos['edad'];
$sexo = $datos['sexo'];
$estado = $datos['estado'];
$ingresos = $datos['ingresos'];
$telefono = $datos['telefono'];
$correo = $datos['correo'];
$direccion = $datos['direccion'];
$emprendedor = $datos['emprendedor'];
$tam_emp = $datos['empresa_tamano'];
$necesidad = $datos['necesidad'];
$medio = $datos['medio'];
$fecha = $datos['fecha'];
$intereses = $datos['intereses'];
$campana = $datos['campana'];
$tema = $datos['tema'];
$observaciones = $datos['observaciones'];
$area_negocio = $datos['area_negocio'];
if($estado=='CT'){
	
	$estadoI="contacto";
}
elseif($estado=''){
	$estadoI="prospecto";
	}
else{
	$estadoI="contacto";	
}

if($sexo=="H"){
	$sexoI = "Hombre";
}
elseif($sexo=="M"){
	$sexoI = "Mujer";
}
elseif($sexo=="N"){
	$sexoI = "No definido";
}

if($tam_emp=="1"){
	$tam_empI = "De 1 - 10
			 ";
}
elseif($tam_emp=="50"){
	$tam_empI = "De 10 - 50
			 ";
}
elseif($tam_emp=="100"){
	$tam_empI = "De 50 - 100
			 ";
}
elseif($tam_emp=="101"){
	$tam_empI = "De 100 adelante
			 ";
}
else{
	$tam_empI = "De 1 - 10
			 ";
}


if($emprendedor=="S"){
	$emprendedorI = "Si
			 ";
}
elseif($emprendedor=="N"){
		$emprendedorI = "No
			 ";
}elseif(isset($emprendedor)){
		$emprendedorI = "No
			 ";
}

if($medio=="fb"){
	$medioI = "Facebook
			 ";
}
elseif($medio=="in"){
		$medioI = "Instagram
			 ";
}
elseif($medio=="tk"){
		$medioI = "Tiktok
			 ";
}
elseif($medio=="web"){
		$medioI = "Web
			 ";
}
elseif($medio=="wp"){
		$medioI = "Whatsapp
			 ";
}
elseif($medio=="rf"){
		$medioI = "Referido
			 ";
}
elseif($medio=="ot"){
		$medioI = "otro
			 ";
}
elseif(isset($medio)){
		$medioI = "sin registro
			 ";
}
?>

<body>
<div class="row">
	<form action="lead_insertar_cl.php" method="post">
    	 
    <div class="col-md-5 col-lg-4">	
    <div class="input-group mb-3">
		<input type="hidden" name="sec_lead" value="<?php echo $sec_lead;?>"></input>
		  <input type="text" class="form-control" placeholder="cedula / ruc / pasaporte" aria-label="Recipient's username" aria-describedby="basic-addon2" name="cedula" required>
		  <div class="input-group-append">
			  <input type="submit" class="btn btn-primary btn-lg " value="Agregar cédula">
		</div>
		</div> 
    </div>	
		</form>	
  </div>

  <div class="form-group row">
	 <div class="col-sm-8">
    <label for="inputText3" class="col-sm-4 col-form-label"  >Nombre y Apellido: </label>
		 <div class="texto_lead"> <?php echo $nombre?> </div>
    </div>
	  <div class="col-sm-4">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Estado: </label>
		  <div class="texto_lead"> <?php echo $estadoI ?> </div> 
     </div> 
  </div>
  <div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Edad: </label>
     <div class="texto_lead"> <?php echo $edad?> </div>
    </div>
	  <div class="col-sm-3">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Sexo: </label>
     	<div class="texto_lead"> <?php echo $sexoI?> </div>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label"  >Ingresos mensuales: </label>
     <div class="texto_lead"> <?php echo $ingresos?> </div>
    </div> 
	 <div class="col-sm-4">
   	<label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
	<div class="texto_lead"> <?php echo $telefono?> </div>
    </div>  
  </div>
 
 <div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <div class="texto_lead"> <?php echo $correo?> </div>
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
	<div class="texto_lead"> <?php echo $direccion?> </div>	 
	 </div><br><br>
  </div>
	<div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label">Emprendedor: </label>
    <div class="texto_lead"> <?php echo $emprendedorI?> </div>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label">Tamaño empresa: </label>
   <div class="texto_lead"> <?php echo $tam_empI?> </div>
    </div> 
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Industria / Área de Negocio: </label>
    <div class="texto_lead"> <?php echo $area_negocio?> </div> 
    </div>  	
	</div>
 <div class="form-group row">
 
    <div class="col-sm-2">
        <label for="inputText3" class="col-sm-2 col-form-label"  >medio: </label>
		<div class="texto_lead"> <?php echo $medioI?> </div>
	 </div>
	 <div class="col-sm-3">
     <label for="inputText3" class="col-sm-2 col-form-label"  >Fecha: </label>
     <div class="texto_lead"> <?php echo $fecha?> </div>
    </div>
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Intereses: </label>
     <div class="texto_lead"> <?php echo $intereses?> </div>
    </div>
	 </div>	
   	 	 

	<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Campaña: </label>
    <div class="texto_lead"> <?php echo $campana?> </div>
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Tema: </label>
	<div class="texto_lead"> <?php echo $tema?> </div> 
	 </div>
  </div> 
<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-8 col-form-label">Necesidad de espacio coworking: </label>
    <div class="texto_lead"> <?php echo $necesidad?> </div> 
    </div> 
	 
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-10 col-form-label"  >Observaciones: </label>
	<div class="texto_lead"> <?php echo $observaciones?>  </div> 
	 </div>
  </div> 
<div class="form-group row">
<div class="col-sm-12">
    <label for="inputText3" class="col-sm-2 col-form-label"  > Acciones </label>
    </div>	
</div>	
   </div>


	

	

</body>
</html>