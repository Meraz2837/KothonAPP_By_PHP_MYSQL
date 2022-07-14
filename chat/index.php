<?php
// Initialize the session
session_start();
$server = 'localhost';
$username = '';
$password = '';
$db_name = '';
$connect = mysqli_connect($server, $username, $password, $db_name);

$session_name = $_SESSION['username'];
$query = mysqli_query($connect, "UPDATE active_status SET status = 'Active now' WHERE id = (SELECT active_status.id FROM active_status, users WHERE (users.username = '$session_name' and users.id = active_status.id))");
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $server = 'localhost';
    $username = 'upbdlike54_meraz';
    $password = 'K^_nUMb?voe=';
    $db_name = 'upbdlike54_chat';
    $connect = mysqli_connect($server, $username, $password, $db_name);

    $session_name = $_SESSION['username'];
    $query = mysqli_query($connect, "UPDATE active_status SET status = 'Not Active' WHERE id = (SELECT active_status.id FROM active_status, users WHERE (users.username = '$session_name' and users.id = active_status.id))");
    header("location: ../login.php");
    exit;
}
?>
<?php
$server = 'localhost';
$username = 'upbdlike54_meraz';
$password = 'K^_nUMb?voe=';
$db_name = 'upbdlike54_chat';
$connect = mysqli_connect($server, $username, $password, $db_name);
$session_user = $_SESSION['username'];
$user = mysqli_query($connect, "SELECT username FROM users WHERE username <> '$session_user'");

$singleuser = mysqli_fetch_assoc($user);
$single_user_extract = $singleuser['username'];


$active_status_obj = mysqli_query($connect, "SELECT status FROM active_status WHERE id = (SELECT active_status.id FROM active_status, users WHERE (users.username = '$single_user_extract' and users.id = active_status.id))");
echo ("Error description: " . mysqli_error($connect));
$active_status = mysqli_fetch_assoc($active_status_obj);

if ($active_status['status'] === 'Active now') {
    $status_color = 'text-success';
} else {
    $status_color = 'text-danger';
}

?>
<div class="bg-dark text-light p-2 position-fixed" style="display: flex; align-items: center; width: 100%; top:0;">

    <img class="img-fluid" style="width: 50px; height: 50px; margin-left: 10px;" src="../user.png" alt="user">
    <span style="font-size: 25px; font-weight:bolder;" class="px-3"><?php echo $single_user_extract; ?></span>

    <span class="<?php echo $status_color; ?>"><?php echo $active_status['status']; ?></span>
</div>
<div style="height:60px"></div>
<?php


$messages = mysqli_query($connect, "SELECT * FROM messages");

while ($message = mysqli_fetch_array($messages)) {
    if ($message['username'] === $_SESSION['username']) {
        $align = "right";
        $bgcolor = "bg-dark";
    } else {
        $align = "left";
        $bgcolor = "bg-success";
    }

?>
    <div id="bottom" class="p-2 m-3 text-light">
        <p style="margin-bottom: -5px; margin-top: -5px;text-align:<?php echo $align; ?>;"><span style="border-radius: 20px; padding: 3px 0" class="px-3 <?php echo $bgcolor ?>"><?php echo $message['message'] ?></span> </p>
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

            <div class="dropdown">
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item text-danger" href="delete.php?id=<?php echo $message['id']; ?>">Delete</a></li>
        </ul>
    </div>

    </div>
<?php
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>কthon</title>
    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url("background.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <form style="z-index: 99;" class="position-sticky" action="sent.php" method="POST">
        <div class="m-3" style="display: flex;">
            <input oninput="typing()" required class="form-control" type="text" placeholder="Your message" name="message">
            <input type="submit" class="btn btn-danger" style="margin-left: 5px; margin-right: 2px" value="Send">
        </div>
    </form>

    <div class="bg-dark text-danger text-center">
        <a class="text-danger" href="../logout.php">logout</a>
        <a class="text-success" href="../chat">reload page</a>
    </div>
    <script>
        document.getElementById('bottom').scrollIntoView();
        window.scrollTo(0, document.body.scrollHeight);
        var typingfield = document.getElementById('typingstatus');

        function typing() {
            typingfield.innerHTML = 'typing...';
        }
    </script>
</body>

</html>