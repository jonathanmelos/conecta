<?php 
include 'header.php';
?>

<body>
	<div class="container">
	<div class="abs-center">
	<div class="row">
    <div class="col-md-4 col-lg-5"> 
     <h4 class="mb-3">Carga tu archivo EXCEL .XLSX aquí </h4>
	
		
<form method="POST" action="procesar_excel.php" enctype="multipart/form-data" class="row g-3">
  <div class="col-auto">
    <input class="form-control" name="archivo" type="file" id="formFile">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3" value="Cargar">Cargar archivo</button>
  </div>
</form>		
    </div>	 
    <div class="col-md-2 col-lg-2">	
      
    </div>	
	  <div class="col-md-4 col-lg-5">	
      <a href="archivos/plantilla.xlsx" download>
  <button type="button" class="btn btn-outline-info">Descargar Plantilla</button>
</a>
	 <a href="descargar_xls.php">
        <button type="button" class="btn btn-outline-info">Descargar BD en Excel</button>
      </a> 	  
    </div>	 
  </div>
	
	
	
		

			
		</div>
		
	</div>	
</body>
</html>
