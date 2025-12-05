<?php 
include('conexion.php');
include 'header.php';
$id = $_GET['id'];
$sql = "SELECT * FROM calendario WHERE id_cal  = $id";
$resultado = mysqli_query($conn, $sql);
$datos = mysqli_fetch_assoc($resultado);
$motivo = $datos['motivo'];
$correo = $datos['correo'];
$mensaje = $datos['mensaje'];
$fecha = $datos['fecha'];
$sec_lead = $datos['sec_lead'];
$fechaFormateada = date('Y-m-d', strtotime($fecha));

?>
<body>

<div class="container">
    <h1>Enviar correo</h1>
    <form action="enviar_correo.php" method="POST">
        <div class="form-group">
			<input type="hidden" class="form-control" id="nombre" name="fecha" value="<?php echo $fechaFormateada ?>">
			<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">
            <input type="hidden" class="form-control" id="sec_lead" name="sec_lead" value="<?php echo $sec_lead ?>">
            <label for="nombre">Motivo:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $motivo ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $correo ?>" required>
        </div>
        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" ><?php echo $mensaje ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<script>
    tinymce.init({
        selector: '#mensaje',
        height: 300,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor code',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
    });
</script>

</body>
</html>