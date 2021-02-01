<?php
session_start();
include "../db_connect.php";

$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "UPDATE user SET is_spinning = 1 WHERE username = '$username'";
mysqli_query($conn, $sql);
CloseCon($conn);