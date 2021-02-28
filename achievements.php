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
    <link rel="icon" href="/assets/logo.png">
    <?php include "externalPHPfiles/dark_mode_checker.php"; if (get_dm_status() == 0) { echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";} else {echo "<link rel='stylesheet' type='text/css' href='css/style_dark.css'>";} ?>

    <title>Treasure of Dragon Port</title>
</head>

<style>

    .container_push {
        position: relative;
        left: 15%;
    }

    body {
        overflow-x: hidden;
    }

    table, td {
        border: 1px solid <?php if (get_dm_status() == 0) {echo "black";} else {echo "white";} ?>;
        border-collapse: collapse;
        text-align: center;
        padding-top: 65px;
    }

    td {
        width: 250px;
    }

    .pics {
        width: 120px;
        position:relative;
        top: -40px;
    }

    .pics2 {
        height: 92px;
        position:relative;
        top: -40px;
    }

    p {
        position: relative;
        top: -40px;
    }

    .title {
        font-size: 14pt;
    }

    .desc {
        font-size: 12pt;
    }

    .grayscale {
        filter: grayscale(100%);
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
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
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
    <h1 style="position:relative; left: calc(50vw - 15%);">Mérföldkövek</h1>
    <table style="position: relative; left: 20vw;">
        <tbody>
        <?php include "externalPHPfiles/achievement_handler.php"; check_for_achievement_collection();?>
            <tr style="height: 120px;"><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c1/Card_Heave_Away.png" class="pics  <?php if (!get_achievement_status(1)) {echo "grayscale";} ?>" alt="Az első érme"><br><p class="title">Az első érme</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az első érméd!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b6/Card_Persistence.png" class="pics <?php if (!get_achievement_status(2)) {check_for_achievement(2); if (!get_achievement_status(2)) {echo "grayscale";}} ?>" alt="Rohanó arany"><p class="title">Rohanó arany</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes flank érmét!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e1/Card_Predator.png" class="pics <?php if (!get_achievement_status(3)) {check_for_achievement(3); if (!get_achievement_status(3)) {echo "grayscale";}} ?>" alt="Fájdalmas arany"><p class="title">Fájdalmas arany</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes damage érmét!</p></td></tr>
            <tr style="height: 120px;"><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c9/Card_Blood_Pact.png" class="pics  <?php if (!get_achievement_status(4)) {check_for_achievement(4); if (!get_achievement_status(4)) {echo "grayscale";}} ?>" alt="Gyógyító arany"><p class="title">Gyógyító arany</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes support érmét!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/6/61/Card_Last_Stand.png" style="padding-top: 15px;" class="pics <?php if (!get_achievement_status(5)) {check_for_achievement(5); if (!get_achievement_status(5)) {echo "grayscale";}} ?>" alt="Páncélozott arany"><p class="title">Páncélozott arany</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes frontline érmét!</p></td><td><img src="assets/beginner_collector.png" class="pics <?php if (!get_achievement_status(6)) {echo "grayscale";} ?>" alt="Kezdő gyűjtögető(1. szezon)"><p class="title">Kezdő gyűjtögető(1. szezon)</p><p class="desc" style="margin-bottom: -15px;">Szerezz meg 10 különböző érmét!</p></td></tr>
            <tr style="height: 120px;"><td><img src="assets/routine_collector.png" class="pics  <?php if (!get_achievement_status(7)) {echo "grayscale";} ?>" alt="Rutin gyűjtögető(1. szezon)"><p class="title">Rutin gyűjtögető(1. szezon)</p><p class="desc" style="margin-bottom: -15px;">Szerezz meg 20 különböző érmét!</p></td><td><img src="assets/advanced_collector.png" class="pics <?php if (!get_achievement_status(8)) {echo "grayscale";} ?>" alt="Haladó gyűjtögető(1. szezon)"><p class="title">Haladó gyűjtögető(1. szezon)</p><p class="desc" style="margin-bottom: -15px;">Szerezz meg 30 különböző érmét!</p></td><td><img src="assets/veteran_collector.png" class="pics <?php if (!get_achievement_status(9)) {echo "grayscale";} ?>" alt="Veterán gyűjtögető(1. szezon)"><p class="title">Veterán gyűjtögető(1. szezon)</p><p class="desc" style="margin-bottom: -15px;">Szerezz meg 40 különböző érmét!</p></td></tr>
            <tr style="height: 120px;"><td><img src="assets/full_collection.png" class="pics  <?php if (!get_achievement_status(10)) {echo "grayscale";} ?>" alt="Teljes kollekció(1. szezon)"><p class="title">Teljes kollekció(1. szezon)</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg a teljes kollekciót!</p></td><td><img src="https://preview.redd.it/4rdhhqf76qq51.jpg?width=400&format=pjpg&auto=webp&s=1d97fc31e921728ffaf86b32e34b9a32aa90bdb5" class="pics2 <?php if (!get_achievement_status(11)) {check_for_achievement(11);} if (!get_achievement_status(11)) { {echo "grayscale";} } ?>" alt="LEGENDÁS!"><p class="title">LEGENDÁS!</p><p class="desc" style="margin-bottom: -15px;">Szerezz meg 1 Legendás érmét!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/8/8e/Card_Spitfire.png" class="pics <?php if (!get_achievement_status(12)) {check_for_achievement(12); if (!get_achievement_status(12)) {echo "grayscale";}} ?>" alt="Bumm-bumm!"><p class="title">Bumm-bumm!</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes Blaster érmét!</p></td></tr>
            <tr style="height: 120px;"><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/2/21/Card_Bandolier.png" class="pics   <?php if (!get_achievement_status(13)) {check_for_achievement(13); if (!get_achievement_status(13)) {echo "grayscale";}} ?>" <?php if (get_achievement_status(13)) {echo "style='padding-top: 15px;'";} ?> alt="Bal-klikk goes brrr"><p class="title">Bal-klikk goes brrr</p><p class="desc" style="margin-bottom: -15px;"><?php if (get_achievement_status(13)) {echo "Ezekkel is csak a bal klikket kell nyomni...";} else {echo "???";} ?></p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/9/92/Card_Through_the_Warp.png" class="pics <?php if (!get_achievement_status(14)) {check_for_achievement(14); if (!get_achievement_status(14)) {echo "grayscale";}} ?>" alt="Mobilis csapás"><p class="title">Mobilis csapás</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg a legmobilisabb érméket!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/5/5e/Card_Tidal_Grace.png" class="pics <?php if (!get_achievement_status(15)) {echo "grayscale";} ?>" alt="Nagy szejelem"><p class="title">Nagy szejelem</p><p class="desc" style="margin-bottom: -15px;"><?php if (get_achievement_status(15)) {echo "Rakd fel a SZEJETLEK avatárt!";} else {echo "???";} ?></p></td></tr>
            <tr style="height: 120px;"><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/4/4b/Resistance.png" class="pics2  <?php if (!get_achievement_status(16)) {check_for_achievement(16); if (!get_achievement_status(16)) {echo "grayscale";}} ?>" style="padding-top: 15px;" alt="Az Ellenállás tagja"><p class="title">Az Ellenállás tagja</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes Ellenállás érmét!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/5/5a/Magistrate.png" class="pics2 <?php if (!get_achievement_status(17)) {check_for_achievement(17); if (!get_achievement_status(17)) {echo "grayscale";}} ?>" alt="A Bírák tagja"><p class="title">A Bírák tagja</p><p class="desc" style="margin-bottom: -15px;">Szerezd meg az összes Bírák érmét!</p></td><td><img src="https://static.wikia.nocookie.net/paladins_gamepedia/images/1/16/Card_Inertia.png" class="pics <?php if (!get_achievement_status(18)) { check_for_infinity_spark(); } if (!get_achievement_status(18)) {echo "grayscale";} ?>" alt="Végtelen szikra"><p class="title">Végtelen szikra</p><p class="desc" style="margin-bottom: -15px;"><?php if (get_achievement_status(18)) {echo "Teljesítsd az összes mérföldkövet!";} else {echo "???";} ?></p></td></tr>
        </tbody>
    </table>
</div>
</body>
</html>
