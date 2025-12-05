<?php 
include 'header.php'; ?>
<body>

<form action="reporte_cliente_registros.php" method="post" autocomplete="off">
 
 <div class="form-group row">
	 
    <label for="inputText3" class=" col-sm-2  col-form-label">Cliente:</label>
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
	  
    <input type="submit" class="btn btn-info btn-lg " value="Consultar registros">
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