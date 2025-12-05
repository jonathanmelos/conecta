<?php 
include 'header.php'; ?>
<body>

<form action="clientes_insertar_horas.php" method="post" autocomplete="off">
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label" >Documento:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="cédula / pasaporte" name="documento2" required ><br>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Nombre: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="nombre" name="nombre" required><br>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Apellido: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="apellido" name="apellido" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Correo: </label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputText3" placeholder="correo" name="correo" ><br>
    </div>
  </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Dirección: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="direccion" name="direccion" ><br>
    </div>
 <div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Teléfono: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputText3" placeholder="telefono" name="telefono" ><br>
    </div>	 
  </div>
	 
<div class="form-group row">
    <label for="inputText3" class="col-sm-2 col-form-label"  >Servicio: </label>
    <div class="col-sm-10">
      <select name="servicio" class="form-select" aria-label="Default select example" required>
  <option selected   >Elige un servicio</option>
		  <option value="cowork">Cowork</option>
		  <option value="sala" >Sala reuniones</option>
 
</select><br>
    </div>	 
  </div>	 
 <div class="form-group row">
	 
    <label for="inputText3" class=" col-sm-2  col-form-label">Invitado por:</label>
	 <div class="col-sm-10">
    <input type="text" id="documento" class="form-control" placeholder="buscar cliente " >
    <ul id="results"></ul>
		<br> 

    <!-- Campo de entrada oculto para almacenar el valor del documento seleccionado -->
    <input type="hidden" name="documento" id="documento_seleccionado">
         

	</div>	
		
		<br>
    </div>	 
  </div>	 
 
	
	
	 
 
<div class="d-grid gap-2 col-6 mx-auto">
	  
    <input type="submit" class="btn btn-success btn-lg " value="Registar Cliente Horas">
</div>	
	 
	 
</form>

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