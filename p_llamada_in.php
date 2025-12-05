<?php
include 'conexion.php';
$accion = $_POST['accion'];
$fecha = $_POST['fecha'];
$motivo = $_POST['motivo'];
$mensaje = $_POST['mensaje'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si se ha enviado el arreglo "clientes" en el formulario
  if (isset($_POST['clientes']) && is_array($_POST['clientes'])) {
    // Obtener los valores seleccionados de los checkboxes
    $clientesSeleccionados = $_POST['clientes'];

    // Iterar sobre los valores seleccionados
    foreach ($clientesSeleccionados as $cliente) {
      // Consulta adicional para obtener correo y teléfono del cliente desde la tabla leads
      $consultaLeads = "SELECT correo, telefono, nombre FROM leads WHERE sec_lead = '$cliente'";
      $resultLeads = mysqli_query($conn, $consultaLeads);

      // Verificar si la consulta SELECT se ejecutó correctamente
      if ($resultLeads) {
        // Obtener los datos de correo y teléfono del cliente
        $row = mysqli_fetch_assoc($resultLeads);
        $correo = $row['correo'];
        $telefono = $row['telefono'];
		$nombre = $row['nombre']; 

        // Construir la consulta INSERT INTO con los valores recibidos y los valores de correo y teléfono obtenidos
        $query = "INSERT INTO calendario (nombre, accion, motivo, fecha, telefono, correo, mensaje, estado, sec_lead ) VALUES ('$nombre', '$accion', '$motivo', '$fecha', '$telefono', '$correo', '$mensaje', 'P', '$cliente')";

        // Ejecutar la consulta INSERT INTO
        $result = mysqli_query($conn, $query);

        // Verificar si la consulta INSERT INTO se ejecutó correctamente
        if ($result) {
          echo "Cliente seleccionado " . $cliente . " insertado en la base de datos correctamente.<br>";
        } else {
          echo "Error al insertar el cliente seleccionado " . $cliente . ": " . mysqli_error($conn) . "<br>";
        }
      } else {
        echo "Error al obtener los datos de correo y teléfono del cliente " . $cliente . ": " . mysqli_error($conn) . "<br>";
      }
    }
  } else {
    echo "No se ha seleccionado ningún cliente.";
  }
}
	
header('Location: calendario.php');
?>
