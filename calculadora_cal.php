<?php 
date_default_timezone_set('America/Guayaquil');
$hoy = date('Y-m-d');
include 'header.php';
$personas = $_POST['personas'];
$horas = $_POST['horas'];
$visita = $_POST['visita'];

//operaciones
$dias_mes = $visita * 4;
$usoplan= $personas * $horas * $dias_mes ;

//llamada a la base de datos 

include 'conexion.php';

?>
<body>
	
	<div class="container">
	<div class="row">	
	<div class="col-md-7 col-lg-6">

<form action="calculadora_cal.php"  method="post">
  	<div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Número de personas</label>
    <div class="form-group col-md-8">
       <input type="number" class="form-control" id="personas" name="personas" value="<?php echo $personas ?>">
		<small id="emailHelp" class="form-text text-muted">¿Cuántas personas acompañarían al titular?. <br>Ingresar el número más el titular</small>
	</div>
  </div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Horas por visita</label>
    <div class="form-group col-md-8">	
    <input type="number" class="form-control" id="horas" name="horas"  value="<?php echo $horas ?>">
	<small id="emailHelp" class="form-text text-muted">Promedio de horas que utilizarían el espacio de Coworking</small>
    </div>
</div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Cuantas veces por semana:</label>
    <div class="form-group col-md-8">	
    <input type="number" class="form-control" id="visita" name="visita" value="<?php echo $visita ?>" >
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
		
		<span class="text-primary" >Plan sugerido </span></h4>	
	<h6 class="d-flex justify-content-between align-items-center mb-3"> 
			Total horas al mes : <?php echo  $usoplan?> </h6>		
		
		<ul class="list-group mb-3">
		
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
<?php
$sql = "SELECT * FROM planes ORDER BY ABS(cowork - $usoplan) LIMIT 1;";
$result = mysqli_query($conn,$sql);
	
$row = mysqli_fetch_assoc($result);
	$codigo = $row['codigo'];
	$nombre = $row['nombre'];
	$cowork = $row['cowork'];
	$sala = $row['sala_reuniones']; 
	$impresiones = $row['impresiones'];
	$evento = $row['evento'];
	$precio = $row['precio'];
	
    echo "<tr>";
    echo "<th scope='row'>" . $nombre . "</th>";
    echo "<td>" . $cowork. "</td>";
    echo "<td>" . $sala . "</td>";
    echo "<td>" . $impresiones . "</td>";
    echo "<td>" . $evento . "</td>";
    echo "<td>" . $precio  . "</td>";
	echo "</tr>";
	
echo "</table>";

?>
			</li>
		</ul>
		<ul class="list-group mb-3">
		<h6 class="d-flex justify-content-between align-items-center mb-3"> 
		Otros planes </h6>	
		<li class="list-group-item d-flex justify-content-between lh-sm">
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
 <?php
	  
$sql2 = "SELECT * FROM planes WHERE codigo !=$codigo;";	  
$result2 = mysqli_query($conn,$sql2);
	
while($row = mysqli_fetch_assoc($result2)) {
	
	$nombre = $row['nombre'];
	$cowork = $row['cowork'];
	$sala = $row['sala_reuniones']; 
	$impresiones = $row['impresiones'];
	$evento = $row['evento'];
	$precio = $row['precio'];	
    echo "<tr>";
    echo "<th scope='row'>" . $nombre . "</th>";
    echo "<td>" . $cowork. "</td>";
    echo "<td>" . $sala . "</td>";
    echo "<td>" . $impresiones . "</td>";
    echo "<td>" . $evento . "</td>";
    echo "<td>" . $precio  . "</td>";
	echo "</tr>";

}

echo "</table>";

mysqli_close($conn);
?>  
			</li>
		</ul>
		
		</div>	
		</div>
	</div>	
</body>
</html>