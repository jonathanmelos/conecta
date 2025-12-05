<?php include 'db_connection.php';

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

?>

