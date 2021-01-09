<?php

function get_dm_status() {
    $conn = OpenCon();

    $username = $_SESSION["username"];
    $sql = "SELECT dark_mode FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}