<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_COOKIE["spin-initiated"])) {
    setcookie("spin-initiated", false, time() + 86400);
}
if (!isset($_COOKIE["trade-initiated"]) || $_COOKIE["trade-initiated"] == false) {
    header("Location: trading_actions.php");
}
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
    <?php include "db_connect.php";
    include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<input style='color: red' type='submit' name='redir-admin' value='Admin Panel'>" : "";

    echo
    "<form action='trading_init.php' method='POST'>
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
    <div style="position:relative; left: 400px; top: 175px; width: 720px; height: 512px; background-image: url('assets/trading-bg.png'); color: white">
        <h2 style="position:relative; left: 300px; top: 50px;">Éremcsere</h2>
        <form style="position:relative; left: 0; top: 130px; text-align: center;" action="current_trade.php" method="POST">
            <?php
                if (isset($_COOKIE["trader"]) && $_COOKIE["trader"] == true) {
                    include "externalPHPfiles/trading_functionality.php"; ?>
                    <div style="width: 200px; height: 300px; position: absolute; top: -65px; left: 110px;"><?php echo "<img src=" . $avatars_coded[get_avatar()] ." style='width: 120px;'><br><h2><img alt='current_trader' src='assets/crown_icon.png' style='width: 24px; position:absolute; top: 170px; left: 85px;'>  ". $_SESSION["username"] ."</h2>"?></div>
                    <?php

                    function get_tradee_man($avatars_coded) {
                        if (get_tradee_avatar(get_tradee_name(find_code_by_trader($_SESSION["username"]))) == 1337) {
                            return "assets/box_question_mark.jpg";
                        }
                        else {
                            return $avatars_coded[get_tradee_avatar(get_tradee_name(find_code_by_trader($_SESSION["username"])))];
                        }
                    }
                    echo "<div style='width: 200px; height: 300px; position: absolute; top: -65px; right: 110px;'>"?>

                    <?php echo "<img alt='tradee' src=" . get_tradee_man($avatars_coded) . " style='width: 120px;'><br><h2>". get_tradee_name(find_code_by_trader($_SESSION["username"])) ."</h2></div>";
                    echo "<input style='position:relative; top: 250px;' type='submit' name='refresh' value='Frissítés'>
            <input style='position:relative; top: 250px;' type='submit' name='init_trade' value='Indítás'";
                    if (get_tradee_name(find_code_by_trader($_SESSION["username"])) == 'null') {echo "disabled";}
                    echo ">";
                }
                elseif (isset($_COOKIE["tradee"]) && $_COOKIE["tradee"] == true) {
                    include "externalPHPfiles/trading_functionality.php";
                    if (!is_exists($_COOKIE["trade-code"])) {
                        include "externalPHPfiles/clear_data.php";
                        clear_trades();
                        header("Location: trading_actions.php");
                    }

                    ?>
                    <div style="width: 200px; height: 300px; position: absolute; top: -65px; left: 110px;"><?php echo "<img src=" . $avatars_coded[get_avatar()] ." style='width: 120px;'><br><h2>". $_SESSION["username"] ."</h2>"?></div>
                    <?php echo "<div style='width: 200px; height: 300px; position: absolute; top: -65px; right: 110px;'>"?>
                    <?php

                    function get_trader_man($avatars_coded) {
                        if (get_trader_avatar(get_trader_name(find_code_by_tradee($_SESSION["username"]))) == 1337) {
                            return "assets/box_question_mark.jpg";
                        }
                        else {
                            return $avatars_coded[get_trader_avatar(get_trader_name(find_code_by_tradee($_SESSION["username"])))];
                        }
                    }

                    echo "<img alt='trader' src=" . get_trader_man($avatars_coded) . " style='width: 120px;'><br><h2><img alt='current_trader' src='assets/crown_icon.png' style='width: 24px; position:absolute; top: 170px; left: 85px;'>  ". get_trader_name(find_code_by_tradee($_SESSION["username"])) ."</h2></div>
                    <input style='position:relative; top: 250px;' type='submit' name='refresh2' value='Frissítés'>";
                }
                ?>
        </form>
    </div>
</div>
<?php
    if (isset($_POST["refresh"])) {
        header("Location: externalPHPfiles/redir.php");
    }
    if (isset($_POST["refresh2"])) {
        if (get_trade_start_status() == 1) {
            header("Location: initiated_trade.php");
        }
    }
    if (isset($_POST["init_trade"])) {
        init_trade();
        header("Location: initiated_trade.php");
    }
?>
</body>
</html>
