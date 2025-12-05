<?php 
include 'header.php';
?>
<body>
	
	<div class="container">
	<div class="abs-center">
		<h4 class="mb-3">Carga tu archivo .CSV aquí </h4>
	
		
<form method="POST" action="procesar.php" enctype="multipart/form-data" class="row g-3">
  <div class="col-auto">
    <input class="form-control" name="archivo" type="file" id="formFile">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3" value="Cargar">Cargar archivo</button>
  </div>
</form>		
			
		</div>
		
	</div>	
</body>
</html>