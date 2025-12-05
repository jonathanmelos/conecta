<?php 
date_default_timezone_set('America/Guayaquil');
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
$fecha = date('Y-m-d');
include 'header.php';
?>
<body>

<form action="lead_insertar.php" method="post">

  <div class="form-group row">
	 <div class="col-sm-8">
    <label for="inputText3" class="col-sm-4 col-form-label"  >Nombre y Apellido: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" required>
    </div>
	  <div class="col-sm-4">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Estado: </label>
     <select name="estado" class="form-select" aria-label="Default select example">
  			<option value="CT">contacto</option>
			 <option value="PR">prospecto</option>
	</select>
    </div> 
  </div>
  <div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Edad: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="edad" name="edad" >
    </div>
	  <div class="col-sm-3">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Sexo: </label>
     	<select name="sexo" class="form-select" aria-label="Default select example">
  			<option value="N">No definido</option>
			 <option value="H">Hombre</option>
			 <option value="M">Mujer</option>
		  </select>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label"  >Ingresos mensuales: </label>
     <input type="text" class="form-control" id="inputText3" placeholder="ingresos" name="ingresos" >
    </div> 
	 <div class="col-sm-4">
   	<label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" >
    </div>  
  </div>
 
 <div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <input type="email" class="form-control" id="inputText3" placeholder="correo" name="correo" >
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="direccion" name="direccion" >	 
	 </div><br><br>
  </div>
	<div class="form-group row">
	 <div class="col-sm-2">
    <label for="inputText3" class="col-sm-2 col-form-label">Emprendedor: </label>
    <select name="emprendedor" class="form-select" aria-label="Default select example">
			<option value="si">Si</option>	
  			 <option value="no">No</option>
			 
		  </select>
    </div>
	 <div class="col-sm-3">
    <label for="inputText3" class="col-sm-10 col-form-label">Tamaño empresa: </label>
    <select name="tam_emp" class="form-select" aria-label="Default select example">
  			 <option value="1">De 1 - 10</option>
			 <option value="50">De 10 - 50 </option>
			 <option value="100">De 50 - 100 </option>
			 <option value="101">De 100 adelante </option>
	</select> 
    </div> 
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Industria / Área de Negocio: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="area_negocio" name="area_negocio" > 
    </div>  	
	</div>
 <div class="form-group row">
 
    <div class="col-sm-2">
        <label for="inputText3" class="col-sm-2 col-form-label"  >medio: </label>
		<select name="medio" class="form-select" aria-label="Default select example">
  			<option selected   >Elige un medio</option>
			 <option value="fb">Facebook</option>
			 <option value="in">Instagram</option>
			 <option value="tk">Tiktok</option>
			 <option value="web">Web</option>
			 <option value="wp">Whatsapp</option>
			 <option value="rf">Referido</option>
			<option value="ot">otro</option>
	</select>
	 </div>
	 <div class="col-sm-3">
     <label for="inputText3" class="col-sm-2 col-form-label"  >Fecha: </label>
     <input type="date" class="form-control" id="inputText3" placeholder="fecha" name="fecha" value="<?php echo $fecha ?>">
    </div>
	 <div class="col-sm-7">
    <label for="inputText3" class="col-sm-8 col-form-label">Intereses: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="intereses" name="intereses" > 
    </div>
	 </div>	
   	 	 

	<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Campaña: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="campana" name="campana" >
    </div>
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-2 col-form-label"  >Tema: </label>
	<input type="text" class="form-control" id="inputText3" placeholder="tema" name="tema" >	 
	 </div>
  </div> 
<div class="form-group row">
	 <div class="col-sm-5">
    <label for="inputText3" class="col-sm-8 col-form-label">Necesidad de espacio coworking: </label>
    <input type="text" class="form-control" id="inputText3" placeholder="necesidad" name="necesidad" > 
    </div> 
	 
	 <div class="col-sm-7">
	 <label for="inputText3" class="col-sm-10 col-form-label"  >Observaciones:</label>
	<input type="text" class="form-control" id="inputText3" placeholder="observaciones" name="observaciones" >
	 </div>
  </div> 

   </div>
<div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit" class="btn btn-primary btn-lg " value="Registar Nuevo Lead">
</div>	
	 
	 
</form>

	

	

</body>
</html>