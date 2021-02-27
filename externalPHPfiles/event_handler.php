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

function change_event_status($event_name) {
    $conn = OpenCon();
    if (is_open($event_name)) {
        $sql = "UPDATE events SET open = 0 WHERE name = '$event_name'";
    } else {
        $sql = "UPDATE events SET open = 1 WHERE name = '$event_name'";
    }
    mysqli_query($conn, $sql);
    CloseCon($conn);
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

function delete_players($event_num) {
    $conn = OpenCon();
    switch ($event_num) {
        case 1:
            $sql = "DELETE FROM event1_players";
            break;
        case 2:
            $sql = "DELETE FROM event2_players";
            break;
    }
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function signup($event_num) {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    $ign = get_ign();
    switch ($event_num) {
        case 1:
            $sql = "INSERT INTO event1_players(player, ign) VALUES ('$username', '$ign')";
            break;
        case 2:
            $sql = "INSERT INTO event2_players(player, ign) VALUES ('$username', '$ign')";
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
            $sql = "DELETE FROM event1_players WHERE player = '$username'";
            break;
        case 2:
            $sql = "DELETE FROM event2_players WHERE player = '$username'";
            break;
    }
    mysqli_query($conn ,$sql);
    CloseCon($conn);
}

function get_event_players($event_name) {
    $conn = OpenCon();
    if ($event_name == "Mix League") {
        $sql = "SELECT player FROM event1_players";
        $players_1 = $conn->query($sql);
        $players = mysqli_fetch_array($players_1);
        $sql = "SELECT ign FROM event1_players";
        $ign = $conn->query($sql);
        $ign = mysqli_fetch_array($ign);
    } else {
        $sql = "SELECT player FROM event2_players";
        $players_1 = $conn->query($sql);
        $players = mysqli_fetch_array($players_1);
        $sql = "SELECT ign FROM event2_players";
        $ign = $conn->query($sql);
        $ign = mysqli_fetch_array($ign);
    }

    $output = [];

    for ($i = 0; $i < mysqli_num_rows($players_1); $i++) {
        $temp = $players[$i] . "    :       ". $ign[$i];
        array_push($output, $temp);
    }

    return $output;
}