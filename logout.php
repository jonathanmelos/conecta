<?php session_start(); 
function logout()
{
    session_unset();
    session_destroy();
}
logout(); 
header('Location: index.php'); 
?>