<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
include "db_connect.php";
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
} ?>; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php include "externalPHPfiles/userDAO.php";
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
    <table style="width: 85%; text-align: center;">
    <?php

    include "externalPHPfiles/championDAO.php";

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

        if (get_inventory_2($_SESSION["username"])[$row["coin_in_return"]] > 0 && $row["owned_by"] != $_SESSION["username"]) {
            $disabled_status = "";
        } else {
            $disabled_status = "disabled";
        }

        echo "<tr style='background-color: " . $color . "; width: 85%; height: 85px; position:relative; top: " . $top . "px; text-align: center;'>
<td style='width: 16%;'><img style='width: 80px; height: 80px' alt='champion' src='" . get_image_for_name(trim($row["coin"])) . "'><p style='color: ". get_color_by_champion($row["coin"]) ."'>" . modify_champion($row["coin"]) . "</p></td>
<td style='width: 16%'><img style='width: 80px; height: 80px' alt='champion_in_return' src='" . get_image_for_name(trim($row["coin_in_return"])) . "'><p style='color: ". get_color_by_champion($row["coin_in_return"]) ."'>" . modify_champion($row["coin_in_return"]) . "</p></td>
<td style='width: 16%;'><p id='owned".$i."'>" . $row["owned_by"] . "</p></td>
<td style='width: 16%;'><p>" . $row["posted_on"] . "</p></td>
<td style='width: 16%;'><img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' style='width: 20px; height: 20px; position:relative; top: 30px;' alt='cronia_value'><p style='position:relative; left: 20px; bottom: 7px;'>" . ' ' . $row["cronia_got"] . "</p></td>
<td style='width: 16%;'><form method='POST' action='ongoing_trades.php' style='display: flex; font-size: 20pt; position:relative; left: calc(50% - 25px); top: calc(50% - 12px);'>
                <input type='text' value='" . $row["coin_in_return"] . "' id='champion". $i . "' hidden name='number'>
                <input type='text' value='". $row["trade_code"] ."' hidden name='trade_code'>
                <input type='submit' ". $disabled_status ." value='Csere' id='btn". $i . "' name='btn'>
</form></td>
</tr>";
        $top += 20;
    }


    ?>
    </table>

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

    function get_index(champion) {
        let champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
            "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
            "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

        for (let i = 0; i < 47; i++) {
            if (champions[i] === champion) {
                return i;
            }
        }
        return null;
    }


    var inventory = "<?php echo implode('|', get_inventory())?>";
    inventory = inventory.split("|");
    inventory.pop();

    for (let i = 2; i < <?php echo get_trade_count() + 2; ?>; i++) {
        let btn = document.getElementById("btn" + i);
        let text = document.getElementById("champion" + i);

        for (let j = 0; j < inventory.length; j++) {
            if (inventory[get_index(text.value)] !== "0" && document.getElementById("owned" + i).innerText !== '<?php echo $_SESSION["username"]?>') {
                btn.removeAttribute("disabled");
                break;
            }
        }
    }
</script>
</html>
