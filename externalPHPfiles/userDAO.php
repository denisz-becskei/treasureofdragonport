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
        case "Death Speaker":
            return 1;
        case "Cutesy Zhin":
            return 2;
        case "Ember":
            return 3;
        case "Lily-hopper":
            return 4;
        case "Spirit":
            return 5;
        case "I WUV YOU";
            return 6;
        case "Beauty in Conflict":
            return 7;
        default:
            return 0;
    }
}

function get_avatar() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT avatar FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);
    return mysqli_fetch_array($result)[0];
}

function get_unique() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "SELECT `unique` FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    CloseCon($conn);;
    return mysqli_fetch_array($result)[0];
}

function get_amount($champion) {
    $inventory = get_inventory();
    return $inventory[get_index($champion)];
}