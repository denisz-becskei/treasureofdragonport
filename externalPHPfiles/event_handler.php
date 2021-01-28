<?php

function is_open($event_name) {
    $conn = OpenCon();
    $sql = "SELECT open FROM events WHERE name='$event_name'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];

    CloseCon($conn);

    if ($result == 0) {
        return false;
    } else {
        return true;
    }
}

function is_signed_up($event_num, $player) {
    $conn = OpenCon();
    switch ($event_num) {
        case 1:
            $sql = "SELECT player FROM event1_players";
            break;
        case 2:
            $sql = "SELECT player FROM event2_players";
            break;
    }
    $result = $conn->query($sql);
    CloseCon($conn);
    while ($row = mysqli_fetch_array($result)) {
        if($row["player"] == $player) {
            return true;
        }
    }
    return false;
}

function signup($event_num) {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    switch ($event_num) {
        case 1:
            $sql = "INSERT INTO event1_players(player) VALUES ('$username')";
            break;
        case 2:
            $sql = "INSERT INTO event2_players(player) VALUES ('$username')";
            break;
    }
    mysqli_query($conn ,$sql);
    CloseCon($conn);
}

function signoff($event_num) {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    switch ($event_num) {
        case 1:
            $sql = "DELETE FROM event1_players WHERE '$username'";
        case 2:
            $sql = "DELETE FROM event2_players WHERE '$username'";
    }
    mysqli_query($conn ,$sql);
    CloseCon($conn);
}