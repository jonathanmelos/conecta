<form action="clientes_insertar.php" method="POST">
    <label for="search" class="form-label">Buscar:</label>
    <input type="text" id="documento" class="form-control" >
    <ul id="results"></ul>

    <!-- Campo de entrada oculto para almacenar el valor del documento seleccionado -->
    <input type="hidden" name="documento" id="documento_seleccionado">

    <!-- Agrega aquí otros campos de entrada -->

    <input type="submit" value="Enviar">
</form>


<style>
#results {
    position: absolute;
    list-style: none;
    margin: 0;
    padding: 0;
    border: 1px solid #ccc;
    border-top: none;
    width: calc(100% - 2px);
    max-height: 200px;
    overflow-y: auto;
    background-color: white;
    z-index: 1000;
}
#results li {
    padding: 10px;
}
#results li:hover {
    background-color: #eee;
    cursor: pointer;
}
</style>


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
                    list += '<li>' + results[i].documento + ' - ' + results[i].nombre + ' ' + results[i].apellido + '</li>';
                }
                document.getElementById('results').innerHTML = list;

                var items = document.querySelectorAll('#results li');
                for (var i = 0; i < items.length; i++) {
                    items[i].addEventListener('click', function(e) {
						
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