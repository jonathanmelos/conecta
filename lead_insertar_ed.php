<?php
include 'conexion.php';
$sec_lead = $_POST['sec_lead'];
$nombre = $_POST['nombre'];
$estado = $_POST['estado'];
$edad = $_POST['edad'];
$sexo = $_POST['sexo'];
$ingresos = $_POST['ingresos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$emprendedor = $_POST['emprendedor'];
$tam_emp = $_POST['tam_emp'];
$area_negocio = $_POST['area_negocio'];
$medio = $_POST['medio'];
$fecha = $_POST['fecha'];
$intereses = $_POST['intereses'];
$campana = $_POST['campana'];
$tema = $_POST['tema'];
$necesidad = $_POST['necesidad'];
$observaciones = $_POST['observaciones'];
$sql = "UPDATE leads SET
            nombre = '$nombre',
            correo = '$correo',
            direccion = '$direccion',
            telefono = '$telefono',
            fecha = '$fecha',
            estado = '$estado',
            campana = '$campana',
            tema = '$tema',
            medio = '$medio',
            edad = '$edad',
            sexo = '$sexo',
            ingresos = '$ingresos',
            intereses = '$intereses',
            emprendedor = '$emprendedor',
            empresa_tamano = '$tam_emp',
            area_negocio = '$area_negocio',
            necesidad = '$necesidad',
            observaciones = '$observaciones'
        WHERE sec_lead = '$sec_lead'";

mysqli_query($conn, $sql);

mysqli_close($conn);

header('Location: embudo.php');


?>