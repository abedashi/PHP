<?php
    session_start();

    unset($_SESSION["id"]);
    unset($_SESSION["name"]);
    unset($_SESSION['username']);
    unset($_SESSION['state']);
    unset($_SESSION['image']);

    header("Location:login.php");
    mysqli_close($con);
?>
