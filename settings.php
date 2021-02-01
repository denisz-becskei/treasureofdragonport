<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
include "db_connect.php";
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/rank_selector.php";
?>

<?php

function checkStringForIllegalCharacters($string): bool
{
    if (strlen($string) != strlen(utf8_decode($string)))
    {
        return false;
    }
    for ($i = 0; $i < strlen($string); $i++){
        if (!(ord($string[$i]) >= 48 && ord($string[$i]) <= 57 || ord($string[$i]) >= 65 && ord($string[$i]) <= 90 || ord($string[$i]) >= 97 && ord($string[$i]) <= 122)) {
            return false;
        }
    }
    return true;
}

if (isset($_POST["submit_changes"])) {
    //password changing
    $current_pass = $_POST["password_change0"];
    $new_pass = $_POST["password_change1"];
    $new_pass_again = $_POST["password_change2"];

    //email changing
    $new_email = $_POST["email_change"];

    //ign change
    $new_ign = $_POST["ign_change"];

    //rank change
    if (!isset($_POST["rank_change"]) || !isset($_POST["rank_change2"])) {
        $new_rank = "";
    } else {
        $new_rank = $_POST["rank_change"] . " " . $_POST["rank_change2"];
    }

    //submit
    $commit_password = $_POST["commit_password"];

    if ($new_email != "") {
        if (password_verify($commit_password, get_password())) {

            $conn = OpenCon();

            $username = $_SESSION["username"];

            $sql = "UPDATE user SET email = '$new_email' WHERE username = '$username'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Az e-mail címed sikeresen megváltozott!')</script>";
            }
            CloseCon($conn);
        } else {
            echo "<script>alert('A jóváhagyási jelszó helytelen!')</script>";
        }
    }

    if ($new_ign != "") {
        if (password_verify($commit_password, get_password())) {
            if (checkStringForIllegalCharacters($new_ign)) {

                $conn = OpenCon();

                $username = $_SESSION["username"];

                $sql = "UPDATE user SET ign = '$new_ign' WHERE username = '$username'";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Az In-game neved sikeresen megváltozott!')</script>";
                }
                CloseCon($conn);
            } else {
                echo "<script>alert('Az ingame név illegális karaktereket tartalmaz!')</script>";
            }
        } else {
            echo "<script>alert('A jóváhagyási jelszó helytelen!')</script>";
        }
    }

    if ($new_rank != "") {
        if (password_verify($commit_password, get_password())) {

            $conn = OpenCon();

            $username = $_SESSION["username"];

            $sql = "UPDATE user SET max_rank = '$new_rank' WHERE username = '$username'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('A legmagasabb rankod sikeresen megváltozott!')</script>";
            }
            CloseCon($conn);
        } else {
            echo "<script>alert('A jóváhagyási jelszó helytelen!')</script>";
        }
    }

    if ($current_pass != "" && $new_pass != "" && $new_pass_again != "") {
        if (password_verify($current_pass, get_password())) {
            if (strlen($new_pass) >= 6) {
                if ($new_pass == $new_pass_again) {
                    $conn = OpenCon();

                    $username = $_SESSION["username"];

                    $password_hashed = password_hash($new_pass, PASSWORD_DEFAULT);

                    $sql = "UPDATE user SET pass = '$password_hashed' WHERE username = '$username'";
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('A jelszó sikeresen megváltozott!')</script>";
                    }
                    CloseCon($conn);
                } else {
                    echo "<script>alert('A két megadott új jelszó nem egyezik meg!')</script>";
                }
            } else {
                echo "<script>alert('Az új jelszó nem tartalmaz legalább 6 karaktert!')</script>";
            }
        } else {
            echo "<script>alert('A jóváhagyási jelszó helytelen!')</script>";
        }
    } else if ($current_pass != "" || $new_pass != "" || $new_pass_again != "") {
        echo "<script>alert('Hiányzó adat a jelszóváltáshoz!')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/logo.png">
    <?php include "externalPHPfiles/dark_mode_checker.php";
    if (get_dm_status() == 0) {
        echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";
    } else {
        echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";
    } ?>
    <title>Treasure of Dragon Port</title>
</head>
<style>
    fieldset input {
        position: absolute;
        left: 550px;
    }

    fieldset input[type="submit"] {
        position: absolute;
        left: 548px;
    }

    fieldset select {
        position: absolute;
        left: 548px;
    }

    .rank2 {
        position: absolute;
        left: 665px;
    }

    a {
        display: block;
        height: 40px;
        padding-top: 20px;
    }

    .logout {
        height: 62px;
    }

    .btn:hover {
        transform: scale(1.2);
    }
</style>
<body style="overflow-y: hidden; overflow-x: hidden;">
<aside class="index_aside" style="<?php if (get_dm_status() == 0) {
    echo "background-color: lightgray";
} else {
    echo "background-color:gray";
} ?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php
    echo "<h1 style='font-size: 24pt'>" . get_felhasznalonev() . "</h1><img src='" . get_avatar_link($_SESSION["username"]) . "' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>" . get_ign() . "<img alt='max_rank' src='" . select_image_by_rank() . "' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>" . get_credits() . "  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> " . get_coronia() . "</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<div class='side_button'><a style='text-decoration: none; color: red;' href='admin_panel.php'>Admin Panel</a></div>" : "";

    echo "<div class='side_button'><a style='text-decoration: none;' href='index.php'>Kezdőlap</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='wheel.php'>Szerencsekerék</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><!--<a style='text-decoration: none;' href='ongoing_trades.php'>Éremcsere</a>--><img src='assets/uc.png' alt='under construction'></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='signup.php'>Versenyre Jelentkezés</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='leaderboard.php'>Ranglista</a></div>";
    echo "<div class='side_button'><!--<a style='text-decoration: none;' href='achievements.php'>Mérföldkövek</a>--><img src='assets/uc.png' alt='under construction'></div>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<div class='side_button'><a style='text-decoration: none;' href='faq.php'>GY.I.K.</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;"
                                        type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push" style="height: 100vh;">
    <form action="settings.php" method="POST" autocomplete="off">
        <fieldset>
            <legend>Adatváltoztatás</legend>
            <fieldset>
                <legend>Jelszóváltás</legend>
                <label for="password_change0">Jelenlegi jelszó:</label>
                <input type="password" id="password_change0" name="password_change0">
                <br>
                <label for="password_change1">Új jelszó:</label>
                <input type="password" id="password_change1" name="password_change1">
                <br>
                <label for="password_change2">Új jelszó újra:</label>
                <input type="password" id="password_change2" name="password_change2">
            </fieldset>
            <fieldset>
                <legend>E-mail váltás</legend>
                <label for="email_change">Új e-mail cím:</label>
                <input type="text" id="email_change" name="email_change">
            </fieldset>
            <fieldset>
                <legend>Játékadatok váltása</legend>
                <label for="ign_change">Új IGN:</label>
                <input type="text" id="ign_change" name="ign_change">
                <br>
                <label for="rank_change">Új legmagasabb rank:</label>
                <select id="rank_change" name="rank_change" style="left: 550px; top: 214px;" onchange="check_rank()">
                    <option selected disabled>
                        Válassz egyet!
                    </option>
                    <option>
                        Unranked
                    </option>
                    <option>
                        Bronze
                    </option>
                    <option>
                        Silver
                    </option>
                    <option>
                        Gold
                    </option>
                    <option>
                        Platinum
                    </option>
                    <option>
                        Diamond
                    </option>
                    <option>
                        Master
                    </option>
                    <option>
                        Grandmaster
                    </option>
                </select>
                <select class="rank2" style="width: 35px; top: 214px;" id="max_rank_2" name="rank_change2">
                    <option selected disabled>
                        Válassz egyet!
                    </option>
                    <option>
                        1
                    </option>
                    <option>
                        2
                    </option>
                    <option>
                        3
                    </option>
                    <option>
                        4
                    </option>
                    <option>
                        5
                    </option>
                </select>
            </fieldset>
        </fieldset>
        <fieldset>
            <fieldset>
                <legend>Változtatások jóváhagyása</legend>
                <label for="commit_password">Jelenlegi jelszó:</label>
                <input type="password" id="commit_password" name="commit_password" required>

                <br><br><label for="submit_changes">Jóváhagyás</label>
                <input type="submit" id="submit_changes" name="submit_changes" value="Változtatások mentése">
            </fieldset>
        </fieldset>
    </form>
    <p id="response" style="position: relative; left: 20px"></p>
    <div class="btn" id="toggle_dm" style="position:absolute; bottom: 20px;">
        <img style="height: 85px;" src="assets/btn_dark_mode.png" alt="toggle_dark_mode">
    </div>
    <div style="position:absolute; bottom: 20px; left: 90px; width: 120px; text-align: center;">
        <p>Avatárok</p>
        <select id="avatars" name="avatars" style="width: 125px">
            <option disabled selected>--</option>
            <?php include 'externalPHPfiles/avatars.php'?>
        </select>
    </div>

</div>
</body>
<script src="scripts/jquery-3.5.1.js"></script>
<script src="scripts/settings.js"></script>
<script src="scripts/avatar.js"></script>
<script src="scripts/register_scripts.js"></script>
</html>
