<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_COOKIE["spin-initiated"])) {
    setcookie("spin-initiated", false, time() + 86400);
}
include "db_connect.php";
include "externalPHPfiles/clear_data.php";
include "externalPHPfiles/championDAO.php";
clear_trades();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/inventory.css">

    <title>Treasure of Dragon Port</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body style="overflow-x: hidden">
<aside class="index_aside" style="background-color: lightgray; float: left; width: 15%; height: 100%; position: fixed; text-align: center; left: 0; top: 0";>

    <?php $avatars_coded = [0 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/eb/Avatar_Default_Icon.png", 6 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/27/Avatar_I_WUV_YOU_Icon.png", 2 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/b/bf/Avatar_Cutesy_Zhin_Icon.png", 3 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c7/Avatar_Ember_Icon.png", 4 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/a/a6/Avatar_Lily-hopper_Icon.png", 5 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/71/Avatar_Spirit_Icon.png", 1 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e4/Avatar_Death_Speaker_Icon.png", 7 => "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/47/Avatar_Beauty_in_Conflict_Icon.png"]; ?>
    <?php include "externalPHPfiles/userDAO.php"; include "externalPHPfiles/rank_selector.php";
    echo "<h1 style='font-size: 24pt'>".get_felhasznalonev()."</h1><img src='".$avatars_coded[get_avatar()]."' alt='avatar' style='height: 100px;'><h2 style='font-size: 16px;'>".get_ign()."<img alt='max_rank' src='".select_image_by_rank()."' style='width: 30px; position:absolute; top: 200px;'></h2><h2 style='font-size: 16px;'><img src='https://static.wikia.nocookie.net/paladins_gamepedia/images/b/b2/Currency_Credits.png' alt='credits' width='20px' style='position: relative; top: 2px;'>".get_credits()."  <img src='https://static.wikia.nocookie.net/realmroyale_gamepedia_en/images/e/e6/Currency_Crowns.png' alt='credits' width='20px' style='position: relative; top: 2px;'> ".get_coronia()."</h2>"; ?>

    <?php
    $is_admin = (get_status() == 1 || get_status() == 2) ? "<input style='color: red' type='submit' name='redir-admin' value='Admin Panel'>" : "";

    echo
    "<form action='inventory.php' method='POST'>
        <input type='submit' name='redir-index' value='Kezdőlap'>
        <input type='submit' name='redir-wheel' value='Szerencsekerék'>
        <input type='submit' name='redir-trading' value='Éremcsere'>
        <input type='submit' name='redir-inventory' value='Aranyzsák'>
        <input type='submit' name='redir-leaderboard' value='Ranglista'>
        <input type='submit' name='redir-achievements' value='Mérföldkövek'>";
    if ($is_admin != "") {
        echo $is_admin;
    }
    echo "<input type='submit' name='redir-settings' value='Beállítások'>
    </form>";

    if (isset($_POST["redir-index"])) {header("Location: index.php");}
    if (isset($_POST["redir-wheel"])) {header("Location: wheel.php");}
    if (isset($_POST["redir-trading"])) {header("Location: trading_actions.php");}
    if (isset($_POST["redir-inventory"])) {header("Location: inventory.php");}
    if (isset($_POST["redir-leaderboard"])) {header("Location: leaderboard.php");}
    if (isset($_POST["redir-achievements"])) {header("Location: achievements.php");}
    if (isset($_POST["redir-settings"])) {header("Location: settings.php");}
    if (isset($_POST["redir-admin"])) {header("Location: admin_panel.php");}
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <input type="submit" name="lgt-button" value="Kijelentkezés">
    </form>
    <?php
    if (isset($_POST["delete"])) {
        include "externalPHPfiles/inventory_selling.php";
        remove_from_inventory($_SESSION["username"], $_POST["item_num"], true);
        header("Location: inventory.php");
    }
    ?>

</aside>
<div style="position: relative; left: 15%;">
    <?php echo "<p style='position: absolute; top: 0; right: 15vw; font-size: 24px; text-align: center;'>Jelenlegi különböző<br> érméid száma: <br>".get_unique()." / 47</p>"?>
    <?php
    $inventory = explode(",", get_inventory());
    $champions = array();

    foreach ($inventory as $item) {
        array_push($champions, array("Hős" => $item, "Ritkaság" => get_rarity_by_champion($item)));
    }
    array_pop($champions);
    ?>

    <?php if (count($champions) > 0): ?>
        <table>
            <thead>
            <tr>
                <th class="inventory-title" style="width: 120px;">Érem</th>
                <th class="inventory-title"><?php echo implode('</th><th class="inventory-title">', array_keys(current($champions))); ?></th>
                <th class="inventory-title" style="width: 120px;">Műveletek</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0; $i < count($champions); $i++): array_map('htmlentities', $champions[$i]); ?>
                <tr style="height: 120px;">
                    <td class="inventory-items2" style="width: 120px;"><img
                                src="<?php echo get_image_for_name(ltrim(rtrim($inventory[$i]))) ?>" alt="item"
                                style="width: 120px;"></td>
                    <td class="inventory-items"
                        style="height: 120px;"><?php
                        if (get_rarity_by_champion(ltrim(rtrim($inventory[$i]))) == "&ltLegendás&gt") {
                            $color = "red";
                            $implosion = '</td><td class="inventory-items" style="color:' . $color . '">';
                        } elseif (get_rarity_by_champion(ltrim(rtrim($inventory[$i]))) == "&ltEpikus&gt") {
                            $color = "purple";
                            $implosion = '</td><td class="inventory-items" style="color:' . $color . '">';
                        } elseif (get_rarity_by_champion(ltrim(rtrim($inventory[$i]))) == "&ltRitka&gt") {
                            $color = "blue";
                            $implosion = '</td><td class="inventory-items" style="color:' . $color . '">';
                        } elseif (get_rarity_by_champion(ltrim(rtrim($inventory[$i]))) == "&ltEgyedi&gt") {
                            $color = "limegreen";
                            $implosion = '</td><td class="inventory-items" style="color:' . $color . '">';
                        } else {
                            $color = "gray";
                            $implosion = '</td><td class="inventory-items" style="color:' . $color . '">';
                        }
                        echo implode($implosion, $champions[$i]); ?></td>
                    <td class="inventory-items2" style="width: 120px;"><form action="inventory.php" method="POST">
                            <input hidden name="item_num" type="text" value="<?php echo $i;?>">
                            <input type="submit" name="delete" value="Eladás Kreditekért">
                        </form></td>
                </tr>
            <?php
            endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>



</div>

</body>
</html>
