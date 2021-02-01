<?php
session_start();
include "../db_connect.php";

$numberz = [];

for($i = 1; $i < 101; $i++) {
    array_push($numberz, $i);
}

$final = [];

$legendary_coin = "Yagorath";
$epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
$rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
$uncommon_array = ["Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "MalDamba", "Androxus", "Skye"];
$common_array = ["Jenos", "Vivian", "Buck", "Seris", "Inara", "Grohk", "Viktor", "Cassie", "Lex", "Grover", "Ash", "Ruckus", "Fernando", "Barik", "Pip", "Moji", "Willo"];

shuffle($numberz);

$legendary = $numberz[0] == 1;
$epic = $numberz[0] == 2 || $numberz[0] == 3;
$rare = $numberz[0] > 3 && $numberz[0] < 10;
$uncommon = $numberz[0] >= 10 && $numberz[0] < 26;

if ($legendary) {
    array_push($final, $legendary_coin);
} else if($epic) {
    array_push($final, $epic_array[rand(0, sizeof($epic_array))]);
} else if($rare) {
    array_push($final, $rare_array[rand(0, sizeof($rare_array))]);
} else if($uncommon) {
    array_push($final, $uncommon_array[rand(0, sizeof($uncommon_array))]);
} else {
    array_push($final, $common_array[rand(0, sizeof($common_array))]);
}

shuffle($numberz);

$legendary = $numberz[0] == 1;
$epic = $numberz[0] == 2 || $numberz[0] == 3;
$rare = $numberz[0] > 3 && $numberz[0] < 10;
$uncommon = $numberz[0] >= 10 && $numberz[0] < 26;

if ($legendary) {
    array_push($final, $legendary_coin);
} else if($epic) {
    array_push($final, $epic_array[rand(0, sizeof($epic_array)-1)]);
} else if($rare) {
    array_push($final, $rare_array[rand(0, sizeof($rare_array)-1)]);
} else if($uncommon) {
    array_push($final, $uncommon_array[rand(0, sizeof($uncommon_array)-1)]);
} else {
    array_push($final, $common_array[rand(0, sizeof($common_array)-1)]);
}

shuffle($numberz);

$legendary = $numberz[0] == 1;
$epic = $numberz[0] == 2 || $numberz[0] == 3;
$rare = $numberz[0] > 3 && $numberz[0] < 10;
$uncommon = $numberz[0] >= 10 && $numberz[0] < 26;

if ($legendary) {
    array_push($final, $legendary_coin);
} else if($epic) {
    array_push($final, $epic_array[rand(0, sizeof($epic_array)-1)]);
} else if($rare) {
    array_push($final, $rare_array[rand(0, sizeof($rare_array)-1)]);
} else if($uncommon) {
    array_push($final, $uncommon_array[rand(0, sizeof($uncommon_array)-1)]);
} else {
    array_push($final, $common_array[rand(0, sizeof($common_array)-1)]);
}

$failsafe = [];

for (;;) {
    if (array_search("", $final)) {
        for ($i = 0; $i < sizeof($final); $i++) {
            array_push($failsafe, $final[$i]);
        }
        shuffle($numberz);

        $legendary = $numberz[0] == 1;
        $epic = $numberz[0] == 2 || $numberz[0] == 3;
        $rare = $numberz[0] > 3 && $numberz[0] < 10;
        $uncommon = $numberz[0] >= 10 && $numberz[0] < 26;

        if ($legendary) {
            array_push($failsafe, $legendary_coin);
        } else if($epic) {
            array_push($failsafe, $epic_array[rand(0, sizeof($epic_array)-1)]);
        } else if($rare) {
            array_push($failsafe, $rare_array[rand(0, sizeof($rare_array)-1)]);
        } else if($uncommon) {
            array_push($failsafe, $uncommon_array[rand(0, sizeof($uncommon_array)-1)]);
        } else {
            array_push($failsafe, $common_array[rand(0, sizeof($common_array)-1)]);
        }
        unset($final);

        for ($i = 0; $i < sizeof($failsafe); $i++) {
            array_push($final, $failsafe[$i]);
        }
        continue;
    }
    break;
}

$final = implode("|", $final);

$conn = OpenCon();
$username = $_SESSION["username"];
$sql = "UPDATE user SET last_spin = '$final' WHERE username = '$username'";
mysqli_query($conn, $sql);
CloseCon($conn);
