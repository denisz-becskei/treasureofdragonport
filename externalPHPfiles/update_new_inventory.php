<?php

function maxed($username) {
    $conn = OpenCon();
    $datetime = date("Y/m/d H:i:s");
    $sql = "INSERT INTO maxed(username, time) VALUES ('$username', '$datetime')";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function update_unique($username) {
    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];
    $inventory = get_inventory_2($username);

    $uni = 0;

    for ($i = 0; $i < 47; $i++) {
        if (intval($inventory[$champions[$i]]) != 0) {
            $uni++;
        }
    }

    $conn = OpenCon();
    $sql = "UPDATE user SET `unique` = '$uni' WHERE username='$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);

    if ($uni == 47) {
        maxed($username);
    }
}

function add_champion($username, $champion)
{
    $conn = OpenCon();
    $sql = "SELECT $champion FROM user_inventory WHERE username = '$username'";
    $champion_amount = $conn->query($sql);
    $champion_amount = mysqli_fetch_array($champion_amount)[0];
    $champion_amount = intval($champion_amount);
    $champion_amount++;
    $sql = "UPDATE user_inventory SET $champion = '$champion_amount' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
    update_unique($username);
}

function remove_champion($username, $champion) {
    $conn = OpenCon();
    $sql = "SELECT $champion FROM user_inventory WHERE username = '$username'";
    $champion_amount = $conn->query($sql);
    $champion_amount = mysqli_fetch_array($champion_amount)[0];
    $champion_amount = intval($champion_amount);
    $champion_amount--;
    if ($champion_amount < 0) {
        $champion_amount = 0;
    }
    $sql = "UPDATE user_inventory SET $champion = '$champion_amount' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
    update_unique($username);
}