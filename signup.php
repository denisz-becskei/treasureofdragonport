<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include "db_connect.php";
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/event_handler.php";
include "externalPHPfiles/S.H.A.R.K.php";

if (isset($_POST["signup_1"]) && is_open("Mix League")) {
    signup(1);
    header("Location: signup.php");
} elseif (isset($_POST["signup_1"]) && !is_open("Mix League")) {
    initiate_violation($_SESSION["username"], "attempting signup to a closed event");
    header("Location: signup.php");
}
if (isset($_POST["signup_2"]) && is_open("Warriors of Hungary")) {
    signup(2);
    header("Location: signup.php");
} elseif (isset($_POST["signup_2"]) && !is_open("Warriors of Hungary")) {
    initiate_violation($_SESSION["username"], "attempting signup to a closed event");
    header("Location: signup.php");
}
if (isset($_POST["signoff_1"]) && is_open("Mix League")) {
    signoff(1);
    header("Location: signup.php");
} elseif (isset($_POST["signoff_1"]) && !is_open("Mix League")) {
    initiate_violation($_SESSION["username"], "attempting signoff to a closed event");
    header("Location: signup.php");
}
if (isset($_POST["signoff_2"]) && is_open("Warriors of Hungary")) {
    signoff(2);
    header("Location: signup.php");
} elseif (isset($_POST["signoff_2"]) && !is_open("Warriors of Hungary")) {
    initiate_violation($_SESSION["username"], "attempting signoff to a closed event");
    header("Location: signup.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    .logout {
        height: 62px;
    }
</style>
<body style="overflow-y: hidden; overflow-x: hidden;">
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
<div class="container_push">
    <h1 style="position: absolute; left: calc(100vw / 2 - 15vw);">Meghirdetett versenyek</h1>
    <div style="position:relative; left: calc(15% - 10vw); top: calc(100vh / 2  - 35vh);">
        <img src="assets/ml_splash.jpg" alt="mix league" style="height: 35vh;"><h3 style="position:absolute; left: 35vw; top: 12vh;">Mix League</h3><?php if (!is_open("Mix League")) { echo "<h4 style='position:absolute; left: 35vw; top: 15vh; font-style: italic;'>Jelentkezés nincs megnyitva</h4><br>"; } ?>

        <form method="POST" action="signup.php">
            <input type="submit" name="<?php if(!is_signed_up(1, $_SESSION["username"])) { echo "signup_1";} else { echo "signoff_1"; } ?>" value="<?php if(!is_signed_up(1, $_SESSION["username"])) { echo "Jelentkezés";} else { echo "Lejelentkezés"; } ?>" <?php if (!is_open("Mix League")) { echo "disabled"; } ?> style="position:absolute; background-color: transparent; border: none; left: 50vw; top: 15vh; <?php if(get_dm_status() == 0 && is_open("Mix League")) { echo "color: black"; } else if (get_dm_status() == 1 && is_open("Mix League")) { echo "color: white"; } else { echo "color: gray"; } ?>">
            <input type="submit" name="<?php if(!is_signed_up(1, $_SESSION["username"])) { echo "signup_2";} else { echo "signoff_2"; } ?>" value="<?php if(!is_signed_up(2, $_SESSION["username"])) { echo "Jelentkezés";} else { echo "Lejelentkezés"; } ?>" <?php if (!is_open("Warriors of Hungary")) { echo "disabled"; } ?> style="position:absolute; background-color: transparent; border: none; left: 50vw; top: 53vh; <?php if(get_dm_status() == 0 && is_open("Warriors of Hungary")) { echo "color: black"; } else if (get_dm_status() == 1 && is_open("Warriors of Hungary")) { echo "color: white"; } else { echo "color: gray";  } ?>">
        </form>

        <hr style="width: 65vw; position:relative; left: -17vw;"/>
        <img src="assets/woh_splash.png" alt="warriors of hungary" style="height: 35vh;"><h3 style="position:absolute; left: 35vw; top: 50vh;">Warriors of Hungary</h3><?php if (!is_open("Warriors of Hungary")) { echo "<h4 style='position:absolute; left: 35vw; top: 53vh; font-style: italic;'>Jelentkezés nincs megnyitva</h4>"; } ?>
    </div>
</div>
</body>
<script src="scripts/register_scripts.js"></script>
</html>
