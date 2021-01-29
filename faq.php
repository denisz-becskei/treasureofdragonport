<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_COOKIE["spin-initiated"]) || $_COOKIE["spin-initiated"] == "true") {
    setcookie("spin-initiated", "false", time() + 86400);
}
include "db_connect.php";
header('Content-type: text/html; charset=UTF-8');
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
    echo "<div class='side_button'><a style='text-decoration: none;' href='inventory.php'>Aranyzsák</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='ongoing_trades.php'>Éremcsere</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='signup.php'>Versenyre Jelentkezés</a></div>";
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
<div class="container_push" style="width: calc(100vw - 15% - 50px); height: calc(100vh - 15px);">
    <div hidden>
        <h1>Treasure of Dragon Port - A Sárkány-öböl Kincse</h1>
        <h3><i>Ruckus kapitány küldetést kapott Jenostól, hogy gyűjtse össze a Sárkány-öböl összes mágikus aranyérmét, amit az Őrzők a béke érdekében szórtak szét szerte
                a Birodalomban. Az érméken a bajnokok arcképei találhatóak, amikből ha összegyűlik az összes, Jenos képes lesz elűzni a közelgő sötétséget! Ruckus kapitány
                jutalom reményében elfogadta a küldetést, és legénységét elküldte különböző tájakra. Segítsd a kapitányt, szerezz érméket, cserélgesd őket a többi matrózzal,
                hogy neked legyen meg elsőként az összes érme!</i></h3>
        <p>Ez egy gyűjtögetős event, amely nagyban hasonlít híres trading-kártyajátékokra, mint például a Yi-Gu-Oh vagy a Pokémon.<br>Az event során érméket lehet gyűjteni,
        amelyeken a mindannyiunk által ismert és szeretett hősök arcképei találhatóak. Az event alatt egy szerencsekereket tudnak a játékosok megpörgetni, amely ad 3 random
        érmét. Minden érme különböző ritkaságú, amelyekről egy másik oldalon lehet olvasni.<br>Az event több szezonon át fog menni, mindegyik szezonban az első, aki összegyűjti
        az adott szezon összes érméjét kristályjutalomban részesül.<br>Viszont akkor sem éri meg a pörgetéseket abbahagyni, ha már megvan a szezon győztese, ugyanis <b>mindenki</b>,
        aki összegyűjti az <br>egész event összes érméjét az event végén egy valódi, kézzelfogható jutalomban fog részesülni.<br>Hogyan is szerezhetők ilyen pörgetések? Nos, egy
        Paladins meccsen pontok szerezhetők, pontfoglalásért... kocsibetolásért, stb. Így születik egy végső pontszám, például 4-1. Pörgetések ezek az eredmények alapján szerezhetők,
        azaz minden pontért <b>2 darab pörgetés jár</b>, amely a győztes csapat mindegyik tagjának 8 pörgetést jelent. <b>A PÖRGETÉSEK A SZEZON VÉGÉN NULLÁZÓDNAK.</b><br>Mire vársz még? Good luck, have fun! :D</p>
    </div>
    <div hidden>
        <h1>Érmék</h1>
        <p>Az eventen kapható érméken a hőseink arcképei láthatóak. Minden érmének van egy ritkasági szintje és ezek alapján egy ára, azaz a gyakori ritkaságú érmékért 25 kredit jár,
        az egyediekért 50, a ritkákért 75, az epikusokért 100 és végül a legendásokért 150. A hősök ritkaságait az alábbi képen lehet látni.</p>
        <img src="assets/rarities.png" style="width: calc(100vw - 15% - 150px);" alt="rarities">
        <p><b>Kreditek:</b> Az érmék eladhatók kreditekért. Ezekből a kreditekből (amennyiben az event szervezőbácsija úgy dönt hogy most nem lesz lusta és megcsinálja) a boltban
        lehet több dolgot is venni, többek között Discord címeket, illetve pörgetéseket, amelyek előnyt jelenthetnek az adott szezonban. <b>A SZEZON VÉGÉN A KREDITEK NULLÁZÓDNAK.</b><br>
        <b>Króniák:</b> Kreditekért megéri eladni a felesleges érméket, amikből több is van, viszont nem biztos, hogy ez egy jó döntés. Itt jönnek képbe a króniák. Króniákat éremcserékért
        lehet kapni, amelyek mennyisége cserénként egy bizonyos képlet alapján van meghatározva, amelyet most nem fogok leírni, mert lusta vagyok. Miért is éri ez meg, amely lehet, hogy
        más embernek előnyt ad a győzelem felé? Feljebb említésre került, hogy lesznek olyanok, akik minden érmét összegyűjtenek és ezért külön jutalmat kapnak. Az első szezon után az
        adott szezon érméi bekerülnek a vaultba, azaz többet egyszerű pörgetésekből <b>NEM LESZNEK MEGSZEREZHETŐEK</b>. Króniákból lehet majd venni a következő szezonok során előző
        szezonos pörgetéseket, amelyek segítenek abban, hogy amennyiben nem lett meg egy érme, az még pótolható legyen. Ezeknél a pörgetéseknél <b>MEGNÖVELT</b> eséllyel droppolnak a
        ritkább érmék is.</p>
    </div>
    <div>
        <h1>Csere</h1>
        <p></p>
    </div>
</div>
</body>
<script src="scripts/preload.js"></script>
</html>
