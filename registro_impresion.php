<?php 
include 'conexion.php';
include 'header.php';
$cliente = $_GET['id'];
$secuencial = $_GET['sec'];



$sql = "SELECT * FROM clientes WHERE documento = $cliente"; 
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
 
    $Cli = mysqli_fetch_assoc($result);
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 

	 
	
} else {
    echo "Registro no encontrado";
}
	


 ?>

 <form action='registro_impresion_bd.php' method='post' autocomplete='off'>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Documento:</label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' name='documento2' value='<?php  echo $cliente ?> '></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Nombre: </label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' placeholder='nombre' name='nombre' value='<?php echo $nombre ?>'></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Apellido: </label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' placeholder='apellido' name='apellido' value='<?php echo $apellido ?>'></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Impresiones</label>
        <div class='col-sm-10'>
            <input type='number' id='impresion'  name='impresion'  class='form-control' placeholder='cantidad impresiones ' required>
                       
            <input type='hidden' name='secuencial' value='<?php echo $secuencial ?>'>	 
        </div>
		
		
    </div>	 
	
	  
    <div class="d-grid gap-2 col-6 mx-auto">
	         <br><br><input type='submit' class='btn btn-success btn-lg' value='Agregar Impresiones'>
    </div>
		 
</form>




</body>
</html>