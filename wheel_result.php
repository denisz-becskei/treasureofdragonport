<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if ($_COOKIE["spin-initiated"] == false or !isset($_COOKIE["spin-initiated"])) {
    header("Location: wheel.php");
}

include "db_connect.php";
include "externalPHPfiles/clear_data.php";
clear_trades();

include "externalPHPfiles/achievement_handler.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Treasure of Dragon Port</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body style="overflow-y: hidden; overflow-x: hidden;">
<aside class="index_aside" style="background-color: lightgray; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0";>
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"]; ?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<input style='color: red' type='submit' name='redir-admin' value='Admin Panel'>" : "";

    echo
    "<form action='wheel_result.php' method='POST'>
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

<div>
    <?php echo "<p style='position: absolute; top: 0; right: 10px; font-size: 24px;'>Maradék pörgetések száma: ".get_wheelturns()."</p>"?>
    <table class="container3">
        <tr>
            <td class="upper"><img alt="item1" id="item1" src="assets/box_question_mark.jpg" style="width: 200px;"></td>
            <td class="upper"><img alt="item1" id="item2" src="assets/box_question_mark.jpg" style="width: 200px;"></td>
            <td class="upper"><img alt="item1" id="item3" src="assets/box_question_mark.jpg" style="width: 200px;"></td>
        </tr>
        <tr>
            <td class="lower"><p id="item_name1"></p>
                <p hidden id="item_rarity1"></p></td>
            <td class="lower"><p id="item_name2"></p>
                <p hidden id="item_rarity2"></p></td>
            <td class="lower"><p id="item_name3"></p>
                <p hidden id="item_rarity3"></p></td>
        </tr>
    </table>
    <audio id="ticking" hidden src="assets/sounds/tick.ogg" controls></audio>
    <audio id="chinging" hidden src="assets/sounds/ching.ogg" controls></audio>

    <form action='wheel_result.php' method='POST'>
        <input hidden id="back" class='container3' style='height: 30px; width: 150px' type='submit' name='redir-btn'
               value='Elfogadás'>
    </form>

    <?php
    if (isset($_POST["redir-btn"])) {
        setcookie("spin-initiated", false, time() + 86400);
        complete_achievement($_SESSION["username"], 1);
        header("Location: externalPHPfiles/update_inventory.php");
    }
    ?>
</div>
</body>
<script src="scripts/wheel_result.js"></script>
</html>
