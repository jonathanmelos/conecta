<?php 
date_default_timezone_set('America/Guayaquil');
$hoy = date('Y-m-d');
include 'header.php';
?>
<div class="container">
	<div class="row">	
	<div class="col-md-7 col-lg-6">

<form action="calculadora_cal.php" method="post">
  	<div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Número de personas</label>
    <div class="form-group col-md-8">
       <input type="number" class="form-control" id="personas" name="personas" value="0">
		<small id="emailHelp" class="form-text text-muted">¿Cuántas personas acompañarían al titular?. <br>Ingresar el número más el titular</small>
	</div>
  </div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Horas por visita</label>
    <div class="form-group col-md-8">	
    <input type="number" class="form-control" id="horas" name="horas" value="0">
	<small id="emailHelp" class="form-text text-muted">Promedio de horas que utilizarían el espacio de Coworking</small>
    </div>
</div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Cuantas veces por semana:</label>
    <div class="form-group col-md-8">	
    <input type="number" class="form-control" id="visita" name="visita" value="0">
	<small id="emailHelp" class="form-text text-muted">Días a la semana que visitarían Conecta Cowork </small> 
	</div>
  </div>
<div class="form-group row">
    <div class="form-group col-md-12">
		<br>
      <button type="submit" class="btn btn-primary btn-lg btn-block ">Calcular</button>		
	</div>
 </div>	
</form>
	
	
			
		</div>
	<div class="col-md-5 col-lg-6 order-md-last">
	<h4 class="d-flex justify-content-between align-items-center mb-3"> 
		<span class="text-primary">Plan sugerido </span></h4>	
		<ul class="list-group mb-3">
		<li class="list-group-item d-flex justify-content-between lh-sm">
		Ingreso los datos para sugerir un Plan</li>
		</ul>
		<ul class="list-group mb-3">
		<h6 class="d-flex justify-content-between align-items-center mb-3"> 
		Otros planes </h6>	
		<li class="list-group-item d-flex justify-content-between lh-sm">
		<div class="container">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Plan</th>
      <th scope="col">Cowork</th>
      <th scope="col">Sala</th>
      <th scope="col">Impre</th>
	  <th scope="col">Evento</th>
	  <th scope="col">Precio</th>
	
    </tr>
  </thead>
  <tbody>			
				  <tr><th scope="row">basic</th><td>20</td><td>2</td><td>10</td><td>0</td><td>39.99</td></tr><tr><th scope="row">standard</th><td>40</td><td>3</td><td>20</td><td>2</td><td>69.99</td></tr><tr><th scope="row">premium</th><td>80</td><td>4</td><td>30</td><td>3</td><td>99.99</td></tr><tr><th scope="row">gold</th><td>160</td><td>6</td><td>40</td><td>4</td><td>149.99</td></tr></tbody></table>			</div>
			</li>
		</ul>
		
		</div>	
		</div>
	</div>
</html>