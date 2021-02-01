<?php

function get_index($champion) {
    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

    for ($i = 0; $i < 47; $i++) {
        if ($champions[$i] == $champion) {
            return $i;
        }
    }
    return null;
}

function get_felhasznalonev() {

    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT username FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_ign() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT ign FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_wheelturns() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT wheelturns FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function set_wheelturns($newValue) {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT wheelturns FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    if (mysqli_fetch_array($result)[0] > 0) {
        $sql = "UPDATE user SET wheelturns = '$newValue' WHERE username = '$username'";
        if (mysqli_query($conn, $sql)) {
            print "Gutchi";
        }
    }
    CloseCon($conn);
}

function get_inventory() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT inventory FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    CloseCon($conn);

    $inventory_assembled = mysqli_fetch_array($result)[0];
    return explode("|", $inventory_assembled);
}

function get_inventory_2($username) {
    $conn = OpenCon();

    $sql = "SELECT inventory FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    CloseCon($conn);

    $inventory_assembled = mysqli_fetch_array($result)[0];
    return explode("|", $inventory_assembled);
}

function get_credits() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT credits FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_coronia() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT cronia FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_password() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT pass FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_status() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT user_status FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_rank() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT max_rank FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function set_avatar($avatar) {
    switch ($avatar) {
        case "Halálsuttogó":
            return 1;
        case "Cuki Zhin":
            return 2;
        case "Parázs":
            return 3;
        case "Tündérrózsa-ugráló":
            return 4;
        case "Szellemes":
            return 5;
        case "SZEJETLEK";
            return 6;
        case "Gyönyör a Konfliktusban":
            return 7;
        case "Szia Uram!":
            return 8;
        case "VHS":
            return 9;
        case "gYiLkOsSáG":
            return 10;
        case "Nincs Pánikra Ok":
            return 11;
        case "Fa a Sötét Oldalról":
            return 12;
        default:
            return 0;
    }
}

function get_avatar($username) {
    $conn = OpenCon();

    $sql = "SELECT avatar FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return intval(mysqli_fetch_array($result)[0]);
}

function get_avatar_link($username) {
    $avatars_coded = [
            0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png",
            1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png",
            2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png",
            3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png",
            4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png",
            5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png",
            6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png",
            7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png",
            8 => "https://i.imgur.com/qZTyYkQ.png",
            9 => "https://i.imgur.com/WqGXMXo.jpg",
            10 => "https://i.imgur.com/nuEFy62.png",
            11 => "https://i.imgur.com/3AjDPRz.png",
            12 => "https://i.imgur.com/aR4UnkH.png"
        ];
    return $avatars_coded[get_avatar($username)];
}

function get_unique() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT `unique` FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_amount($champion) {
    $inventory = get_inventory();
    return $inventory[get_index($champion)];
}