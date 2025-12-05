<?php

require 'vendor/autoload.php'; // Carga las dependencias de Composer

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

// Configura Selenium WebDriver
$host = 'http://localhost:4444/wd/hub'; // URL del servidor Selenium WebDriver
$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

// Obtén los datos del formulario
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];

// Abre WhatsApp Web en el navegador
$driver->get('https://web.whatsapp.com/');

// Espera a que el usuario escanee el código QR y esté listo para enviar mensajes
// Aquí puedes implementar tu lógica de espera, por ejemplo, esperar a que aparezca un elemento específico en la página

// Busca el campo de búsqueda y escribe el número de teléfono
$campoBusqueda = $driver->findElement(WebDriverBy::cssSelector('.jN-F5._3F6QL'));
$campoBusqueda->sendKeys($telefono);

// Espera a que aparezca el contacto en los resultados de búsqueda
// Aquí puedes implementar tu lógica de espera, por ejemplo, esperar a que aparezca un elemento específico en la página

// Haz clic en el contacto
$contacto = $driver->findElement(WebDriverBy::cssSelector('.jN-F5._3wU53'));
$contacto->click();

// Busca el campo de mensaje y escribe el texto del mensaje
$campoMensaje = $driver->findElement(WebDriverBy::cssSelector('.DuUXI'));
$campoMensaje->sendKeys($mensaje);

// Envía el mensaje presionando la tecla Enter
$campoMensaje->sendKeys(WebDriverKeys::ENTER);

// Cierra el navegador
$driver->quit();

// Redirige a una página de confirmación o muestra un mensaje de éxito
echo 'Mensaje enviado correctamente';

?>
