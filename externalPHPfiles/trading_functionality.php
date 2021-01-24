<?php

include "inventory_selling.php";
include "championDAO.php";

function get_tradee_avatar($tradee) {
    if ($tradee == "null") {
        return 1337;
    }
    $conn = OpenCon();

    $sql = "SELECT avatar FROM user WHERE username = '$tradee'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_trader_avatar($trader) {
    $conn = OpenCon();

    $sql = "SELECT avatar FROM user WHERE username = '$trader'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    if ($result != null) {
        CloseCon($conn);
        return $result;
    } else {
        return "null";
    }
}


function strip($string) {
    $new_string = [];
    for ($i = 0; $i < strlen($string); $i++) {
        if (($string[$i] > '@' && $string[$i] < '[') || ($string[$i] > '`' && $string[$i] < '{')) {
            array_push($new_string, $string[$i]);
        }
    }
    return implode($new_string);
}


function add_coin($user, $champion) {
    $conn = OpenCon();
    $sql = "SELECT inventory FROM user WHERE username = '$user'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    $result = $result . $champion . ", ";
    $sql = "UPDATE user SET inventory = '$result' WHERE username = '$user'";
    mysqli_query($conn, $sql);

    $sql = "SELECT inventory FROM user WHERE username = '$user'";

    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    $result = str_replace(", ", ",", $result);
    $champions = explode(",", $result);
    $unique_arr = array_unique_own($champions);
    $unique = count($unique_arr);

    $sql = "UPDATE user SET `unique` = '$unique' WHERE username = '$user'";
    mysqli_query($conn, $sql);

    CloseCon($conn);
}

function add_trade($coin, $coin_in_return, $owned_by) {
    $rarity = get_rarity_by_champion($coin);
    if ($rarity == "&ltLegendás&gt") {
        $cronia_value1 = 5;
    } elseif ($rarity == "&ltEpikus&gt") {
        $cronia_value1 = 4;
    } elseif ($rarity == "&ltRitka&gt") {
        $cronia_value1 = 3;
    } elseif ($rarity == "&ltEgyedi&gt") {
        $cronia_value1 = 2;
    } else {
        $cronia_value1 = 1;
    }

    $rarity = get_rarity_by_champion($coin_in_return);

    if ($rarity == "&ltLegendás&gt") {
        $cronia_value2 = 5;
    } elseif ($rarity == "&ltEpikus&gt") {
        $cronia_value2 = 4;
    } elseif ($rarity == "&ltRitka&gt") {
        $cronia_value2 = 3;
    } elseif ($rarity == "&ltEgyedi&gt") {
        $cronia_value2 = 2;
    } else {
        $cronia_value2 = 1;
    }

    $cronia_value = ceil(sqrt($cronia_value1 + $cronia_value2));

    $date = date("Y/m/d H:i:s");

    $conn = OpenCon();
    $sql = "INSERT INTO trades(coin, coin_in_return, owned_by, cronia_got, posted_on) VALUES ('$coin', '$coin_in_return', '$owned_by', '$cronia_value', '$date')";
    mysqli_query($conn, $sql);

    CloseCon($conn);
}

function get_trade_count() {
    $conn = OpenCon();
    $sql = "SELECT COUNT(trade_code) FROM trades";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}