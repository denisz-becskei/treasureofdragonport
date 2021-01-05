<?php

function is_exists($code) {
    $conn = OpenCon();

    $sql = "SELECT trade_code FROM active_trades";
    $result = $conn->query($sql);
    CloseCon($conn);

    while($row = mysqli_fetch_array($result)) {
        if ($row["trade_code"] == $code) {
            return true;
        }
    }
    return false;
}

function is_trader($name) {
    $conn = OpenCon();
    $sql = "SELECT trader FROM active_trades";
    $result = $conn->query($sql);
    CloseCon($conn);
    $result = mysqli_fetch_array($result);
    foreach ($result as $r) {
        if ($r == $name) {
            return true;
        }
    }
    return false;
}

function is_tradee($name) {
    $conn = OpenCon();
    $sql = "SELECT tradee FROM active_trades";
    $result = $conn->query($sql);
    CloseCon($conn);
    $result = mysqli_fetch_array($result);
    foreach ($result as $r) {
        if ($r == $name) {
            return true;
        }
    }
    return false;
}

function generate_code() {
    $usable_characters = ['A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J',
        'j', 'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o', 'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't', 'U',
        'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    $random_code = "&";
    $l = 0;
    while ($l != 8) {
        $l++;
        $random_index = rand(0, 35);
        $random_code = $random_code . $usable_characters[$random_index];
    }

    $conn = OpenCon();

    $sql = "SELECT trade_code FROM active_trades";
    $currently_active = $conn->query($sql);
    $currently_active = mysqli_fetch_array($currently_active);

    foreach ($currently_active as $ca) {
        if ($ca == $random_code) {
            $random_code = generate_code();
        }
    }

    $sql = "SELECT trade_code, trader FROM active_trades";
    $current_traders = $conn->query($sql);

    while ($row = mysqli_fetch_array($current_traders)) {
        if ($row["trader"] == $_SESSION["username"]) {
            CloseCon($conn);
            return false;
        }
    }

    CloseCon($conn);
    return $random_code;
}

function find_code_by_trader($trader) {
    $conn = OpenCon();

    $sql = "SELECT trade_code FROM active_trades WHERE trader = '$trader'";

    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function find_code_by_tradee($tradee) {
    $conn = OpenCon();

    $sql = "SELECT trade_code FROM active_trades WHERE tradee = '$tradee'";

    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function insert_code() {
    $conn = OpenCon();

    $generate_code = generate_code();

    $trader = $_SESSION["username"];
    if ($generate_code == false) {
        CloseCon($conn);
        return find_code_by_trader($trader);
    }
    $sql = "INSERT INTO active_trades(trade_code, trader, tradee) VALUES ('$generate_code', '$trader', null)";
    mysqli_query($conn, $sql);
    CloseCon($conn);
    return $generate_code;
}

function add_tradee($tradee, $code) {
    $conn = OpenCon();

    $sql = "SELECT trade_code FROM active_trades";
    $result = $conn->query($sql);

    $code_exists = false;

    while ($row = mysqli_fetch_array($result)) {
        if ($row["trade_code"] == $code) {
            $code_exists = true;
        }
    }

    if ($code_exists) {
        $sql = "UPDATE active_trades SET tradee = '$tradee' WHERE trade_code = '$code'";
        mysqli_query($conn, $sql);
    }

    CloseCon($conn);
}

function get_trader_name($code) {
    $conn = OpenCon();

    $sql = "SELECT trader FROM active_trades WHERE trade_code = '$code'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    if ($result != null) {
        CloseCon($conn);
        return $result;
    } else {
        return "null";
    }
}

function get_tradee_name($code) {
    $conn = OpenCon();

    $sql = "SELECT tradee FROM active_trades WHERE trade_code = '$code'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    if ($result != null) {
        CloseCon($conn);
        return $result;
    } else {
        return "null";
    }
}

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

function init_trade() {
    $conn = OpenCon();
    $tc = find_code_by_trader($_SESSION["username"]);
    $sql = "UPDATE active_trades SET started = 1 WHERE trade_code = '$tc'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
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

function set_coin($status, $index) {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    $sql = "SELECT inventory FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    $inventory = explode(",", mysqli_fetch_array($result)[0]);
    $clean_inventory = [];
    foreach ($inventory as $i) {
        if ($i == "" || $i == " " ||$i == "\t") {
            continue;
        }
        array_push($clean_inventory, $i);
    }

    if ($status == "trader") {
        $code = find_code_by_trader($_SESSION["username"]);
        $sql = "UPDATE active_trades SET trader_coin = '".strip($clean_inventory[$index])."', trader_coin_index = '$index' WHERE trade_code = '$code'";
        mysqli_query($conn, $sql);
    } else {
        $code = find_code_by_tradee($_SESSION["username"]);
        $sql = "UPDATE active_trades SET tradee_coin = '".strip($clean_inventory[$index])."', tradee_coin_index = '$index' WHERE trade_code = '$code'";
        mysqli_query($conn, $sql);
    }

    CloseCon($conn);
}

function get_trade_start_status() {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    if (is_trader($username)) {
        $code = find_code_by_trader($username);
    } elseif(is_tradee($username)) {
        $code = find_code_by_tradee($username);
    } else {
        return null;
    }

    $sql = "SELECT started FROM active_trades WHERE trade_code = '$code'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_trader_coin() {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    if (is_trader($username)) {
        $sql = "SELECT trader_coin FROM active_trades WHERE trader = '$username'";
    } else {
        $sql = "SELECT trader_coin FROM active_trades WHERE tradee = '$username'";
    }
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_tradee_coin() {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    if (is_trader($username)) {
        $sql = "SELECT tradee_coin FROM active_trades WHERE trader = '$username'";
    } else {
        $sql = "SELECT tradee_coin FROM active_trades WHERE tradee = '$username'";
    }
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
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

function swap() {
    $conn = OpenCon();
    $code = is_trader($_SESSION["username"]) ? find_code_by_trader($_SESSION["username"]) : find_code_by_tradee($_SESSION["username"]);
    $sql = "SELECT trader, tradee, trader_coin, trader_coin_index, tradee_coin, tradee_coin_index FROM active_trades WHERE trade_code = '$code'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result);

    include "inventory_selling.php";
    remove_from_inventory($result["trader"], $result["trader_coin_index"], false);
    remove_from_inventory($result["tradee"], $result["tradee_coin_index"], false);
    add_coin($result["trader"], $result["tradee_coin"]);
    add_coin($result["tradee"], $result["trader_coin"]);

    CloseCon($conn);
}

function set_ready() {
    $conn = OpenCon();
    $username = $_SESSION["username"];
    if (is_trader($username)) {
        $sql = "UPDATE active_trades SET trader_ready = 1 WHERE trader = '$username'";
    } else {
        $sql = "UPDATE active_trades SET tradee_ready = 1 WHERE tradee = '$username'";
    }
    mysqli_query($conn, $sql);
    CloseCon($conn);
}