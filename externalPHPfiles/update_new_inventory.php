<?php

function update_unique($username) {
    $inventory = get_inventory_2($username);
    $uni = 0;

    foreach ($inventory as $i) {
        if ($i != 0) {
            $uni++;
        }
    }

    $uni--;
    $conn = OpenCon();
    $sql = "UPDATE user SET `unique` = '$uni' WHERE username='$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function update_wheelspin()
{
    $spun_champions = $_COOKIE["spun-champions"];
    $separated_champions = explode(",", $spun_champions);
    $inventory = get_inventory();

    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

    for ($j = 0; $j < 3; $j++) {
        for ($i = 0; $i < 47; $i++) {
            if ($champions[$i] == trim($separated_champions[$j])) {
                $index = $i;
                break;
            }
        }
        $inventory[$index] += 1;
    }

    $new_inv = "";

    foreach ($inventory as $inv) {
        $new_inv .= $inv . "|";
    }
    $new_inv = substr($new_inv, 0, -1);
    $conn = OpenCon();
    $username = $_SESSION["username"];
    $sql = "UPDATE user SET inventory = '$new_inv' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);

    update_unique($_SESSION["username"]);
    header("Location: wheel.php");
}

function add_champion($username, $champion)
{

    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];
    $inventory = get_inventory_2($username);
    for ($i = 0; $i < 47; $i++) {
        if ($champions[$i] == $champion) {
            $index = $i;
            break;
        }
    }
    $inventory[$index] += 1;

    $new_inv = "";

    foreach ($inventory as $inv) {
        $new_inv .= $inv . "|";
    }
    $new_inv = substr($new_inv, 0, -1);
    $conn = OpenCon();
    $sql = "UPDATE user SET inventory = '$new_inv' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);

}

function remove_champion($username, $champion) {
    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];
    $inventory = get_inventory_2($username);
    for ($i = 0; $i < 47; $i++) {
        if ($champions[$i] == $champion) {
            $index = $i;
            break;
        }
    }
    $inventory[$index] -= 1;

    $new_inv = "";

    foreach ($inventory as $inv) {
        $new_inv .= $inv . "|";
    }
    $new_inv = substr($new_inv, 0, -1);
    $conn = OpenCon();
    $sql = "UPDATE user SET inventory = '$new_inv' WHERE username = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}