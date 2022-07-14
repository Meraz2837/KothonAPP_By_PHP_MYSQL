<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}
?>
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "upbdlike54_meraz", "K^_nUMb?voe=", "upbdlike54_chat");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$message = mysqli_real_escape_string($link, $_REQUEST['message']);
$name = $_SESSION['username'];

// Attempt insert query execution
$sql = "INSERT INTO messages (username, message) VALUES ('$name', '$message')";
if (mysqli_query($link, $sql)) {
    header('location:../chat');
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
