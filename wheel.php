<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
include "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripts/preload.js"></script>
    <link rel="icon" href="/assets/logo.png">
    <?php include "externalPHPfiles/dark_mode_checker.php"; if (get_dm_status() == 0) {echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {{echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";}
    } ?>

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Treasure of Dragon Port</title>
</head>
<style>
    table, th, td {
        border: 1px solid <?php if (get_dm_status() == 0) { echo "black"; } else { echo "white"; } ?>;
        border-collapse: collapse;
    }

    a {
        display: block;
        height: 40px;
        padding-top: 20px;
    }

    .logout {
        height: 62px;
    }
</style>
<body onload="preload();" style="overflow-y: hidden; overflow-x: hidden;">
<aside class="index_aside" style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"];?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<div class='side_button'><a style='text-decoration: none; color: red;' href='admin_panel.php'>Admin Panel</a></div>" : "";

    echo "<div class='side_button'><a style='text-decoration: none;' href='index.php'>Kezdőlap</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='wheel.php'>Szerencsekerék</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='ongoing_trades.php'>Éremcsere</a></div>";
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

    <div>
    <p style='position: absolute; top: 0; right: 10px; font-size: 24px;'>Maradék pörgetések száma: <?php echo get_wheelturns() ?></p>
    <table class="container3">
        <tr>
            <td class="upper"><img alt="item1" src="<?php if (get_dm_status() == 0) { echo "assets/box_question_mark_black.png"; } else { echo "assets/box_question_mark_white.png"; } ?>" style="width: 200px;"></td>
            <td class="upper"><img alt="item2" src="<?php if (get_dm_status() == 0) { echo "assets/box_question_mark_black.png"; } else { echo "assets/box_question_mark_white.png"; } ?>" style="width: 200px;"></td>
            <td class="upper"><img alt="item2" src="<?php if (get_dm_status() == 0) { echo "assets/box_question_mark_black.png"; } else { echo "assets/box_question_mark_white.png"; } ?>" style="width: 200px;"></td>
        </tr>
        <tr>
            <td class="lower"></td>
            <td class="lower"></td>
            <td class="lower"></td>
        </tr>
    </table>

    <?php
        if (get_wheelturns() > 0) {
            echo "<form action='wheel.php' method='GET'>
        <input onclick='start_spin()' style='height: 30px; width: 150px; position:absolute; left: calc(100vw / 2 - 154px / 2); top: 500px;' type='submit' name='spin-btn' value='Pörgetés'>
    </form>";
        } else {
            echo "<form action='wheel.php' method='GET'>
        <input disabled style='height: 30px; width: 150px; position:absolute; left: calc(100vw / 2 - 154px / 2); top: 500px;' type='submit' name='spin-btn' value='Pörgetés'>
    </form>";
        }

        if (isset($_GET["spin-btn"])) {
            setcookie("spin-initiated", "true", time() + 86400);
            set_wheelturns(get_wheelturns()-1);
            header("Location: wheel_result.php");
        }
    ?>
</div>
<script src="scripts/wheel.js"></script>
</body>
</html>
