<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
    if (!isset($_COOKIE["spin-initiated"]) || $_COOKIE["spin-initiated"] == "true") {
        setcookie("spin-initiated", "false", time() + 86400);
    }
    setcookie("trade_ready", "false", time() + 86400);
include "db_connect.php";
include "externalPHPfiles/clear_data.php";
clear_trades();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <?php if (!isset($_COOKIE["dark-mode"]) || $_COOKIE["dark-mode"] == false) { echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";} ?>

    <title>Treasure of Dragon Port</title>
</head>

<style>
    .container_push {
        position: relative;
        left: 15%;
    }
</style>

<body style="overflow-y: hidden; overflow-x: hidden">
<aside class="index_aside" style="background-color: lightgray; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0";>
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"];?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<input style='color: red' type='submit' name='redir-admin' value='Admin Panel'>" : "";

    echo
    "<form action='index.php' method='POST'>
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
    <?php echo "<h1 style='position: relative; top: 5px;'>Üdvözlet ".get_felhasznalonev()."!</h1>" ?>
    <p>Az oldalsávban válaszd ki a kívánt funkciót!</p>

    <div>
        <br><h2>Hírek</h2>
        <div style="background-color: lightgray; width: 1280px; height: 600px; overflow-y: scroll;">
            <p><?php include "externalPHPfiles/news.php"; get_news();?></p>
        </div>
    </div>
</div>
</body>
<script src="scripts/preload.js"></script>
</html>
