<?php 
include('conexion.php');
include 'header.php';
$id = $_GET['id'];
$sql = "SELECT * FROM calendario WHERE id_cal  = $id";
$resultado = mysqli_query($conn, $sql);
$datos = mysqli_fetch_assoc($resultado);
$motivo = $datos['motivo'];
$telefono = $datos['telefono'];
$fecha = $datos['fecha'];
$nombre = $datos['nombre'];
$mensaje = $datos['mensaje'];
$sec_lead = $datos['sec_lead'];

?>
<body>
<div class="container">
 <div class="row">
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Datos del Cliente</h4>
        <h4> Nombre:</h4>
        <p class="mb-0"><?php echo $nombre ?></p>
        <h4> Teléfono:</h4>
        <p class="mb-0"><?php echo $telefono ?></p>
        <h4> Motivo:</h4>
        <p class="mb-0"><?php echo $motivo ?></p>
        <h4> Mensaje:</h4>
        <p class="mb-0"><?php echo $mensaje ?></p>

      </div>
	<div class="col-md-5 col-lg-4 order-md-last">
	<h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-primary">Regresar a calendario </span>
    </h4>	
	 <div class="col-sm-12">	
	<a class="btn btn-primary btn-lg btn-block" href="telf_t.php?id=<?php echo $id ?>&sec_lead=<?php echo $sec_lead ?>" role="button">Llamada realizada</a>
		</div><br>

    
    </div>	
</div>
</div>

</div>
</body>
</html>