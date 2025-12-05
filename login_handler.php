<?php
session_start();
include 'db_connection.php';
//include 'functions.php';
date_default_timezone_set('America/Guayaquil');
$hoy = date('Y-m-d');
function login($username, $password)
{
    $conn = db_connect();
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['admin'] = $row['user_type'];
        return true;
    } else {
        return false;
    }
}
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
    if ($_SESSION['admin'] == "admin") {
        $fecha = urlencode($hoy); // Codifica la variable $hoy para que pueda ser utilizada en una URL
        echo "<script>window.location.href = 'diario.php?fecha=$fecha';</script>";
    } else {
        echo "<script>window.location.href = 'registro.php';</script>";
    }
    exit();
} else {
    $error_message = "Usuario o contraseña incorrectos";
}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Inicio de Sesión</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h3 class="mb-4">Iniciar Sesión</h3>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="POST" action="login_handler.php">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

