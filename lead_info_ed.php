<?php 
date_default_timezone_set('America/Guayaquil');
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$sec_lead = $_GET['id'];
include 'header.php';
$sql = "SELECT * FROM leads WHERE sec_lead = $sec_lead";
$resultado = mysqli_query($conn, $sql);
$datos = mysqli_fetch_assoc($resultado);
$fechahoy = date('Y-m-d H:i:s'); 
    // Acceder a los valores de las columnas específicas
 	
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
	
	$estadoI="<option value='CT' selected >contacto</option>
			 <option value='PR'>prospecto</option>";
}
elseif($estado=''){
	$estadoI="<option value='CT'>contacto</option>
			 <option value='PR' selected>prospecto</option>";
	}
else{
	$estadoI="<option value='CT' selected >contacto</option>
			 <option value='PR'>prospecto</option>";	
}

if($sexo=="H"){
	$sexoI = "<option value='N'>No definido</option>
			 <option value='H'selected >Hombre</option>
			 <option value='M'>Mujer</option>";
}
elseif($sexo=="M"){
	$sexoI = "<option value='N'>No definido</option>
			 <option value='H'>Hombre</option>
			 <option value='M'selected >Mujer</option>";
}
else{
	$sexoI = "<option value='N' selected>No definido</option>
			 <option value='H'>Hombre</option>
			 <option value='M'>Mujer</option>";
}

if($tam_emp=="1"){
	$tam_empI = "<option value='1' selected > De 1 - 10</option>
			 <option value='50'>De 10 - 50 </option>
			 <option value='100'>De 50 - 100 </option>
			 <option value='101'>De 100 adelante </option>
			 ";
}
elseif($tam_emp=="50"){
	$tam_empI = "<option value='1' > De 1 - 10</option>
			 <option value='50'selected >De 10 - 50 </option>
			 <option value='100'>De 50 - 100 </option>
			 <option value='101'>De 100 adelante </option>
			 ";
}
elseif($tam_emp=="100"){
	$tam_empI = "<option value='1' > De 1 - 10</option>
			 <option value='50' >De 10 - 50 </option>
			 <option value='100'selected >De 50 - 100 </option>
			 <option value='101'>De 100 adelante </option>
			 ";
}
elseif($tam_emp=="101"){
	$tam_empI = "<option value='1' > De 1 - 10</option>
			 <option value='50' >De 10 - 50 </option>
			 <option value='100'>De 50 - 100 </option>
			 <option value='101' selected>De 100 adelante </option>
			 ";
}
else{
	$tam_empI = "<option value='1' selected > De 1 - 10</option>
			 <option value='50' >De 10 - 50 </option>
			 <option value='100'>De 50 - 100 </option>
			 <option value='101' >De 100 adelante </option>
			 ";
}


if($emprendedor=="S"){
	$emprendedorI = "<option value='si'selected >Si</option>
					<option value='N'>No</option>
			 ";
}
elseif($emprendedor=="N"){
		$emprendedorI = "<option value='si' >Si</option>
					<option value='N' selected>No</option>
			 ";
}elseif(isset($emprendedor)){
		$emprendedorI = "<option value='si' >Si</option>
					<option value='N' selected>No</option>
			 ";
}

if($medio=="fb"){
	$medioI = "<option>Elige un medio</option>
			 <option value='fb'selected>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="in"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in' selected>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="tk"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'selected>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="web"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'selected>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="wp"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp' selected>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="rf"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'selected >Referido</option>
			<option value='ot'>otro</option>
			 ";
}
elseif($medio=="ot"){
		$medioI = "<option>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'selected>otro</option>
			 ";
}
elseif(isset($medio)){
		$medioI = "<option selected>Elige un medio</option>
			 <option value='fb'>Facebook</option>
			 <option value='in'>Instagram</option>
			 <option value='tk'>Tiktok</option>
			 <option value='web'>Web</option>
			 <option value='wp'>Whatsapp</option>
			 <option value='rf'>Referido</option>
			<option value='ot'>otro</option>
			 ";
}

?>


<form action="lead_insertar_ed.php" method="post">

  <div class="form-group row">
	 <div class="col-sm-8">
    <label for="inputText3" class="col-sm-4 col-form-label"  >Nombre y Apellido: </label>
	<input type="hidden" name="sec_lead"  value="<?php echo $sec_lead ?>">	</input> 
    <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" required value="<?php echo $nombre ?>">
    </div>
	  <div class="col-sm-4">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Estado: </label>
     <select name="estado" class="form-select" aria-label="Default select example">
  			<?php echo $estadoI ?>
	</select>
    </div> 
  </div>
  <div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Edad: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="edad" name="edad" value="<?php echo $edad ?>" >
    </div>
	  <div class="col-sm-3">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Sexo: </label>
     	<select name="sexo" class="form-select" aria-label="Default select example" >
  			<?php echo $sexoI ?>
		  </select>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label"  >Ingresos mensuales: </label>
     <input type="text" class="form-control" id="inputText3" placeholder="ingresos" name="ingresos"  value="<?php echo $ingresos ?>">
    </div> 
	 <div class="col-sm-4">
   	<label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" value="<?php echo $telefono ?>" >
    </div>  
  </div>
 
 <div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <input type="email" class="form-control" id="inputText3" placeholder="correo" name="correo" value="<?php echo $correo ?>"  >
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="direccion" name="direccion" value="<?php echo $direccion ?>" >	 
	 </div><br><br>
  </div>
	<div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label">Emprendedor: </label>
    <select name="emprendedor" class="form-select" aria-label="Default select example">
			
			 <?php echo $emprendedorI ?>
		  </select>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label">Tamaño empresa: </label>
    <select name="tam_emp" class="form-select" aria-label="Default select example">
  			<?php echo $tam_empI ?>
	</select> 
    </div> 
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Industria / Área de Negocio: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="area_negocio" name="area_negocio" value="<?php echo $area_negocio ?>" > 
    </div>  	
	</div>
 <div class="form-group row">
 
    <div class="col-sm-2">
        <label for="inputText3" class="col-sm-2 col-form-label"  >medio: </label>
		<select name="medio" class="form-select" aria-label="Default select example">
  			<?PHP echo $medioI ?>
	</select>
	 </div>
	 <div class="col-sm-3">
     <label for="inputText3" class="col-sm-8 col-form-label"  >Fecha de  captación: </label>
     <input type="date" class="form-control" id="inputText3" placeholder="fecha" name="fecha" value="<?php echo $fecha ?>">
    </div>
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Intereses: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="intereses" name="intereses" value="<?php echo $intereses ?>" > 
    </div>
	 </div>	
   	 	 

	<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Campaña: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="campana" name="campana" value="<?php echo $campana ?>" >
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Tema: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="tema" name="tema" value="<?php echo $tema ?>" >	 
	 </div>
  </div> 
<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-8 col-form-label">Necesidad de espacio coworking: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="necesidad" name="necesidad" value="<?php echo $necesidad ?>" > 
    </div> 
	 
<div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Observaciones: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="observaciones" name="observaciones" value="<?php echo $observaciones ?>" >
    </div>
</div>
<div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit" class="btn btn-primary btn-lg " value="Modificar Lead">
</div>	
	 
	 
</form>

	

	

</body>
</html>