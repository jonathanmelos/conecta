<?php
include 'conexion.php';
include 'header.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$fecha = $_POST['fecha'];
$id = $_POST['id'];
$sec_lead = $_POST['sec_lead'];
$sql = "UPDATE calendario SET estado = 'C' WHERE id_cal = $id";
$result = mysqli_query($conn,$sql); 
$sql2 = "UPDATE leads SET nivel = nivel + 15 WHERE sec_lead = '$sec_lead' ";
$result2 = mysqli_query($conn,$sql2); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $motivo = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
	    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurar el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'tuoficial.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'j.melo@tuoficial.com';
        $mail->Password = 'Keykey2022$2';
        $mail->SMTPSecure = 'ssl'; // Opcional, si el servidor SMTP requiere SSL

        // Configurar el correo electrónico
        $mail->setFrom('j.melo@tuoficial.com', 'Jonathan');
        $mail->addAddress($email);
        $mail->Subject = $motivo;
        $mail->msgHTML($mensaje);

        // Enviar el correo electrónico
        $mail->send();
        $enviado = 'Correo enviado exitosamente!';
    } catch (Exception $e) {
        $enviado = 'Error al enviar el correo: ' . $mail->ErrorInfo;
    }
}


?>
<div class="container">
	  <h1><?php echo $enviado ?></h1>
</div>	
<script>
    // Esperar 5 segundos y redireccionar
    setTimeout(function() {
        window.location.href = 'detalle_evento.php?fecha=<?php echo $fecha ?>';
    }, 2000); // 5000 milisegundos = 5 segundos
</script>