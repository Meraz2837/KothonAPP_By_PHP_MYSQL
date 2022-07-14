<?php

include "../config.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string

    $edit = mysqli_query($link, "UPDATE messages SET message='This message is deleted' WHERE id='$id'");

    if ($edit) {
        mysqli_close($link); // Close connection
        header("location:index.php"); // redirects to all records page
        exit;
    } else {
        echo mysqli_error($link);
    }

?>
