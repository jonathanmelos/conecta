<?php 
include('conexion.php'); // Incluye el archivo de conexión a la base de datos
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear una instancia de la hoja de cálculo
$hoja = new Spreadsheet();
$hoja->getActiveSheet()->setTitle('Leads');

// Obtener los datos de la tabla "leads" desde la base de datos
$consulta = "SELECT * FROM leads";
$resultado = $conn->query($consulta);

// Encabezados de columna
$encabezados = [
  'documento',
  'nombre',
  'correo',
  'direccion',
  'telefono',
  'fecha',
  'estado',
  'campana',
  'tema',
  'medio',
  'edad',
  'sexo',
  'ingresos',
  'intereses',
  'emprendedor',
  'empresa_tamano',
  'area_negocio',
  'necesidad',
  'observaciones',
];

// Escribir los encabezados en la hoja de cálculo
$hoja->getActiveSheet()->fromArray($encabezados, NULL, 'A1');

// Escribir los datos en la hoja de cálculo
$contadorFila = 2;
while ($fila = $resultado->fetch_assoc()) {
  // Verificar si la variable $red está vacía
  if (empty($fila['medio'])) {
    // Acciones a realizar si la variable $red está vacía
    // ...
  } else {
    // Acciones a realizar si la variable $red NO está vacía
    // ...
  }

  // Eliminar la columna "sec_lead" de los datos de la fila
  unset($fila['sec_lead']);

  // Escribir los datos en la hoja de cálculo sin la columna "sec_lead"
  $hoja->getActiveSheet()->fromArray($fila, NULL, 'A' . $contadorFila);
  $contadorFila++;
}

// Crear el objeto Writer para guardar el archivo Excel
$writer = new Xlsx($hoja);

// Definir el nombre del archivo Excel a descargar
$nombreArchivo = 'leads.xlsx';

// Establecer las cabeceras para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en la salida del navegador
$writer->save('php://output');

?>