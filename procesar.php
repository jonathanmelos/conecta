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
		<h4 class="mb-3">Tu archivo .CSV ha sido cargado </h4>
	
	

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"])) {
  $archivo = $_FILES["archivo"];

  // Verificar si se subió el archivo sin errores
  if ($archivo["error"] == UPLOAD_ERR_OK) {
    $nombreTemporal = $archivo["tmp_name"];

    // Abrir el archivo CSV
    if (($archivoCSV = fopen($nombreTemporal, "r")) !== FALSE) {
      // Ignorar la primera línea (encabezados)
      fgetcsv($archivoCSV);

      // Recorrer cada línea del archivo
      while (($datos = fgetcsv($archivoCSV, 1000, ",")) !== FALSE) {
        // Limpiar y escapar los datos para evitar problemas de seguridad
        $datos = array_map([$conn, "real_escape_string"], $datos);

        $fecha_t = $datos[0];
        $fecha_objeto = DateTime::createFromFormat('d/m/y H:i', $fecha_t);
        $fecha = $fecha_objeto->format('Y-m-d');

        $nombre = $datos[1];

        // Verificar si el nombre ya existe en la base de datos
        $consultaExistencia = "SELECT * FROM leads WHERE nombre LIKE '%$nombre%'";
        $resultadoExistencia = $conn->query($consultaExistencia);

        if ($resultadoExistencia->num_rows > 0) {
          // Si existe coincidencia, actualizar los campos correspondientes
          $registroExistente = $resultadoExistencia->fetch_assoc();
          $idExistente = $registroExistente['sec_lead'];
			
          $medio = $datos[6];
          if ($medio == "Messenger") {
            $medio_imp = "fb";
          } elseif ($medio == "Instagram") {
            $medio_imp = "in";
          }
          // Actualizar los campos necesarios en el registro existente
          $consultaActualizacion = "UPDATE leads SET correo = '$datos[2]', telefono = '$datos[3]', fecha = '$fecha', medio = '$medio_imp' WHERE sec_lead = '$idExistente'";

          if ($conn->query($consultaActualizacion) !== TRUE) {
            echo "Error al actualizar datos: " . $conn->error;
          } else {
            echo "Se ha actualizado el registro existente para el lead '$nombre'.";
          }
        } else {
          // Si no hay coincidencia, insertar un nuevo registro
          $medio = $datos[6];
          if ($medio == "Messenger") {
            $medio_imp = "fb";
          } elseif ($medio == "Instagram") {
            $medio_imp = "in";
          }

          // Crear la consulta SQL de inserción
          $consulta = "INSERT INTO leads (nombre, correo, telefono, fecha, estado, medio) 
                       VALUES ('$nombre', '$datos[2]', '$datos[3]', '$fecha', 'CT', '$medio_imp')";

          // Ejecutar la consulta
          if ($conn->query($consulta) !== TRUE) {
            echo "Error al insertar datos: " . $conn->error;
          } else {
            echo "Se ha insertado un nuevo registro para el lead '$nombre'.";
          }
        }
      }

      // Cerrar el archivo CSV
      fclose($archivoCSV);

      echo "Los datos se han procesado correctamente.";
    } else {
      echo "Error al abrir el archivo CSV.";
    }
  } else {
    echo "Error al subir el archivo.";
  }
}

?>
		</div>
		
	</div>	
</body>
</html>		
