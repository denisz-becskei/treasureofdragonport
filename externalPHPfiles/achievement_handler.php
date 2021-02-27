<?php
function complete_achievement($user, $achievement_number) {
    $conn = OpenCon();

    $username = $user;
    $sql = "SELECT achievements FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    $achievements = mysqli_fetch_array($result)[0];
    $achievements = explode(",", $achievements);

    $new_achievements = [];

    for ($i = 0; $i < count($achievements); $i++) {
        if ($i != $achievement_number-1) {
            array_push($new_achievements, $achievements[$i]);
        } else {
            array_push($new_achievements, "O");
        }
    }

    $achievements_stringed = "";
    for ($i = 0; $i < count($new_achievements); $i++) {
        if ($i != count($new_achievements)-1) {
            $achievements_stringed = $achievements_stringed . $new_achievements[$i] . ",";
        } else {
            $achievements_stringed = $achievements_stringed . $new_achievements[$i];
        }
    }

    $sql = "UPDATE user SET achievements = '$achievements_stringed' WHERE username = '$username'";
    mysqli_query($conn, $sql);

    $sql = "SELECT achievements FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    $achievements = mysqli_fetch_array($result)[0];
    $achievements = explode(",", $achievements);

    if ($achievement_number != 18) {
        $completed_count = 0;
        foreach ($achievements as $ach) {
            if ($ach == "O") {
                $completed_count++;
            }
        }

        if ($completed_count == 17) {
            complete_achievement($username, 18);
        }
    }

    CloseCon($conn);
}

function uncomplete_achievement($user, $achievement_number) {
    $conn = OpenCon();

    $username = $user;
    $sql = "SELECT achievements FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    $achievements = mysqli_fetch_array($result)[0];
    $achievements = explode(",", $achievements);

    $new_achievements = [];

    for ($i = 0; $i < count($achievements); $i++) {
        if ($i != $achievement_number-1) {
            array_push($new_achievements, $achievements[$i]);
        } else {
            array_push($new_achievements, "X");
        }
    }

    $achievements_stringed = "";
    for ($i = 0; $i < count($new_achievements); $i++) {
        if ($i != count($new_achievements)-1) {
            $achievements_stringed = $achievements_stringed . $new_achievements[$i] . ",";
        } else {
            $achievements_stringed = $achievements_stringed . $new_achievements[$i];
        }
    }

    $sql = "UPDATE user SET achievements = '$achievements_stringed' WHERE username = '$username'";
    mysqli_query($conn, $sql);

    CloseCon($conn);
}

function check_for_achievement($achievement_number) {
    $list = ["undefined"];

    if ($achievement_number == 2) {
        $list = ["Androxus", "Buck", "Evie", "Koga", "Lex", "Maeve", "Moji", "Skye", "Talus", "Zhin"];
    } elseif ($achievement_number == 3) {
        $list = ["Bomb_King", "Cassie", "Dredge", "Drogoz", "Imani", "Kinessa", "Lian", "Sha_Lin", "Strix", "Tiberius", "Tyra", "Viktor", "Vivian", "Willo"];
    } elseif ($achievement_number == 4) {
        $list = ["Furia", "Grohk", "Grover", "Io", "Jenos", "Mal'Damba", "Pip", "Seris", "Ying"];
    } elseif ($achievement_number == 5) {
        $list = ["Ash", "Atlas", "Barik", "Fernando", "Inara", "Khan", "Makoa", "Raum", "Ruckus", "Terminus", "Torvald", "Yagorath"];
    } elseif ($achievement_number == 12) {
        $list = ["Bomb_King", "Dredge", "Drogoz", "Willo", "Pip", "Ash", "Fernando", "Terminus"];
    } elseif ($achievement_number == 13) {
        $list = ["Viktor", "Tyra", "Tiberius", "Raum", "Vivian"];
    } elseif ($achievement_number == 14) {
        $list = ["Androxus", "Vora", "Maeve", "Raum", "Koga", "Evie"];
    } elseif ($achievement_number == 16) {
        $list = ["Furia", "Grover", "Ying", "Barik", "Inara", "Makoa", "Cassie", "Sha_Lin", "Tyra", "Buck", "Evie", "Koga", "Talus"];
    } elseif ($achievement_number == 17) {
        $list = ["Corvus", "Ash", "Fernando", "Khan", "Terminus", "Torvald", "Lian", "Strix", "Viktor", "Vivian", "Lex", "Skye"];
    }
    $ready_for_completion = true;

    $champions = get_inventory_2($_SESSION["username"]);


    foreach ($list as $l) {
        if (intval($champions[$l]) == 0) {
            $ready_for_completion = false;
        }
    }

    if ($ready_for_completion) {
        complete_achievement($_SESSION["username"], $achievement_number);
    }

}

function check_for_achievement_collection() {
    $uni = get_unique();
    $username = $_SESSION["username"];
    if ($uni >= 1) {
        complete_achievement($username, 1);
    }
    if ($uni >= 10) {
        complete_achievement($username, 6);
    }
    if ($uni >= 20) {
        complete_achievement($username, 7);
    }
    if ($uni >= 30) {
        complete_achievement($username, 8);
    }
    if ($uni >= 40) {
        complete_achievement($username, 9);
    }
    if ($uni == 47) {
        complete_achievement($username, 10);
    }
}

function get_achievement_status($achievement_number) {
    $conn = OpenCon();

    $username = $_SESSION["username"];
    $sql = "SELECT achievements FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    $achievements = mysqli_fetch_array($result)[0];
    $achievements = explode(",", $achievements);
    CloseCon($conn);

    if ($achievements[$achievement_number-1] == "O") {
        return true;
    } else {
        return false;
    }
}
