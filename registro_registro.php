<?php 
include 'header.php';
?>
<body>
	
 <div class="row">
	 <div class="col-md-5 col-lg-6">
		 <h4 class="mb-3">Busca un cliente</h4>
		 <div class="row g-3">
			 <div class="col-sm-3">
				 <label for="firstName" class="form-label">Documento:</label>
			</div>
			 <div class="col-sm-9">	 
				 <input type="text" id="documento" class="form-control" >
		 	</div>
			 <div class="col-sm-3">
				 <label for="firstName" class="form-label">Nombre:</label>
			</div>
			 <div class="col-sm-9">	 
				 <input type="text" id="nombre" class="form-control" >
		    </div>
			<div class="col-sm-3">
				<label for="firstName" class="form-label">Apellido:</label>
			</div>
			 <div class="col-sm-9">	
				<input type="text" id="apellido" class="form-control" >
			</div>

<div id="results">
			 
			 </div>
		 
		 </div>

	</div>
	 <div class="col-md-5 col-lg-6">
	  <h4 class="mb-3">Agregar nuevo cliente</h4>
	<div class="d-grid gap-2 col-6 mx-auto">
	 <a href="clientes_registro.php">
    <button type="button" class="btn btn-primary  btn-lg">Crear nuevo cliente</button>
</a> 
    </div>		 
	 </div>
	</div>	 
<script>
// Función para realizar la búsqueda y actualizar los resultados
function doSearch() {
    // Obtener los valores de los campos de entrada
    var documento = document.getElementById('documento').value;
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;

    // Enviar una solicitud AJAX al archivo search.php para realizar la búsqueda
    fetch('buscar.php?documento=' + encodeURIComponent(documento) + '&nombre=' + encodeURIComponent(nombre) + '&apellido=' + encodeURIComponent(apellido))
        .then(function(response) {
            return response.json();
        })
        .then(function(results) {
            // Crear una tabla para mostrar los resultados
            var table = '<table class="table table-striped">';
            table += ' <thead><tr><th scope="col">Documento</th><th scope="col" >Nombre</th><th>Apellido</th><th scope="col">Seleccionar</th></tr> </thead>';
            for (var i = 0; i < results.length; i++) {
                table += '<tr>';
                table += '<td>' + results[i].documento + '</td>';
                table += '<td>' + results[i].nombre + '</td>';
                table += '<td>' + results[i].apellido + '</td>';
				table += '<td><a href="planes_modificar.php?id='+results[i].documento+'"><button class="btn btn-success">Sleccionar</button></a></td>';
                table += '</tr>';
            }
            table += '</table>';

            // Mostrar la tabla en el contenedor de resultados
            document.getElementById('results').innerHTML = table;
        });
}

// Agregar controladores de eventos input a los campos de entrada
document.getElementById('documento').addEventListener('input', doSearch);
document.getElementById('nombre').addEventListener('input', doSearch);
document.getElementById('apellido').addEventListener('input', doSearch);
</script>
	 
</body>
</html>