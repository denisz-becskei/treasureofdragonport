<?php

function get_trade_rarity_by_champion($champion): string
{
    $legendary_array = ["Yagorath"];
    $epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
    $rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
    $uncommon_array = ["Lian", "Tyra", "Bomb_King", "Sha_Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "MalDamba", "Androxus", "Skye"];

    $right_trimmed_champion = rtrim($champion);
    $champion = ltrim($right_trimmed_champion);

    if (in_array($champion, $legendary_array)) {
        return "L";
    } elseif (in_array($champion, $epic_array)) {
        return "E";
    } elseif (in_array($champion, $rare_array)) {
        return "R";
    } elseif (in_array($champion, $uncommon_array)) {
        return "E2";
    } else {
        return "G";
    }
}

function get_trade_price($to_give, $to_receive) {
    $rarity1 = get_trade_rarity_by_champion($to_give);
    $rarity2 = get_trade_rarity_by_champion($to_receive);
    $price1 = 0;
    $price2 = 0;
    if ($rarity1 == "L") {
        $price1 = 5;
    } else if ($rarity1 == "E") {
        $price1 = 4;
    } else if ($rarity1 == "R") {
        $price1 = 3;
    } else if ($rarity1 == "E2") {
        $price1 = 2;
    } else {
        $price1 = 1;
    }

    if ($rarity2 == "L") {
        $price2 = 5;
    } else if ($rarity2 == "E") {
        $price2 = 4;
    } else if ($rarity2 == "R") {
        $price2 = 3;
    } else if ($rarity2 == "E2") {
        $price2 = 2;
    } else {
        $price2 = 1;
    }

    return ceil(($price1 + $price2) / 2);
}

function increase_trades($username) {
    $conn = OpenCon();

    $sql = "SELECT number_of_trades FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    $trades = intval($result) + 1;
    $sql = "UPDATE user SET number_of_trades = '$trades' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function decrease_trades($username) {
    $conn = OpenCon();

    $sql = "SELECT number_of_trades FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    $trades = intval($result) - 1;
    $sql = "UPDATE user SET number_of_trades = '$trades' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function trade_init($username, $to_give, $to_receive) {
    $conn = OpenCon();
    $price = get_trade_price($to_give, $to_receive);
    $date = date("Y/m/d H:i:s");
    $sql = "INSERT INTO trades(coin, coin_in_return, owned_by, cronia_got, posted_on) VALUES ('$to_give', '$to_receive', '$username', '$price', '$date')";
    mysqli_query($conn, $sql);
    CloseCon($conn);
    increase_trades($username);
}