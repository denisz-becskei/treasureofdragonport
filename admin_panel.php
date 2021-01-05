<?php
session_start();
include "db_connect.php";
include "externalPHPfiles/clear_data.php";
clear_trades();
include "externalPHPfiles/userDAO.php";
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (get_status() != 1 && get_status() != 2) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Treasure of Dragon Port</title>
</head>
<style>
    .container_push {
        position: relative;
        left: 15%;
    }
</style>
<body style="overflow-y: hidden; overflow-x: hidden;">
<aside class="index_aside" style="background-color: lightgray; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0";>
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"];?>
    <?php include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<input style='color: red' type='submit' name='redir-admin' value='Admin Panel'>" : "";

    echo
    "<form action='admin_panel.php' method='POST'>
        <input type='submit' name='redir-index' value='Kezdőlap'>
        <input type='submit' name='redir-wheel' value='Szerencsekerék'>
        <input type='submit' name='redir-trading' value='Éremcsere'>
        <input type='submit' name='redir-inventory' value='Aranyzsák'>
        <input type='submit' name='redir-leaderboard' value='Ranglista'>
        <input type='submit' name='redir-achievements' value='Mérföldkövek'>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<input type='submit' name='redir-settings' value='Beállítások'>
    </form>";

    if (isset($_POST["redir-index"])) {header("Location: index.php");}
    if (isset($_POST["redir-wheel"])) {header("Location: wheel.php");}
    if (isset($_POST["redir-trading"])) {header("Location: trading_actions.php");}
    if (isset($_POST["redir-inventory"])) {header("Location: inventory.php");}
    if (isset($_POST["redir-leaderboard"])) {header("Location: leaderboard.php");}
    if (isset($_POST["redir-achievements"])) {header("Location: achievements.php");}
    if (isset($_POST["redir-settings"])) {header("Location: settings.php");}
    if (isset($_POST["redir-admin"])) {header("Location: admin_panel.php");}
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <input type="submit" name="lgt-button" value="Kijelentkezés">
    </form>

</aside>
<div class="container_push">
    <form action="admin_panel.php" method="POST">
        <fieldset>
            <legend>Felhasználókezelés</legend>
            <label for="user_editing">Módosítandó felhasználó neve:</label>
            <input id="user_editing" name="user_editing" type="text" required>
            <br><br>
            <label for="add_spins">Pörgetés hozzáadása:</label>
            <input id="add_spins" name="add_spins" type="text">
            <br>
            <label for="subtract_spins">Pörgetés levonása:</label>
            <input id="subtract_spins" name="subtract_spins" type="text">
            <br>
            <label for="grant_status">Admin státusz módosítása:</label>
            <input id="grant_status" name="change_status" value="Módosítandó" type="checkbox">
            <input name="grant_status" value="Státusz" type="checkbox">
            <br>
            <label for="set_credits">Kreditek állítása:</label>
            <input name="set_credits" id="set_credits" type="text">
            <br>
            <label for="complete_achievement">Mérföldkő teljesítése:</label>
            <input name="complete_achievement" id="complete_achievement" type="text">
            <br>
            <label for="uncomplete_achievement">Mérföldkő törlése:</label>
            <input name="uncomplete_achievement" id="uncomplete_achievement" type="text">
            <br>
            <label for="post_news">Hír közzététele:</label>
            <input name="post_news" id="post_news" type="text">
            <br>
            <label for="add_coin">Érme hozzáadása:</label>
            <input name="add_coin" id="add_coin" type="text">
            <br>
            <input type="submit" name="modification-btn" value="Módosítások elvégzése">
        </fieldset>
    </form>
</div>
<?php
include "externalPHPfiles/achievement_handler.php";

    if (isset($_POST["modification-btn"])) {
        $user_to_edit = $_POST["user_editing"];
        $spins_to_add = $_POST["add_spins"];
        $spins_to_subtract = $_POST["subtract_spins"];
        $set_credits = $_POST["set_credits"];
        $complete_achievement = $_POST["complete_achievement"];
        $uncomplete_achievement = $_POST["uncomplete_achievement"];
        $post_news = $_POST["post_news"];
        $add_coin = $_POST["add_coin"];

        $editing_data = [false, false, false, false, false, false, false, false];
        $status_to_give = 0;

        if ($spins_to_add != "") {
            $editing_data[0] = true;
        }
        if ($spins_to_subtract != "") {
            $editing_data[1] = true;
        }
        if (isset($_POST["change_status"])) {
            if (isset($_POST["grant_status"])) {
                $status_to_give = 1;
            } else {
                $status_to_give = 0;
            }
            $editing_data[2] = true;
        }
        if ($set_credits != "") {
            $editing_data[3] = true;
        }

        if ($complete_achievement != "") {
            $editing_data[4] = true;
        }

        if ($uncomplete_achievement != "") {
            $editing_data[5] = true;
        }

        if ($post_news != "") {
            $editing_data[6] = true;
        }

        if ($add_coin != "") {
            $editing_data[7] = true;
        }

        $conn = OpenCon();

        if ($editing_data[0]) {
            $sql = "SELECT wheelturns FROM user WHERE username = '$user_to_edit'";
            $result = $conn->query($sql);
            $spins_currently = mysqli_fetch_array($result)[0];
            $spins_currently += $spins_to_add;
            $sql = "UPDATE user SET wheelturns = '$spins_currently' WHERE username = '$user_to_edit'";
            mysqli_query($conn, $sql);
            mail("dbecskei1@outlook.com", "Pörgetések hozzáadva - Mix League", "Ezen mennyiségű pörgetést kaptál: '$spins_to_add'. Pörgess most!");
        }
        if ($editing_data[1]) {
            $sql = "SELECT wheelturns FROM user WHERE username = '$user_to_edit'";
            $result = $conn->query($sql);
            $spins_currently = mysqli_fetch_array($result)[0];
            $spins_currently = strval($spins_currently);
            $spins_currently -= $spins_to_subtract;
            if ($spins_currently < 0) {
                $spins_currently = 0;
            }
            $sql = "UPDATE user SET wheelturns = '$spins_currently' WHERE username = '$user_to_edit'";
            mysqli_query($conn, $sql);
        }
        if ($editing_data[2]) {
            $sql = "SELECT user_status FROM user WHERE username = '$user_to_edit'";
            $result = $conn->query($sql);
            $current_status = mysqli_fetch_array($result)[0];

            if ($current_status != 2) {
                $sql = "UPDATE user SET user_status = '$status_to_give' WHERE username = '$user_to_edit'";
                mysqli_query($conn, $sql);
            } else {
                echo "Hé, nem bántani azt a felhasználót :c";
            }
        }
        if ($editing_data[3]) {
            $sql = "UPDATE user SET credits = '$set_credits' WHERE username = '$user_to_edit'";
            mysqli_query($conn, $sql);
        }
        if ($editing_data[4]) {
            complete_achievement($user_to_edit, $complete_achievement);
        }
        if ($editing_data[5]) {
            uncomplete_achievement($user_to_edit, $uncomplete_achievement);
        }
        if ($editing_data[6]) {
            include "externalPHPfiles/news.php";
            add_news($post_news);
        }
        if ($editing_data[7]) {
            include "externalPHPfiles/trading_functionality.php";
            add_coin($user_to_edit, $add_coin);
        }
        CloseCon($conn);
        header("Location: admin_panel.php");
    }


?>
</body>
</html>
