<?php
session_start();
include "../db_connect.php";
include "achievement_handler.php";

function strip($string) {
    $new_string = [];
    for ($i = 0; $i < strlen($string); $i++) {
        if (($string[$i] > '@' && $string[$i] < '[') || ($string[$i] > '`' && $string[$i] < '{')) {
            array_push($new_string, $string[$i]);
        }
    }
    return implode($new_string);
}
function array_unique_own($array) {
    $new_array = [];
    foreach ($array as $ar) {
        if (!array_search($ar, $new_array)) {
            if ($ar != "") {
                array_push($new_array, $ar);
            }
        }
    }
    return $new_array;
}

$string_to_add = $_COOKIE["spun-champions"];

$conn = OpenCon();

$username = $_SESSION["username"];

$sql = "SELECT inventory FROM user WHERE username = '$username'";

$string_to_add = str_replace(", ", ",", $string_to_add);
$result = $conn->query($sql);
$result =  mysqli_fetch_array($result)[0];
$replacement = $result . $string_to_add;

$exploded = explode(",", $string_to_add);
for ($i = 0; $i < count($exploded); $i++) {
    if (ltrim(rtrim($exploded[$i])) == "Yagorath") {
        complete_achievement($username, 11);
        break;
    }
}


$sql = "UPDATE user SET inventory = '$replacement' WHERE username = '$username'";
mysqli_query($conn, $sql);

$sql = "SELECT inventory FROM user WHERE username = '$username'";

$result = $conn->query($sql);
$result = mysqli_fetch_array($result)[0];
$result = str_replace(", ", ",", $result);
$champions = explode(",", $result);
$unique_arr = array_unique_own($champions);
$unique = count($unique_arr);

$sql = "UPDATE user SET `unique` = '$unique' WHERE username = '$username'";
mysqli_query($conn, $sql);

$sql = "SELECT `unique` FROM user WHERE username='$username'";
$result = $conn->query($sql);
$result = mysqli_fetch_array($result)[0];;
if (strval($result) == 47) {
    complete_achievement($username, 10);
} elseif (strval($result) >= 40) {
    complete_achievement($username, 9);
} elseif (strval($result) >= 30) {
    complete_achievement($username,8);
} elseif (strval($result) >= 20) {
    complete_achievement($username,7);
} elseif (strval($result) >= 10) {
    complete_achievement($username,6);
}

CloseCon($conn);

header("Location: ../wheel_result.php");