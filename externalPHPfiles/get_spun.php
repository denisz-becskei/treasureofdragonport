<?php
session_start();
include "../db_connect.php";

$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "SELECT last_spin FROM user WHERE username = '$username'";
$result = $conn->query($sql);
CloseCon($conn);

echo mysqli_fetch_array($result)[0];
