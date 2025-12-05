<?php 
include 'header.php';
include 'conexion.php';

?>

<script>
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      // Configuración del calendario
      // Aquí puedes personalizar las opciones según tus necesidades
      events: [
        <?php
        // Realizar la consulta a la base de datos para obtener los registros de la tabla "calendario"
        $sql = "SELECT nombre, accion, motivo, telefono, correo, fecha FROM calendario WHERE estado = 'P'";
        $result = mysqli_query($conn, $sql);

        // Verificar si se obtuvieron resultados
        if ($result) {
          // Iterar sobre los registros y generar los eventos del calendario
          while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['nombre'];
			$fecha = $row['fecha'];  
		  	$start = date('Y-m-d\TH:i:s', strtotime($fecha));
			 $accion = $row['accion'];
			
			 if($accion=='ll'){
				 $accionI="LLAMAR";
				 $backgroundColor = "rgb(255, 170, 7)";
			 }elseif($accion=='co'){
				 $accionI="ENVIAR CORREO";
				 $backgroundColor = "#0d6efd";
			 }elseif($accion=='wp'){
				 $accionI="ENVIAR wHATSAPP";
				 $backgroundColor = "#146c43";
			 }  
			  
			  
			if (array_key_exists('motivo', $row)) {
				  $description = $row['motivo'];
				} else {
				  $description = "";
				}  
			 if (array_key_exists('telefono', $row)) {
				  $telefono = $row['telefono'];
				} else {
				  $telefono = "";
				}  
			if (array_key_exists('correo', $row)) {
				  $correo = $row['correo'];
				} else {
				  $correo = "";
				}
			if (array_key_exists('mensaje', $row)) {
				  $mensaje = $row['mensaje'];
				} else {
				  $mensaje = "";
				}			 
			
			
			  
			  
            // Generar el evento del calendario
            echo "{";
            echo "title: '$title',";
            echo "start: '$start',";
            echo "description: ' $accionI <br> para: $description<br>$telefono<br>$correo',";
            echo "backgroundColor: '$backgroundColor'";
			echo "},";
          }
        }
        ?>
      ],
      dayClick: function(date, jsEvent, view) {
        // Redirigir al usuario a una página o abrir una ventana emergente para agregar un nuevo evento en el día seleccionado
        // Aquí puedes personalizar la lógica de redirección según tus necesidades
        window.location.href = 'detalle_evento.php?fecha=' + date.format();
      },
      eventMouseover: function(event, jsEvent, view) {
        // Mostrar una ventana emergente con la información del evento
        var tooltip = '<div class="tooltipevent" style="width:300px;height:150px;background:#C6C6C6;position:absolute;z-index:10001;">' + event.title + '<br>' + event.description + '</div>';
        $("body").append(tooltip);
        $(this).mouseover(function(e) {
          $(this).css('z-index', 10000);
          $('.tooltipevent').fadeIn('500');
          $('.tooltipevent').fadeTo('10', 1.9);
        }).mousemove(function(e) {
          $('.tooltipevent').css('top', e.pageY + 10);
          $('.tooltipevent').css('left', e.pageX + 20);
        });
      },
      eventMouseout: function(event, jsEvent, view) {
        $(this).css('z-index', 8);
        $('.tooltipevent').remove();
      }
    });
  });
</script>
<body>
  <div class="container">
    <div class="abs-center">
      <h4 class="mb-3">Calendario</h4>
      <div id='calendar'></div>
    </div>
  </div>
</body>