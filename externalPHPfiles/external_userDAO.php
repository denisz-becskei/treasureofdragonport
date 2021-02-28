<?php

function get_email($username) {
    $conn = OpenCon();
    $sql = "SELECT email FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_ign_external($username) {
    $conn = OpenCon();
    $sql = "SELECT ign FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_discord_name($username) {
    $conn = OpenCon();
    $sql = "SELECT discord FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_status_external($username) {
    $conn = OpenCon();
    $sql = "SELECT user_status FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_rank_external($username) {
    $conn = OpenCon();
    $sql = "SELECT max_rank FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_current_wheelturns($username) {
    $conn = OpenCon();
    $sql = "SELECT wheelturns FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_credits_external($username) {
    $conn = OpenCon();
    $sql = "SELECT credits FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_cronias_external($username) {
    $conn = OpenCon();
    $sql = "SELECT cronia FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_unique_external($username) {
    $conn = OpenCon();
    $sql = "SELECT `unique` FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_inventory_external($username): array
{
    $conn = OpenCon();

    $sql = "SELECT Androxus, Ash, Atlas, Barik, Bomb_King, Buck, Cassie, Corvus, Dredge, Drogoz, Evie, Fernando, Furia, Grohk, Grover, Imani, Inara, Io, Jenos, Khan, Kinessa, Koga, Lex, Lian, Maeve, Makoa, MalDamba, Moji, Pip, Raum, Ruckus, Seris, Sha_Lin, Skye, Strix, Talus, Terminus, Tiberius, Torvald, Tyra, Viktor, Vivian, Vora, Willo, Yagorath, Ying, Zhin FROM user_inventory WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
}