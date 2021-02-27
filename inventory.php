<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
include "db_connect.php";
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/championDAO.php";
include "externalPHPfiles/trading_functionality.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/logo.png">
    <?php include "externalPHPfiles/dark_mode_checker.php"; if (get_dm_status() == 0) {echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {{echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";}
    } ?>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <?php if (get_dm_status() == 0) {echo "<link rel='stylesheet' type='text/css' href='css/inventory.css'>";} else {{echo "<link rel='stylesheet' type='text/css' href='css/inventory_dark.css'>";}
    } ?>
    <title>Treasure of Dragon Port</title>
</head>
<?php
if (isset($_POST["delete"])) {
    remove_from_inventory($_SESSION["username"], $_POST["item_num"], true);
    if (get_coins_by_owner($_SESSION["username"])[3] == $_POST["item_num"]) {
        remove_trade(get_coins_by_owner($_SESSION["username"])[0]);
    }
    header("Location: inventory.php");
}
?>
<style>
    table, th, td {
        border: 1px solid <?php if (get_dm_status() == 0) {echo "black";} else {echo "white";} ?>;
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
<body style="overflow-x: hidden">
<aside class="index_aside" style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".get_avatar_link($_SESSION["username"])."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

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
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div style="position: relative; left: 15%; width: calc(100vw - 15%);">

    <?php
    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

        $left = 0;
        $top = 0;

        for ($i = 0, $j = 1; $i < 47; $i++, $j++) {
            echo "<div style='width: 10vw; height: 10vw; position:absolute; left: ". $left ."vw; top: ". $top ."vh'>";
            echo "<img onmouseover='open_sidebar(this);' data-champion='".$champions[$i]."' onmouseout='close_sidebar();' id='image".$i."' style='width: 10vw;' src='". get_image_for_name($champions[$i]) . "'>";
            echo "<p id='name".$i."' style='position:absolute; bottom: 0; right: 12px; font-size: 20pt'>". get_inventory_2($_SESSION["username"])[$champions[$i]] ."</p>";
            echo "</div>";
            $left += 11;
            if ($i != 0 && $j % 6 == 0) {
                $top += 15;
                $left = 0;
            }
        }
    ?>
</div>

<div style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; position:fixed; right: 0; width: 15%; height: 100vh; top: 0; border-left: 1px solid <?php if (get_dm_status() == 0) { echo "black"; } else { echo "white"; } ?>; z-index: -50;">

<div id="champion_aside" style="<?php if (get_dm_status() == 0) { echo "background-color: lightgray";} else {echo "background-color:gray";}?>; opacity: 0; position:fixed; right: 0; width: 15%; height: 100vh; top: 0; border-left: 1px solid <?php if (get_dm_status() == 0) { echo "black"; } else { echo "white"; } ?>">
    <div style="width: 100%; height: 5vh; text-align: center;">
        <h2 id="champion_name" style="position:relative; font-size: 20px;">Champion Name</h2>
    </div>
    <img style="width: 10vw; position:absolute; left: calc(10vw / 2 - 15%)" alt="champion image" id="champion_info">
    <hr style="position:absolute; top: 25vh; width: 100%" />
    <div style="width: 100%; height: 5vh; text-align: center;">
        <h3 style="position:relative; top: 20vh;">Ritkaság:</h3>
        <h4 style="position:relative; top: 20vh;" id="rarity"></h4>
        <h3 style="position:relative; top: 20vh;">Kreditár:</h3>
        <div style="display: flex; position:absolute; top: 41vh; right: 47%">
            <img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png" style="position:relative; height: 20px;">
            <h4 style="position:absolute;" id="credit_price"></h4>
        </div>
        <!--<input type="submit" style="position:relative; top: 20vh;" id="sell" value="Eladás Kreditekért">-->
    </div>
</div>
<script src="scripts/inventory.js"></script>
</body>
</html>
