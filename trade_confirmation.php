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
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/trading_functionality.php";

if (isset($_POST["confirm"])) {
    add_coin(get_coins_by_id($_COOKIE['trade_id'])[2], get_coins_by_id($_COOKIE['trade_id'])[1]);
    add_coin($_SESSION["username"], get_coins_by_id($_COOKIE['trade_id'])[0]);

    function get_index($champion) {
        $inventory = get_inventory();
        $inventory = explode(", ", $inventory);
        $ind = 0;
        foreach ($inventory as $i) {
            if (trim($i) == $champion) {
                return $ind;
            }
            $ind++;
        }
        return null;
    }

    remove_from_inventory(get_coins_by_id($_COOKIE['trade_id'])[2], get_coins_by_id($_COOKIE['trade_id'])[3], false);
    remove_from_inventory($_SESSION["username"], get_index(get_index(get_coins_by_id($_COOKIE['trade_id'][1]))), false);
    add_cronias($_SESSION["username"], get_coins_by_id($_COOKIE['trade_id'])[2], $_COOKIE["trade_id"]);
    remove_trade($_COOKIE["trade_id"]);
    header("Location: ongoing_trades.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
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
} ?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"]; ?>
    <?php
    include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>" . get_felhasznalonev() . "</h1><img src='" . $avatars_coded[get_avatar()] . "' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>" . get_ign() . "<img alt='max_rank' src='" . select_image_by_rank() . "' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>" . get_credits() . "  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> " . get_coronia() . "</h2>"; ?>

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
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;"
                                        type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push" style="height: 100vh; overflow-y: scroll">

    <div>
        <img style="width: 250px; position:absolute; top: 150px; left: 15%;" src="<?php echo get_image_for_name(trim(get_coins_by_id($_COOKIE['trade_id'])[0])) ?>">
        <img style="width: 250px; position:absolute; top: 150px; right: 30%;" src="<?php echo get_image_for_name(trim(get_coins_by_id($_COOKIE['trade_id'])[1])) ?>">

        <form action="trade_confirmation.php" method="POST" style="position:absolute; top: 500px; left: calc(100vw / 2 - 350px / 2)">
            <input type="submit" value="Igen" name="confirm">
            <input type="submit" value="Nem" name="deny">
        </form>
    </div>


    <a href="new_trade.php" style="position:absolute; left: 0; bottom: 20px; height: 85px; width: 85px;">
        <img class="btn" src="assets/btn_add_new.png" style="position:absolute; left: 0; bottom: 20px; height: 85px;"
             alt="add_trades">
    </a>
    <a href="own_trades.php" style="position:absolute; left: 90px; bottom: 20px; height: 85px; width: 85px;">
        <img class="btn" src="assets/btn_own.png" style="position:absolute; bottom: 20px; height: 85px;"
             alt="own_trades">
    </a>
</div>
</body>
<script src="scripts/preload.js"></script>
<script>
    <?php
    $inventory = get_inventory(); $inventory = explode(",", $inventory);?>

    var inventory = "<?php echo get_inventory()?>";
    inventory = inventory.split(",");
    inventory.pop();

    for (let i = 2; i < <?php echo get_trade_count() + 2; ?>; i++) {
        let btn = document.getElementById("btn" + i);
        let text = document.getElementById("champion" + i);

        for (let j = 0; j < inventory.length; j++) {
            console.log("Checking " + inventory[j] + " " + text.value);
            if (inventory[j].trim() === text.value) {
                btn.removeAttribute("disabled");
                break;
            }
        }
    }
</script>
</html>
