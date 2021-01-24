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
include "externalPHPfiles/trading_functionality.php";

if (isset($_POST["btn"])) {
    $id = $_POST["trade_code"];
    setcookie("trade_id", $id, time() + 86400);
    header("Location: trade_confirmation.php");
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
    <?php include "externalPHPfiles/userDAO.php";
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
    <div style="background-color: <?php if (get_dm_status() == 1) { echo "rgb(59,59,59)";} else {echo "lightgray"; } ?>; height: 50px; width: 85%; position:relative; top: 0;">
        <table style="width: 100%; text-align: center">
            <tr>
                <td style="width: 16.5%;">Érmét Ad</td>
                <td style="width: 16.5%;">Érmét Keres</td>
                <td style="width: 16.5%;">Hirdetés Feladója</td>
                <td style="width: 16.5%;">Hirdetés Dátuma</td>
                <td style="width: 16.5%;">Cseréért Járó Króniák</td>
                <td style="width: 16.5%;">Csere</td>
            </tr>
        </table>
    </div>
    <?php

    $conn = OpenCon();
    $sql = "SELECT * FROM trades";
    $result = $conn->query($sql);

    $top = 5;

    $first = true;

    if (get_dm_status() == 1) {
        $color_1 = "rgb(59,59,59)";
        $color_2 = "rgb(124,124,124)";
    } else {
        $color_1 = "lightgray";
        $color_2 = "white";
    }
    $i = 1;

    while ($row = mysqli_fetch_array($result)) {
        if ($i % 2 == 0) {
            $color = $color_1;
        } else {
            $color = $color_2;
        }
        $i++;
        echo "<div style='background-color: " . $color . "; width: 85%; height: 85px; position:relative; top: " . $top . "px; text-align: center;'>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 3%'><img style='width: 80px; height: 80px' alt='champion' src='" . get_image_for_name(trim($row["coin"])) . "'><p>" . $row["coin"] . "</p></div>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 19%'><img style='width: 80px; height: 80px' alt='champion_in_return' src='" . get_image_for_name(trim($row["coin_in_return"])) . "'><p>" . $row["coin_in_return"] . "</p></div>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 39%' id='owned".$i."'><p>" . $row["owned_by"] . "</p></div>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 52%'><p>" . $row["posted_on"] . "</p></div>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 74%'><img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' style='width: 25px; height: 25px; position:relative; top: 30px;' alt='cronia_value'><p>" . ' ' . $row["cronia_got"] . "</p></div>
                <div style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 74%'>
                <form method='POST' action='ongoing_trades.php' style='width: 16.5%; display: flex; font-size: 20pt; position:absolute; left: 96%; top: calc(42px - 12px);'>
                <input type='text' value='" . $row["coin_in_return"] . "' id='champion". $i . "' hidden name='number'>
                <input type='text' value='". $row["trade_code"] ."' hidden name='trade_code'>
                <input type='submit' disabled value='Csere' id='btn". $i . "' name='btn'>
</form>
</div>
            </div>";
        $top += 20;
    }


    ?>


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
            if (inventory[j].trim() === text.value && document.getElementById("owned" + i).innerText !== '<?php echo $_SESSION["username"]?>') {
                btn.removeAttribute("disabled");
                break;
            }
        }
    }
</script>
</html>
