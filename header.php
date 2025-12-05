<?PHP 
session_start();
include 'functions.php';
include 'conexion.php';
if (!isset($_SESSION['user_id']) ) {
    header('Location: login_handler.php');
    exit();
}

date_default_timezone_set('America/Guayaquil');
$hoy = date('Y-m-d');
?>
 <!DOCTYPE html>
    <!-- Custom styles for this template -->
<html lang="es" data-bs-theme="auto">
  <head>
	 <script src="js/color-modes.js"></script>
     <script src="js/popper.min"></script>	 

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jonathan Melo">
    <meta name="generator" content="QW1.0">
    <title>Gestion Conecta Coworking</title>
<style>
    .custom-alert {
        position: absolute ;
        top: 0;
        left: -300px; /* Ocultar la alerta al inicio */
        width: 300px;
          background-color: #f8f9fa;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: left 0.3s ease-in-out;
        z-index: 1000;
        padding: 20px;
    }

    .custom-alert.show {
        left: 0;
    }

    .custom-alert .btn-close {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>	  
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/popper.min" >
<link href="css/estilo.css" > 
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>	 
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
 
<script>
        function sumarHoras() {
            // Obtener todas las filas de la tabla
            var filas = document.querySelectorAll('tbody tr');
            var totalHoras = 0;

            // Iterar sobre cada fila
            filas.forEach(function (fila) {
                // Obtener la celda que contiene la hora de entrada y la hora de salida
                var celdaEntrada = fila.children[2].innerText.trim();
                var celdaSalida = fila.children[3].innerText.trim();

                // Convertir las horas a segundos
                var horaEntrada = horaASegundos(celdaEntrada);
                var horaSalida = horaASegundos(celdaSalida);

                // Calcular la diferencia en segundos
                var diferencia = horaSalida - horaEntrada;

                // Sumar la diferencia al total de horas
                totalHoras += diferencia;
            });

            // Convertir el total de segundos a horas:minutos:segundos
            var horas = Math.floor(totalHoras / 3600);
            var minutos = Math.floor((totalHoras % 3600) / 60);
            var segundos = totalHoras % 60;

            // Mostrar el total de horas en el formato hh:mm:ss
            document.getElementById('totalHoras').innerText = horas + ':' + minutos + ':' + segundos;
        }

        function horaASegundos(hora) {
            var partes = hora.split(':');
            return parseInt(partes[0]) * 3600 + parseInt(partes[1]) * 60 + parseInt(partes[2]);
        }
    </script>
	  
	  
</head>	  
	  
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
  
#results {
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

tr[onclick] {
  cursor: pointer;
}
.texto_lead {
  width: 100%;
  padding: .375rem .75rem;
  font-size: 1.1rem;
  font-weight: 400;
  line-height: 1.5;
  color: var(--bs-body-color);
  background-color: #f7f7f7;
  background-clip: padding-box;
  border: var(--bs-border-width) solid var(--bs-border-color);
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border-radius: var(--bs-border-radius);
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}		

  .tooltipevent {
    width: 200px;
    height: 150px;
    background: #C6C6C6;
    position: absolute;
    z-index: 10001;
    color: black; /* Cambia el color del texto a negro */
  }
</style>
   
    <link href="pricing.css" rel="stylesheet">
 
  </header>
<div class="container py-3">
  
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      
        <img src='images/logo.jpg' alt='Salida' style='width: 150px; height: 65px;'>
		  
		  <span class="fs-6">&nbsp; &nbsp;  <?php echo "Bienvenido, " . $_SESSION['username']; ?><br> 
	<a href="logout.php" class="d-flex align-items-center link-body-emphasis text-decoration-none">
		&nbsp; &nbsp; &nbsp;<img src='images/salida.png' alt='Salida' style='width: 20px; height: 20px;'>
		Cerrar Sesión</span>
      </a>
		
	<?php 
		
		if ($_SESSION['admin'] == "admin"){
			
			echo "<nav class='d-inline-flex mt-2 mt-md-0 ms-md-auto'>
	<a class='me-3 py-2 link-body-emphasis text-decoration-none' href='diario.php?fecha=".$hoy."'>Diario</a>
    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='registro.php?doc=0'>Registro</a>
    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='clientes.php'>Cliente</a>
	 <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='calculadora.php'>Calculadora</a>
    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='planes.php'>Planes</a>
    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='reportes.php'>Reportes</a>

	
</nav> 
";
		}else {
				echo "<nav class='d-inline-flex mt-2 mt-md-0 ms-md-auto'>
	    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='registro.php?doc=0'>Registro</a>
    <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='clientes_r.php'>Cliente</a>
	 <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='calculadora.php'>Calculadora</a>
     <a class='me-3 py-2 link-body-emphasis text-decoration-none' href='reportes.php'>Reportes</a>
	 
</nav> 
";
			
		}
		
		
		?>

     
       </nav>
</div>	
    

