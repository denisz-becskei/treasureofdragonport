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

<?php
    include "externalPHPfiles/userDAO.php";

    if (isset($_POST["submit_trade"])) {
        if (get_trade_amount() < 3 && intval(get_inventory_2($_SESSION["username"])[$_POST["to_trade"]]) > 0) {
            $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
                "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
                "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

            $to_trade = $_POST["to_trade"];
            $to_get = $_POST["to_get"];

            include "externalPHPfiles/trading_functionality.php";
            if (array_search($to_trade, $champions) && array_search($to_get, $champions)) {
                trade_init($_SESSION["username"], $to_trade, $to_get);
            }
        }
        header("Location: ongoing_trades.php");
    } else if (isset($_POST["submit_trade"]) && intval(get_inventory_2($_SESSION["username"])[$_POST["to_trade"]]) == 0) {
        initiate_violation($_SESSION["username"], "trying to add an impossible trade");
        header("Location: ongoing_trades.php");
    }

?>

<body style="overflow-y: hidden; overflow-x: hidden">
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
    echo "<div class='side_button'><a style='text-decoration: none;' href='feedback.php'>Visszajelzés</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push" style="height: 100vh;">
    <form action="new_trade.php" method="POST">
        <div style="width: 85%; height: 100vh; display: flex; flex-flow: column wrap; align-content: center; justify-content: center;">
            <div>
                <small>Érmét Adsz</small><br>
                <select name="to_trade">
                    <option disabled selected>--------</option>
                    <?php
                    $inventory = get_inventory_2($_SESSION["username"]);
                    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
                        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
                        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

                    for($i = 0; $i < 47; $i++) {
                        $champion = $champions[$i];
                        if ($champion == "Bomb_King")
                            $champion = "Bomb King";
                        else if ($champion == "MalDamba")
                            $champion = "Mal'Damba";
                        else if ($champion == "Sha_Lin")
                            $champion = "Sha Lin";
                        if ($inventory[$champions[$i]] == "0") {
                            echo "<option disabled>". $champion ."</option>";
                        } else {
                            echo "<option value='". $champions[$i] ."'>". $champion ."</option>";
                        }
                    }


                    ?>
                </select><br>
                <img <?php if (get_dm_status() == 1) { echo "src='assets/swap_icon_white.png'"; } else { echo "src='assets/swap_icon_black.png'"; } ?> style="width: 200px; position: relative; left: -50px;" alt="swap"><br>
                <small>Érmét Kérsz</small><br>
                <select name="to_get">
                    <option disabled selected>--------</option>
                    <?php
                    $inventory = get_inventory_2($_SESSION["username"]);
                    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb_King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
                        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha_Lin", "Skye",
                        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];

                    for($i = 0; $i < 47; $i++) {
                        $champion = $champions[$i];
                        if ($champion == "Bomb_King")
                            $champion = "Bomb King";
                        else if ($champion == "MalDamba")
                            $champion = "Mal'Damba";
                        else if ($champion == "Sha_Lin")
                            $champion = "Sha Lin";
                        echo "<option value='". $champions[$i] ."'>". $champion ."</option>";
                    }

                    ?>
                </select>
            </div><hr>
            <input style="position:relative; left: -60px;" type="submit" value="Cserére Bocsájtás" name="submit_trade">
        </div>

    </form>
</div>

</body>
<script src="scripts/preload.js"></script>
<script src="scripts/jquery-3.5.1.js"></script>
<script src="scripts/get_image.js"></script>
<script src="scripts/new_trade.js"></script>
<script>
</script>
</html>
