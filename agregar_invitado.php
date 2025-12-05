<?php 
include 'conexion.php';
include 'header.php';
$cliente = $_GET['invitado'];
$secuencial = $_GET['sec'];



$query = "SELECT * FROM registro WHERE secuencial_R = $secuencial"; 
$result2 = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result2);

if (empty($row['invitado'])) {
	$sql = "SELECT * FROM clientes WHERE documento = $cliente"; 
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
 
    $Cli = mysqli_fetch_assoc($result);
    $nombre = $Cli['nombre']; 
	$apellido = $Cli['apellido']; 

	  // Aquí va el texto que proporcionaste
    echo "<form action='agregar_invitado_bd.php' method='post' autocomplete='off'>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Documento:</label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' name='documento2' value='".$cliente." '></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Nombre: </label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' placeholder='nombre' name='nombre' value='".$nombre."'></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Apellido: </label>
        <div class='col-sm-10'>
            <fieldset disabled=''>
                <input type='text' class='form-control' id='inputText3' placeholder='apellido' name='apellido' value='".$apellido."'></fieldset><br>
        </div>
    </div>
    <div class='form-group row'>
        <label for='inputText3' class='col-sm-2 col-form-label'>Invitado por:</label>
        <div class='col-sm-10'>
            <input type='text' id='documento' class='form-control' placeholder='buscar cliente '>
            <ul id='results'></ul><br> 
            <!-- Campo de entrada oculto para almacenar el valor del documento seleccionado -->
            <input type='hidden' name='documento' id='documento_seleccionado'>
            <input type='hidden' name='secuencial' value='".$secuencial."'>	 
        </div><br>
    </div>	 
	
	
    <div class-'d-grid gap-2 col-6 mx-auto'>
	         <input type='submit' class='btn btn-success btn-lg' value='Agregar Invitado a  Cliente'>
    </div>	
</form>";
	
} else {
    echo "Registro no encontrado";
}
	
}else { echo "Este cliente se encuentra agregado dentro de otro cliente <br> Espera se te redirigirá"; 
	  echo "<script>setTimeout(function(){ window.location.href = 'registro.php'; }, 5000);</script>";
	  }

 ?>
<body>

<script>
function doSearch() {
    var search = document.getElementById('documento').value;
    if (search.length >= 3) {
        fetch('buscar_horas.php?search=' + encodeURIComponent(search))
            .then(function(response) {
                return response.json();
            })
            .then(function(results) {
                var list = '';
                for (var i = 0; i < results.length; i++) {
                    // Agregar un atributo data-documento a cada elemento de la lista desplegable
                    list += '<li data-documento="' + results[i].documento + '">' + results[i].documento + ' - ' + results[i].nombre + ' ' + results[i].apellido + '</li>';
                }
                document.getElementById('results').innerHTML = list;

                var items = document.querySelectorAll('#results li');
                for (var i = 0; i < items.length; i++) {
                    items[i].addEventListener('click', function(e) {
                        // Actualizar el valor del campo de entrada oculto con el valor del documento seleccionado
                        document.getElementById('documento_seleccionado').value = e.target.getAttribute('data-documento');
                        // Actualizar el valor del campo de búsqueda con el texto del elemento seleccionado
                        document.getElementById('documento').value = e.target.innerText;
                        document.getElementById('results').innerHTML = '';
                    });
                }
            });
    } else {
        document.getElementById('results').innerHTML = '';
    }
}
document.getElementById('documento').addEventListener('input', doSearch);
</script>
</body>
</html>