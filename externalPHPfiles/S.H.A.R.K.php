<?php

function initiate_violation($username, $violation) {
    $conn = OpenCon();
    $datetime = date("Y/m/d H:i:s");
    $sql = "INSERT INTO shark(username, time_of_violation, cause) VALUES ('$username', '$datetime', '$violation')";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function get_violations() {
    $conn = OpenCon();
    $sql = "SELECT * FROM shark";
    $result = $conn->query($sql);
    CloseCon($conn);
    return $result;
}