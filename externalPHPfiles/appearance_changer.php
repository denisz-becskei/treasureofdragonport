<?php
session_start();
include "../db_connect.php";
include "userDAO.php";
include "achievement_handler.php";
$avatar = $_POST["avatars"];
echo $avatar;

$username = $_SESSION["username"];
$conn = OpenCon();
$avatar = set_avatar($avatar);

$sql = "UPDATE user SET avatar = '$avatar' WHERE username = '$username'";
mysqli_query($conn, $sql);

if ($avatar == 6) {
    complete_achievement($username, 15);
}

CloseCon($conn);