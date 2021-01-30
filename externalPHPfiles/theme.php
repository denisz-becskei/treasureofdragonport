<?php
session_start();
include "../db_connect.php";
$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "SELECT dark_mode FROM user WHERE username='$username'";
$result = $conn->query($sql);
$result = mysqli_fetch_array($result)[0];
$result = intval($result);

if ($result == 1) {
    $new_status = 0;
} else {
    $new_status = 1;
}

$sql = "UPDATE user SET dark_mode = '$new_status' WHERE username = '$username'";
mysqli_query($conn, $sql);
CloseCon($conn);