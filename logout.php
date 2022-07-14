<?php
// Initialize the session
session_start();

$server = 'localhost';
    $username = 'upbdlike54_meraz';
    $password = 'K^_nUMb?voe=';
    $db_name = 'upbdlike54_chat';
    $connect = mysqli_connect($server, $username, $password, $db_name);
    
    $session_name = $_SESSION['username'];
    $query = mysqli_query($connect, "UPDATE active_status SET status = 'Not Active' WHERE id = (SELECT active_status.id FROM active_status, users WHERE (users.username = '$session_name' and users.id = active_status.id))");
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();


 
// Redirect to login page
header("location: login.php");
exit;
