<?php
session_start();
include "db_connect.php";
include "externalPHPfiles/external_userDAO.php";
if (get_status_external($_SESSION["username"]) == 0) {
    header("Location: index.php");
}

function get_user_data() {
    $user = $_GET["user"];
    echo "Username: " . $user . "<br>";
    $email = get_email($user);
    echo "E-mail: " . $email . "<br>";
    $ign = get_ign_external($user);
    echo "IGN: " . $ign . "<br>";
    $max_ranked = get_rank_external($user);
    echo "Max Rank: " . $max_ranked . "<hr>";
    $wheelturns = get_current_wheelturns($user);
    echo "Wheelturns: " . $wheelturns . "<br>";
    $credits = get_credits_external($user);
    echo "Credits: " . $credits . "<br>";
    $cronias = get_cronias_external($user);
    echo "Cronias: " . $cronias . "<br>";
    $uniques = get_unique_external($user);
    echo "Number of Uniques: " . $uniques . "<br>";

    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

    $inventory = get_inventory_external($user);
    echo "<br>Inventory: <br>";
    for ($i = 0; $i < 47; $i++) {
       echo $champions[$i] . ": " . $inventory[$champions[$i]] . "<br>";
    }
}

include "externalPHPfiles/event_handler.php";

function get_event_data() {
    $event_name = $_GET["event_name"];
    echo "Event Name: " . $event_name . "<br>";
    if (is_open($event_name)) {
        echo "Event Status: Open <hr>";
    } else {
        echo "Event Status: Closed <hr>";
    }

    $players = get_event_players($event_name);
    echo "Players: <br><br>";
    foreach ($players as $p) {
        echo $p . "<br>";
    }

}

include "externalPHPfiles/S.H.A.R.K.php";

function get_warns() {
    $violations = get_violations();

    echo "<h2>S.H.A.R.K.</h2><br>";

    while ($row = mysqli_fetch_array($violations)) {
        echo $row["username"] . " " . $row["time_of_violation"] . " " . $row["cause"] . "<br>";
    }
}

function generate_teams() {
    $players = get_event_players("Mix League");
    shuffle($players);
    echo "Players: <br><br>";
    $i = 0;
    $team = 0;
    foreach ($players as $p) {
        if ($i % 5 == 0) {
            $team++;
            echo "Team " . $team . "<br>";
            echo $p . "<br>";
        } else {
            echo $p . "<br>";
        }
        $i++;
    }
}

if ($_GET["mode"] == "user") {
    get_user_data();
} else if ($_GET["mode"] == "event") {
    get_event_data();
} else if ($_GET["mode"] == "shark") {
    get_warns();
} else if ($_GET["mode"] == "generate") {
    generate_teams();
}