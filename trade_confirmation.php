<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_COOKIE["trade_id"])) {
    header("Location: ongoing_trades.php");
}
include "db_connect.php";
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/update_new_inventory.php";
include "externalPHPfiles/trading_functionality.php";
include "externalPHPfiles/external_userDAO.php";
include "externalPHPfiles/championDAO.php";

if (get_inventory_2($_SESSION["username"])[get_coins_by_id($_COOKIE["trade_id"])[1]] == 0 || get_coins_by_id($_COOKIE["trade_id"])[2] == $_SESSION["username"]) {
    initiate_violation($_SESSION["username"], "attempt of confirming unconfirmable trade");
    header("Location: ongoing_trades.php");
}

if (isset($_POST["confirm"])) {
    if (get_trade_date()) {
        remove_champion(get_coins_by_id($_COOKIE['trade_id'])[2], get_coins_by_id($_COOKIE['trade_id'])[0]);
        remove_champion($_SESSION["username"], get_coins_by_id($_COOKIE['trade_id'])[1]);

        add_champion(get_coins_by_id($_COOKIE['trade_id'])[2], get_coins_by_id($_COOKIE['trade_id'])[1]);
        add_champion($_SESSION["username"], get_coins_by_id($_COOKIE['trade_id'])[0]);

        add_cronias($_SESSION["username"], get_coins_by_id($_COOKIE['trade_id'])[2], $_COOKIE["trade_id"]);

        update_trade_date();
        decrease_trades(get_coins_by_id($_COOKIE['trade_id'])[2]);
        remove_trade($_COOKIE["trade_id"]);
    }
    header("Location: ongoing_trades.php");
}
if (isset($_POST["deny"])) {
    setcookie('trade_id');
    header("Location: ongoing_trades.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
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
    a {
        display: block;
        height: 40px;
        padding-top: 20px;
    }

    .btn:hover {
        transform: scale(1.2);
    }

</style>

<body style="overflow-y: hidden; overflow-x: hidden">
<aside class="index_aside" style="<?php if (get_dm_status() == 0) {
    echo "background-color: lightgray";
} else {
    echo "background-color:gray";
} ?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll; z-index: 0;">
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"]; ?>
    <?php
    include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>" . get_felhasznalonev() . "</h1><img src='" . get_avatar_link($_SESSION["username"]) . "' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>" . get_ign() . "<img alt='max_rank' src='" . select_image_by_rank() . "' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>" . get_credits() . "  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> " . get_coronia() . "</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<div class='side_button'><a style='text-decoration: none; color: red;' href='admin_panel.php'>Admin Panel</a></div>" : "";

    echo "<div class='side_button'><a style='text-decoration: none;' href='index.php'>Kezdőlap</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='wheel.php'>Szerencsekerék</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='ongoing_trades.php'>Éremcsere</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='signup.php'>Versenyre Jelentkezés</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='leaderboard.php'>Ranglista</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='achievements.php'>Mérföldkövek</a></div>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<div class='side_button'><a style='text-decoration: none;' href='faq.php'>GY.I.K.</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='feedback.php'>Visszajelzés</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;"
                                        type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push" style="display: flex; flex-flow: row wrap; align-content: center; justify-content: center; height: 100vh; overflow-y: scroll">

    <div style="background-image: url('assets/trading-bg.png'); background-repeat: no-repeat; background-size: contain; height: 75vh; width: 50vw;">

        <div style="margin-top: 18vh; display: flex; justify-content: center; align-content: center;">
            <img style="width: 10vw; margin-right: 3vw;" src="<?php echo get_image_for_name(trim(get_coins_by_id($_COOKIE['trade_id'])[0])) ?>">
            <img style="width: 8vw; margin-right: 3vw;" src="assets/swap_icon_white.png">
            <img style="width: 10vw;" src="<?php echo get_image_for_name(trim(get_coins_by_id($_COOKIE['trade_id'])[1])) ?>">
        </div>


        <div style="display: flex; flex-flow: column nowrap; align-content: center; justify-content: center; text-align: center">
            <h3 style="color: white; font-size: 2vh">Biztos vagy benne, hogy végre szeretnéd a cserét hajtani?</h3>
            <form action="trade_confirmation.php" method="POST">
                <input type="submit" <?php if (get_trade_date() == false) { echo "disabled"; } ?> value="Igen" name="confirm">
                <input type="submit" value="Nem" name="deny">
                <p style="color: white" <?php if (get_trade_date() == true) { echo "hidden"; }?>>Napi 1 csere megengedett!</p>
            </form>
        </div>

    </div>

    <a href="ongoing_trades.php" style="position:absolute; left: 0; bottom: 20px; height: 85px; width: 85px; z-index: 50;">
        <img class="btn" src="assets/btn_all.png" style="position:absolute; left: 0; bottom: 20px; height: 85px;"
             alt="all_trades">
    </a>
    <a href="new_trade.php" style="position:absolute; left: 90px; bottom: 20px; height: 85px; width: 85px; z-index: 50;">
        <img class="btn" src="assets/btn_add_new.png" style="position:absolute; left: 0; bottom: 20px; height: 85px;"
             alt="new_trade">
    </a>
    <a href="own_trades.php" style="position:absolute; left: 180px; bottom: 20px; height: 85px; width: 85px;">
        <img class="btn" src="assets/btn_own.png" style="position:absolute; bottom: 20px; height: 85px;"
             alt="own_trades">
    </a>
</div>
</body>
<script src="scripts/preload.js"></script>
<script>
</script>
</html>
