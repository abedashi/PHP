<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "project";

    try {
        $conn = mysqli_connect($servername, $username, $password, $db);
    } catch (Exception $e) {
        die("Connection Failed ".$e->getMessage());
    }
?>