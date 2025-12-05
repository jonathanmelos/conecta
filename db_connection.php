<?php
function db_connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "conectac_sistema";
 

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $conn;
}


?>

