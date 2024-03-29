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
    <?php if (get_dm_status() == 0) { echo "<link rel='stylesheet' type='text/css' href='css/inventory.css'>";} else {echo "<link rel='stylesheet' type='text/css' href='css/inventory_dark.css'>";} ?>
    <title>Treasure of Dragon Port</title>
</head>

<style>
    .container_push {
        position: relative;
        left: 15%;
    }

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
    echo "<div class='side_button'><a style='text-decoration: none;' href='feedback.php'>Visszajelzés</a></div>";
    echo "<div class='side_button'><a style='text-decoration: none;' href='settings.php'>Beállítások</a></div>";
    ?>
    <form action="externalPHPfiles/logout_functionality.php" method="POST">
        <div class="side_button"><input style="background-color: transparent; border: none; padding: 0; margin: 0;" type="submit" name="lgt-button" class="logout" value="Kijelentkezés"></div>
    </form>

</aside>
<div class="container_push">
        <?php
        $conn = OpenCon();
        $sql = "SELECT avatar, username, `unique` FROM user ORDER BY `unique` DESC, username ASC";
        $result = mysqli_query($conn, $sql);

        ?>

        <table>
            <thead>
                <tr><th class="inventory-title" style="width: 72px;"></th><th class="inventory-title">Felhasználónév</th><th class="inventory-title">Különböző érmék száma</th></tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr style='height: 72px;'><td class='inventory-items2' style='width: 72px; height: 72px; text-align: center'><img alt='avatar' style='height: 74px;' src=". get_avatar_link($row["username"]) ."></td><td class='inventory-items2' style='height: 72px; width: calc(100vw/3);'>".$row["username"]."</td><td class='inventory-items2' style='height: 72px; width: calc(100vw/3);'>".$row["unique"]."</td></tr>";
                }
                ?>
            </tbody>
        </table>
</div>
</body>
</html>
