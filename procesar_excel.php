<?php
include 'header.php';
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
?>
<body>
	
	<div class="container">
  <div class="row">
    <div class="col-md-4 col-lg-6"> 
   
    </div>	 
    <div class="col-md-4 col-lg-3">	
     
    </div>	
	  <div class="col-md-2 col-lg-3">	
      <a href="embudo.php">
        <button type="button" class="btn btn-outline-info">Regresar a Embudo</button>
      </a> 
	  
    </div>	 
  </div>		
	<div class="abs-center">
		<h4 class="mb-3">Tu archivo EXCEL ha sido cargado </h4>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"])) {
    $archivo = $_FILES["archivo"];

    // Verificar si se subió el archivo sin errores
    if ($archivo["error"] == UPLOAD_ERR_OK) {
        $nombreTemporal = $archivo["tmp_name"];

        // Incluir la librería PhpSpreadsheet
        require 'vendor/autoload.php';

        // Cargar el archivo Excel
        $documento = PhpOffice\PhpSpreadsheet\IOFactory::load($nombreTemporal);
        $hoja = $documento->getActiveSheet();
        $filas = $hoja->toArray(null, true, true, true); // Obtener todas las filas del archivo

        // Ignorar la primera fila (encabezados)
        unset($filas[1]);

        // Recorrer cada fila y obtener los datos
        foreach ($filas as $fila) {
            $nombre = $fila['A'];
			$documento = $fila['B'];
            $correo = $fila['C'];
			$direccion = $fila['D'];
			$telefono = $fila['E'];
            $fecha = $fila['F'];
            $estado = $fila['G'];
			$edad = $fila['H'];
			$sexo = $fila['I'];
            $ingresos = $fila['J'];
            $intereses = $fila['K'];
			$medio = $fila['L'];
			$campana = $fila['M'];
            $tema = $fila['N'];
            $emprendedor = $fila['O'];
			$empresa_tamano = $fila['P'];
			$area_negocio = $fila['Q'];
			$necesidad = $fila['R'];
			$observaciones = $fila['S'];
			// Obtener los demás datos de cada columna según corresponda

            // Realizar las transformaciones necesarias en los datos si es requerido
			if (empty($medio)) {
					// Acciones a realizar si la variable $red está vacía
					$medioS = "ot";
					// ... otras acciones específicas
				} else {
					
					$medioS = $conn->real_escape_string($medio);
					}
			// Escapar los datos para evitar problemas de seguridad				
			$nombre = $conn->real_escape_string($nombre);
			$documento = $conn->real_escape_string($documento);
            $correo = $conn->real_escape_string($correo);
			$direccion = $conn->real_escape_string($direccion);
			$telefono = $conn->real_escape_string($telefono);
            $fecha = $conn->real_escape_string($fecha);
            $estado =$conn->real_escape_string($estado);
			$edad = $conn->real_escape_string($edad);;
			$sexo = $conn->real_escape_string($sexo);
            $ingresos = $conn->real_escape_string($ingresos);
            $intereses = $conn->real_escape_string($intereses);
			$campana = $conn->real_escape_string($campana);
            $tema = $conn->real_escape_string($tema);
            $emprendedor = $conn->real_escape_string($emprendedor);
			$empresa_tamano = $conn->real_escape_string($empresa_tamano);;
			$area_negocio = $conn->real_escape_string($area_negocio);
			$necesidad = $conn->real_escape_string($necesidad);
			$observaciones = $conn->real_escape_string($observaciones);
					
		
            // Escapar y formatear los demás datos

			
			
						  // Construir la consulta SQL de búsqueda
				$consultaBuscar = "SELECT * FROM leads WHERE nombre = '$nombre'";

				// Ejecutar la consulta de búsqueda en la base de datos
				$resultado = $conn->query($consultaBuscar);

				if ($resultado->num_rows > 0) {
					
				// Ya existe un registro con el mismo nombre, realizar la actualización
					
					$consultaActualizar = "UPDATE leads SET 
					documento = '$documento',
					nombre = '$nombre', 					 
					correo = '$correo', 
					direccion = '$direccion', 
					telefono = '$telefono', 
					fecha = '$fecha', 
					estado = '$estado',
					campana = '$campana', 
					tema = '$tema', 
					medio = '$medioS',
					edad = '$edad', 
					sexo = '$sexo', 
					ingresos = '$ingresos', 
					intereses = '$intereses', 
					emprendedor = '$emprendedor', empresa_tamano = '$empresa_tamano', area_negocio = '$area_negocio', necesidad = '$necesidad', 
					observaciones = '$observaciones'
					WHERE nombre = '$nombre'";
					
						

					if ($conn->query($consultaActualizar) !== TRUE) {
						echo "Error al actualizar datos: " . $conn->error;
					}
				} else {
					// No existe un registro con el mismo nombre, realizar la inserción
					$consultaInsertar = "INSERT INTO leads (documento, nombre, correo, direccion, telefono, fecha, estado, campana, tema, medio, edad, sexo, ingresos, intereses, emprendedor, empresa_tamano, area_negocio, necesidad, observaciones)
                      VALUES ('$documento', '$nombre', '$correo', '$direccion', '$telefono', '$fecha', '$estado', '$campana', '$tema', '$medioS', '$edad', '$sexo', '$ingresos', '$intereses', '$emprendedor', '$empresa_tamano', '$area_negocio', '$necesidad', '$observaciones')";

					if ($conn->query($consultaInsertar) !== TRUE) {
						echo "Error al insertar datos: " . $conn->error;
					}
				}

			
			
        }

        // Mostrar mensaje de éxito
        echo "La información se ha insertado correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
</div>
		
	</div>	
</body>
</html>	
