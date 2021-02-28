<?php
session_start();
include "db_connect.php";
include "externalPHPfiles/userDAO.php";
include "externalPHPfiles/update_new_inventory.php";
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (get_status() != 1 && get_status() != 2) {
    header("Location: index.php");
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
    .container_push {
        position: relative;
        left: 15%;
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
<body style="overflow-y: hidden; overflow-x: hidden;">
<?php
include "externalPHPfiles/achievement_handler.php";

if (isset($_POST["modification-btn"])) {
    $user_to_edit = $_POST["user_editing"];
    $spins_to_add = $_POST["add_spins"];
    $spins_to_subtract = $_POST["subtract_spins"];
    $set_credits = $_POST["set_credits"];
    $complete_achievement = $_POST["complete_achievement"];
    $uncomplete_achievement = $_POST["uncomplete_achievement"];
    $post_news = $_POST["post_news"];
    $add_coin = $_POST["add_coin"];
    $remove_coin = $_POST["remove_coin"];

    $editing_data = [false, false, false, false, false, false, false, false, false];
    $status_to_give = 0;

    if ($spins_to_add != "") {
        $editing_data[0] = true;
    }
    if ($spins_to_subtract != "") {
        $editing_data[1] = true;
    }
    if (isset($_POST["change_status"])) {
        if (isset($_POST["grant_status"])) {
            $status_to_give = 1;
        } else {
            $status_to_give = 0;
        }
        $editing_data[2] = true;
    }
    if ($set_credits != "") {
        $editing_data[3] = true;
    }

    if ($complete_achievement != "") {
        $editing_data[4] = true;
    }

    if ($uncomplete_achievement != "") {
        $editing_data[5] = true;
    }

    if ($post_news != "") {
        $editing_data[6] = true;
    }

    if ($add_coin != "") {
        $editing_data[7] = true;
    }

    if ($remove_coin != "") {
        $editing_data[8] = true;
    }

    $conn = OpenCon();

    if ($editing_data[0]) {
        $sql = "SELECT wheelturns FROM user WHERE username = '$user_to_edit'";
        $result = $conn->query($sql);
        $spins_currently = mysqli_fetch_array($result)[0];
        $spins_currently += $spins_to_add;
        $sql = "UPDATE user SET wheelturns = '$spins_currently' WHERE username = '$user_to_edit'";
        mysqli_query($conn, $sql);
    }
    if ($editing_data[1]) {
        $sql = "SELECT wheelturns FROM user WHERE username = '$user_to_edit'";
        $result = $conn->query($sql);
        $spins_currently = mysqli_fetch_array($result)[0];
        $spins_currently = strval($spins_currently);
        $spins_currently -= $spins_to_subtract;
        if ($spins_currently < 0) {
            $spins_currently = 0;
        }
        $sql = "UPDATE user SET wheelturns = '$spins_currently' WHERE username = '$user_to_edit'";
        mysqli_query($conn, $sql);
    }
    if ($editing_data[2]) {
        $sql = "SELECT user_status FROM user WHERE username = '$user_to_edit'";
        $result = $conn->query($sql);
        $current_status = mysqli_fetch_array($result)[0];

        if ($current_status != 2) {
            $sql = "UPDATE user SET user_status = '$status_to_give' WHERE username = '$user_to_edit'";
            mysqli_query($conn, $sql);
        } else {
            echo "<p style='position:absolute; top: 650px; left: calc(100vw / 2 - 100px)'>Hé, nem bántani azt a felhasználót :c</p>";
        }
    }
    if ($editing_data[3]) {
        $sql = "UPDATE user SET credits = '$set_credits' WHERE username = '$user_to_edit'";
        mysqli_query($conn, $sql);
    }
    if ($editing_data[4]) {
        complete_achievement($user_to_edit, $complete_achievement);
    }
    if ($editing_data[5]) {
        uncomplete_achievement($user_to_edit, $uncomplete_achievement);
    }
    if ($editing_data[6]) {
        include "externalPHPfiles/news.php";
        add_news($post_news);
    }
    if ($editing_data[7]) {
        add_champion($user_to_edit, $add_coin);
    }
    if ($editing_data[8]) {
        remove_champion($user_to_edit, $remove_coin);
    }
    CloseCon($conn);
}

include "externalPHPfiles/event_handler.php";
if (isset($_POST["event1"])) {
    change_event_status("Mix League");
}
if (isset($_POST["event2"])) {
    change_event_status("Warriors of Hungary");
}
if (isset($_POST["event1_del"]) && isset($_POST["event1_del_check"])) {
    delete_players(1);
}
if (isset($_POST["event2_del"]) && isset($_POST["event2_del_check"])) {
    delete_players(2);
}


if (isset($_POST["data"])) {
    if ($_POST["felh_username"] != "") {
        header("Location: data.php?user=".$_POST["felh_username"]."&mode=user");
    }
}

if (isset($_POST["data_2"])) {
    if ($_POST["event"] != "") {
        header("Location: data.php?event_name=".$_POST["event"]."&mode=event");
    }
}

if (isset($_POST["data_3"])) {
    header("Location: data.php?mode=shark");
}

if (isset($_POST["data_4"])) {
    header("Location: data.php?mode=generate");
}

?>
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
    <form action="admin_panel.php" method="POST">
        <fieldset>
            <legend>Felhasználókezelés</legend>
            <label for="user_editing">Módosítandó felhasználó neve:</label>
            <input id="user_editing" name="user_editing" type="text" required>
            <br><br>
            <label for="add_spins">Pörgetés hozzáadása:</label>
            <input id="add_spins" name="add_spins" type="text">
            <br>
            <label for="subtract_spins">Pörgetés levonása:</label>
            <input id="subtract_spins" name="subtract_spins" type="text">
            <br>
            <label for="grant_status">Admin státusz módosítása:</label>
            <input id="grant_status" name="change_status" value="Módosítandó" type="checkbox">
            <input name="grant_status" value="Státusz" type="checkbox">
            <br>
            <label for="set_credits">Kreditek állítása:</label>
            <input name="set_credits" id="set_credits" type="text">
            <br>
            <label for="complete_achievement">Mérföldkő teljesítése:</label>
            <input name="complete_achievement" id="complete_achievement" type="text">
            <br>
            <label for="uncomplete_achievement">Mérföldkő törlése:</label>
            <input name="uncomplete_achievement" id="uncomplete_achievement" type="text">
            <br>
            <label for="post_news">Hír közzététele:</label>
            <input name="post_news" id="post_news" type="text">
            <br>
            <label for="add_coin">Érme hozzáadása:</label>
            <input name="add_coin" id="add_coin" type="text">
            <br>
            <label for="add_coin">Érme levonása:</label>
            <input name="remove_coin" id="remove_coin" type="text">
            <br>
            <input type="submit" name="modification-btn" value="Módosítások elvégzése">
        </fieldset>
    </form>
    <form action="admin_panel.php" method="POST">
        <fieldset>
            <legend>Eventkezelés</legend>
            <fieldset>
                <legend>Event státuszmódosítás</legend>
                <input type="submit" name="event1" value="Mix League Státusz Módosítása"><br>
                <input type="submit" name="event2" value="Warriors of Hungary Státusz Módosítása">
            </fieldset>
            <fieldset>
                <legend>Heti jelentkezett játékosok törlése</legend>
                <input type="checkbox" name="event1_del_check"><input type="submit" name="event1_del" value="Mix League Jelentkezettek Törlése"><br>
                <input type="checkbox" name="event2_del_check"><input type="submit" name="event2_del" value="Warriors of Hungary Jelentkezettek Törlése">
            </fieldset>
        </fieldset>
    </form>
    <form action="admin_panel.php" method="POST">
        <fieldset>
            <legend>Információ lekérdezés</legend>
            <fieldset>
                <legend>Felhasználó adatainak lekérése</legend>
                <input type="text" name="felh_username" placeholder="Felhasználó">
                <input type="submit" value="Adatlekérés" name="data">
            </fieldset>
            <fieldset>
                <legend>Event adatainak lekérése</legend>
                <input type="text" name="event" placeholder="Event">
                <input type="submit" value="Adatlekérés" name="data_2">
            </fieldset>
            <fieldset>
                <legend>S.H.A.R.K. adatainak lekérése</legend>
                <input type="submit" value="Adatlekérés" name="data_3">
            </fieldset>
            <fieldset>
                <legend>Event csapat generálás</legend>
                <input type="submit" value="Generálás" name="data_4">
            </fieldset>
        </fieldset>
    </form>
</div>

</body>
</html>
