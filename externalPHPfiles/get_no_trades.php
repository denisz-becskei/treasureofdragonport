<?php
session_start();
include "../db_connect.php";

$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "SELECT number_of_trades FROM user WHERE username = '$username'";
$result = $conn->query($sql);
CloseCon($conn);
echo intval(mysqli_fetch_array($result)[0]);