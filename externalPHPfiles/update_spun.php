<?php
session_start();
include "../db_connect.php";
include "add_champion_to_db.php";
include "achievement_handler.php";

$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "SELECT last_spin FROM user WHERE username = '$username'";
$result = $conn->query($sql);
CloseCon($conn);

$spun = explode("|", mysqli_fetch_array($result)[0]);
foreach ($spun as $s) {
    add_champion($username, $s);
}

if (get_achievement_status(1) == false) {
    complete_achievement($username, 1);
}
