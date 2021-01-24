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
    <?php include "externalPHPfiles/dark_mode_checker.php"; if (get_dm_status() == 0) { echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";} ?>

    <title>Treasure of Dragon Port</title>
</head>

<style>
    a {
        display: block;
        height: 40px;
        padding-top: 20px;
    }

</style>

<body style="overflow-y: hidden; overflow-x: hidden">
<aside class="index_aside" style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"];?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<div class='side_button'><a style='text-decoration: none; color: red;' href='admin_panel.php'>Admin Panel</a></div>" : "";

    echo "<div class='side_button'><a style='text-decoration: none;' href='index.php'>Kezdőlap</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='wheel.php'>Szerencsekerék</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='ongoing_trades.php'>Éremcsere</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='leaderboard.php'>Ranglista</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='achievements.php'>Mérföldkövek</a></div>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push">
    <?php echo "<h1 style='position: relative; top: 5px;'>Üdvözlet ".get_felhasznalonev()."!</h1>" ?>
    <p>Az oldalsávban válaszd ki a kívánt funkciót!</p>

    <div>
        <br><h2>Hírek</h2>
        <div class="news" style="width: 1280px; height: 600px; overflow-y: scroll;">
            <p><?php include "externalPHPfiles/news.php"; get_news();?></p>
        </div>
    </div>
</div>
</body>
<script src="scripts/preload.js"></script>
</html>
