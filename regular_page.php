<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_id']) ) {
    header('Location: login_handler.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Usuario Regular</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3>Bienvenido, Usuario Regular</h3>
                <!-- Contenido de la página de usuario regular -->
            </div>
        </div>
    </div>
</body>
</html>
