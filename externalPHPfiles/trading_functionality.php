<?php

include "inventory_selling.php";
include "championDAO.php";

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

function add_trade($coin, $coin_index, $coin_in_return, $owned_by) {
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
    $sql = "INSERT INTO trades(coin, coin_index, coin_in_return, owned_by, cronia_got, posted_on) VALUES ('$coin', '$coin_index' , '$coin_in_return', '$owned_by', '$cronia_value', '$date')";
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

function get_coins_by_id($id) {
    $conn = OpenCon();
    $sql = "SELECT coin, coin_in_return, owned_by, coin_index FROM trades WHERE trade_code = '$id'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result);
}

function get_coins_by_owner($owner) {
    $conn = OpenCon();
    $sql = "SELECT trade_code, coin, coin_in_return, coin_index FROM trades WHERE owned_by = '$owner'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result);
}

function remove_trade($id) {
    $conn = OpenCon();
    $sql = "DELETE FROM trades WHERE trade_code = '$id'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function add_cronias($tradee, $owned, $id) {
    $conn = OpenCon();
    $sql = "SELECT cronia_got, owned_by FROM trades WHERE trade_code = '$id'";
    $result = $conn->query($sql);

    $cronias_to_add = mysqli_fetch_array($result)["cronia_got"];

    $sql = "SELECT cronia FROM user WHERE username = '$owned'";
    $result2 = $conn->query($sql);
    $current_cronia = intval(mysqli_fetch_array($result2)[0]);
    $current_cronia += $cronias_to_add;
    $sql = "UPDATE user SET cronia = '$current_cronia' WHERE username = '$owned'";
    mysqli_query($conn, $sql);

    $sql = "SELECT cronia FROM user WHERE username = '$tradee'";
    $result3 = $conn->query($sql);
    $current_cronia = intval(mysqli_fetch_array($result3)[0]);
    $current_cronia += $cronias_to_add;
    $sql = "UPDATE user SET cronia = '$current_cronia' WHERE username = '$tradee'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}