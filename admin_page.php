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
    <title>Página de Administrador</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3>Bienvenido, Administrador</h3>
                <!-- Contenido de la página de administrador -->
            </div>
        </div>
    </div>
</body>
<script>
window.addEventListener('beforeunload', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'logout.php', false);
    xhr.send();
});
</script>	
</html>
