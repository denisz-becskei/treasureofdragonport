<?php

function insert_feedback($feedback) {
    $conn = OpenCon();
    $datetime = date("Y/m/d H:i:s");
    $username = $_SESSION["username"];
    $sql = "INSERT INTO feedback(username, feedback, time) VALUES ('$username', '$feedback', '$datetime')";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}