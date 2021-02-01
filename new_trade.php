<?php
session_start();
header("Location: index.php");
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
include "db_connect.php";
?>

<?php
    $conn = OpenCon();
    $username = $_SESSION["username"];
    $sql = "SELECT number_of_trades FROM user WHERE username='$username'";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result)[0];
    $no_of_trades = intval($result);

    include "externalPHPfiles/trading_functionality.php";
    if (isset($_POST["lock"])) {
        if (is_champion($_POST["champion"]) && is_champion($_POST["champion2"]) && $no_of_trades < 3) {
            $username = $_SESSION["username"];
            $champ1 = $_POST["champion"];
            $champ2 = $_POST["champion2"];
            $champ_index = $_POST["champion_index"];

            add_trade($champ1, $champ_index, $champ2, $username);
            change_ongoing_trade_numbers($_SESSION["username"], "increase");
            header("Location: ongoing_trades.php");
        } else {
            header("Location: ongoing_trades.php");
        }
    }
    include "externalPHPfiles/userDAO.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link rel="icon" href="/assets/logo.png">
    <?php include "externalPHPfiles/dark_mode_checker.php"; if (get_dm_status() == 0) { echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";} ?>

    <title>Treasure of Dragon Port</title>
</head>

<style>
    a {
        display: block;
        height: 40px;
        padding-top: 20px;
    }

    .unselectable {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;

        -webkit-user-drag: none;
        user-drag: none;
    }

    .btn:hover {
        transform: scale(1.2);
    }
</style>

<body onload="generate_images();" style="overflow-y: hidden; overflow-x: hidden">
<p id="inventory" hidden><?php echo implode("|", get_inventory());?></p>
<aside class="index_aside" style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".get_avatar_link($_SESSION["username"])."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

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
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push" style="height: 100vh;">
    <div style="width: 85%; height: 100vh;text-align: center;">
        <form action="new_trade.php" method="POST" style="width: 65%; height: 50vh; z-index: 2; display:flex; position:relative; left: calc(100% / 2 - 65% / 2); top: calc(100% / 2 - 50vh / 2);">
            <div onclick="show_change_1();" style=" width: 40%; height: 100%; z-index: 2;">
                <h3 style="position:absolute; top: -2vh; left: 8vw; color: <?php if (get_dm_status() == 0) { echo "black"; } else { echo "white"; } ?>">Érmét Adok:</h3>
                <img class="unselectable" draggable="false" style="width: 75%; top: 2vh; position: relative;" src="<?php if (get_dm_status() == 0) { echo "assets/box_question_mark_black.png"; } else { echo "assets/box_question_mark_white.png"; } ?>" alt="trade" id="trade_coin"><br>
                <input type="text" readonly name="champion" id="champion" style="position:relative; bottom: 3vh; text-align: center; border: none; background-color: transparent; <?php if (get_dm_status() == 0) {
                    echo "color: black";
                } else {
                    echo "color:white";
                } ?>">
                <div style="padding: 0; border: 2px solid <?php if (get_dm_status() == 0) {echo "black"; } else {echo "white"; } ?>; width: 75%; height: 60%; position:relative; left: 2.75vw; opacity: 0;" id="inv">
                    <img src="<?php if (get_dm_status() == 0) { echo "assets/list_coins_black.png"; } else { echo "assets/list_coins_white.png"; } ?>" alt="next" onclick="page_forward_inventory();" style="position:absolute; right: 0; width: 30px;">
                </div>
            </div>
            <img src="<?php if (get_dm_status() == 0) { echo "assets/swap_icon_black.png"; } else { echo "assets/swap_icon_white.png"; } ?>" alt="swapping with" style="width: 11vw; height: 11vw; position:relative; top: calc(50% - 11vw / 2);"><br>
            <h3 style="position:absolute; height: 25px; width: 150px; left: calc(100% / 2 - 150px / 2); bottom: -15%;" <?php if ($no_of_trades < 3) { echo "hidden"; } ?>>Elérted a maximális csereszámot!</h3>

            <input style="position:absolute; height: 25px; width: 150px; left: calc(100% / 2 - 150px / 2); bottom: 2%;" <?php if ($no_of_trades == 3) { echo "disabled"; } ?> type="submit" name="lock" id="lock" value="Új Csere Hozzáadása" disabled>
            <div onclick="show_change_2();" style="width: 40%; height: 100%;">
                <h3 style="position:absolute; top: -2vh; right: 8vw; color: <?php if (get_dm_status() == 0) { echo "black"; } else { echo "white"; } ?>">Érmét Keresek:</h3>
                <img class="unselectable" draggable="false" style="width: 75%; top: 2vh; position: relative;" src="<?php if (get_dm_status() == 0) { echo "assets/box_question_mark_black.png"; } else { echo "assets/box_question_mark_white.png"; } ?>" alt="trade2" id="trade_coin2"><br>
                <input type="text" readonly name="champion2" id="champion2" style="position:relative; bottom: 3vh; text-align: center; border: none; background-color: transparent; <?php if (get_dm_status() == 0) {
                    echo "color: black";
                } else {
                    echo "color:white";
                } ?>">
                <div style="padding: 0; border: 2px solid <?php if (get_dm_status() == 0) {echo "black"; } else {echo "white"; } ?>; width: 75%; height: 60%; position:relative; left: 2.75vw; opacity: 0;" id="collection">
                    <img src="<?php if (get_dm_status() == 0) { echo "assets/list_coins_black.png"; } else { echo "assets/list_coins_white.png"; } ?>" alt="next" onclick="page_forward();" style="position:absolute; right: 0; width: 30px;">
                </div>
            </div>
        </form>
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
<script src="scripts/jquery-3.5.1.js"></script>
<script src="scripts/get_image.js"></script>
<script src="scripts/new_trade.js"></script>
<script>
</script>
</html>
