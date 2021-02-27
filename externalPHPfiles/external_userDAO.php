<?php

function get_email($username) {
    $conn = OpenCon();
    $sql = "SELECT email FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_ign($username) {
    $conn = OpenCon();
    $sql = "SELECT ign FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_status($username) {
    $conn = OpenCon();
    $sql = "SELECT user_status FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_rank($username) {
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

function get_credits($username) {
    $conn = OpenCon();
    $sql = "SELECT credits FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_cronias($username) {
    $conn = OpenCon();
    $sql = "SELECT cronia FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_unique($username) {
    $conn = OpenCon();
    $sql = "SELECT `unique` FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result)[0];
}

function get_inventory($username): array
{
    $conn = OpenCon();

    $sql = "SELECT Androxus, Ash, Atlas, Barik, Bomb_King, Buck, Cassie, Corvus, Dredge, Drogoz, Evie, Fernando, Furia, Grohk, Grover, Imani, Inara, Io, Jenos, Khan, Kinessa, Koga, Lex, Lian, Maeve, Makoa, MalDamba, Moji, Pip, Raum, Ruckus, Seris, Sha_Lin, Skye, Strix, Talus, Terminus, Tiberius, Torvald, Tyra, Viktor, Vivian, Vora, Willo, Yagorath, Ying, Zhin FROM user_inventory WHERE username = '$username'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
}