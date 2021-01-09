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
    .side_button {
        border: 1px solid black;
        width: calc(100% - 2px);
    }

    .side_button:hover {
        background-color: white;
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

<body style="overflow-y: hidden; overflow-x: hidden">
<aside class="index_aside" style="background-color: lightgray; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0; overflow-y: scroll">
    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"];?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<div class='side_button'><a style='text-decoration: none; color: red;' href='admin_panel.php'>Admin Panel</a></div>" : "";

    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='index.php'>Kezdőlap</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='wheel.php'>Szerencsekerék</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='trading_actions.php'>Éremcsere</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='leaderboard.php'>Ranglista</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='achievements.php'>Mérföldkövek</a></div>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<div class='side_button'><a style='text-decoration: none; color: black;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push">
    <div style="position:relative; left: 400px; top: 175px; width: 720px; height: 512px; background-image: url('assets/trading-bg.png'); color: white">
        <h2 style="position:relative; left: 300px; top: 50px;">Éremcsere</h2>
        <form style="position:relative; left: 0; top: 130px; text-align: center;" action="initiated_trade.php" method="POST">
            <select name="coins">
                <?php
                include "externalPHPfiles/trading_functionality.php";
                    $conn = OpenCon();
                    $username = $_SESSION["username"];
                    $sql = "SELECT inventory FROM user WHERE username = '$username'";
                    $result = $conn->query($sql);
                    $inventory = explode(",", mysqli_fetch_array($result)[0]);
                    $index = 0;
                    foreach ($inventory as $i) {
                        $i = ltrim(rtrim($i));
                    }
                    foreach ($inventory as $i) {
                        if ($i == "" || $i == " ") {
                            continue;
                        }
                        echo "<option value='$index'>".$i."</option>";
                        $index++;
                    }
                    CloseCon($conn);
                ?>
            </select><br>
            <input type="submit" name="submit_coin" value="Cserére rakás">
        </form>
    </div>
</div>
<?php
if (isset($_POST["submit_coin"])) {
    if (is_trader($_SESSION["username"])) {
        set_coin("trader", $_POST["coins"]);
        header("Location: finish_trade.php");
    } else if (is_tradee($_SESSION["username"])) {
        set_coin("tradee", $_POST["coins"]);
        header("Location: finish_trade.php");
    } else {
        header("Location: index.php");
    }
}
?>
</body>
</html>
