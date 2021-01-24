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

<?php
    include "externalPHPfiles/trading_functionality.php";
    if (isset($_POST["lock"])) {
        $username = $_SESSION["username"];
        $champ1 = $_POST["champion"];
        $champ2 = $_POST["champion2"];

        add_trade($champ1, $champ2, $username);
        header("Location: ongoing_trades.php");
    }

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
<div class="container_push" style="height: 100vh;">
    <img class="unselectable" draggable="false" src="assets/list_coins.png" alt="previous" id="prev_arrow" style="border: 5px solid black; height: 300px; transform: scaleX(-1); position:absolute; left: calc(100vw / 2 - 350px - 15%);">
    <img class="unselectable" draggable="false" style="width: 300px; position: absolute; left: calc(100vw / 2 - 150px - 15%)" src="assets/box_question_mark.jpg" alt="trade" id="trade_coin">
    <img class="unselectable" draggable="false" src="assets/list_coins.png" alt="next" id="next_arrow" style="border: 5px solid black; height: 300px; position:absolute; left: calc(100vw / 2 + 200px - 15%);">
    <form method="POST" action="new_trade.php">
        <input style="position: relative; left: calc(100vw / 2 - 75px - 15%); top: 350px; text-align: center; background-color: transparent; border: none;" readonly value="" type="text" name="champion" id="champion"><br>

        <input style="position: relative; left: calc(100vw / 2 - 75px - 15%); top: calc(100vh - 150px); text-align: center; background-color: transparent; border: none;" readonly value="" type="text" name="champion2" id="champion2"><br>
        <input style="position: relative; left: calc(100vw / 2 - 50px - 15%); top: calc(100vh - 100px)" type="submit" name="lock" id="lock" disabled>
    </form>
    <a href="ongoing_trades.php">
        <img class="btn" src="assets/btn_all.png" style="position:absolute; left: 0; bottom: 20px; height: 85px;"
             alt="all_trades">
    </a>
    <a href="own_trades.php">
        <img class="btn" src="assets/btn_own.png" style="position:absolute; left: 90px; bottom: 20px; height: 85px;"
             alt="own_trades">
    </a>
    <div style="position:relative; top: 360px;">
        <img class="unselectable" draggable="false" src="assets/list_coins.png" alt="previous" id="prev_arrow2" style="border: 5px solid black; height: 300px; transform: scaleX(-1); position:absolute; left: calc(100vw / 2 - 350px - 15%);">
        <img class="unselectable" draggable="false" style="width: 300px; position: absolute; left: calc(100vw / 2 - 150px - 15%)" src="assets/box_question_mark.jpg" alt="trade" id="trade_coin2">
        <img class="unselectable" draggable="false" src="assets/list_coins.png" alt="next" id="next_arrow2" style="border: 5px solid black; height: 300px; position:absolute; left: calc(100vw / 2 + 200px - 15%);">
    </div>
</div>

</body>
<script src="scripts/preload.js"></script>
<script src="scripts/get_image.js"></script>
<script>
    var inventory = "<?php echo get_inventory()?>";
    inventory = inventory.split(",");
    inventory.pop();
    console.log(inventory);
    var index = -1;

    document.getElementById("prev_arrow").onclick = function() {
        index--;
        if (index >= 0) {
            document.getElementById("trade_coin").src = get_image_for_name(inventory[index].trim());
            document.getElementById("champion").value = inventory[index];
        } else {
            index = inventory.length - 1;
            document.getElementById("trade_coin").src = get_image_for_name(inventory[index].trim());
            document.getElementById("champion").value = inventory[index];
        }

        if (index !== -1 && index2 !== -1) {
            document.getElementById("lock").removeAttribute("disabled");
        }
    };

    document.getElementById("next_arrow").onclick = function() {
        index++;
        if (index < inventory.length) {
            document.getElementById("trade_coin").src = get_image_for_name(inventory[index].trim());
            document.getElementById("champion").value = inventory[index];
        } else {
            index = 0;
            document.getElementById("trade_coin").src = get_image_for_name(inventory[index].trim());
            document.getElementById("champion").value = inventory[index];
        }

        if (index !== -1 && index2 !== -1) {
            document.getElementById("lock").removeAttribute("disabled");
        }
    };

    let entire_array = ["Yagorath", "Vora", "Corvus", "Raum", "Tiberius", "Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus",
        "Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye",
        "Jenos", "Vivian", "Buck", "Seris", "Inara", "Grohk", "Viktor", "Cassie", "Lex", "Grover", "Ash", "Ruckus", "Fernando", "Barik", "Pip", "Moji"];

    entire_array.sort();
    var index2 = -1;

    document.getElementById("prev_arrow2").onclick = function() {
        index2--;
        if (index2 >= 0) {
            document.getElementById("trade_coin2").src = get_image_for_name(entire_array[index2].trim());
            document.getElementById("champion2").value = entire_array[index2];
        } else {
            index2 = entire_array.length - 1;
            document.getElementById("trade_coin2").src = get_image_for_name(entire_array[index2].trim());
            document.getElementById("champion2").value = entire_array[index2];
        }

        if (index !== -1 && index2 !== -1) {
            document.getElementById("lock").removeAttribute("disabled");
        }
    };

    document.getElementById("next_arrow2").onclick = function() {
        index2++;
        if (index2 < entire_array.length) {
            document.getElementById("trade_coin2").src = get_image_for_name(entire_array[index2].trim());
            document.getElementById("champion2").value = entire_array[index2];
        } else {
            index = 0;
            document.getElementById("trade_coin2").src = get_image_for_name(entire_array[index2].trim());
            document.getElementById("champion2").value = entire_array[index2];
        }

        if (index !== -1 && index2 !== -1) {
            document.getElementById("lock").removeAttribute("disabled");
        }
    };
</script>
</html>
