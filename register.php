<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Treasure of Dragon Port</title>
</head>
<body>
    <div class="container2" style="height: 325px;">
        <form action="externalPHPfiles/register_functionality.php" method="POST">
            <br>
            <label for="username">Felhasználónév</label>
            <br>
            <input id="username" name="username" type="text" value="" required>
            <br>
            <label for="password">Jelszó</label>
            <br>
            <input id="password" type="password" name="password" value="" required>
            <br>
            <label for="password2">Jelszó újra</label>
            <br>
            <input id="password2" type="password" name="password2" value="" required>
            <br>
            <label for="email">E-mail cím (opcionális)</label>
            <br>
            <input id="email" type="text" name="email" value="">
            <br>
            <label for="ign">In-game név</label>
            <br>
            <input id="ign" type="text" name="ign" value="" required>
            <br>
            <label for="max_rank">Legmagasabb elért rankod</label>
            <br>
            <select id="max_rank" name="max_rank" required onchange="check_rank()">
                <option selected disabled>
                    Válassz egyet!
                </option>
                <option>
                    Bronze
                </option>
                <option>
                    Silver
                </option>
                <option>
                    Gold
                </option>
                <option>
                    Platinum
                </option>
                <option>
                    Diamond
                </option>
                <option>
                    Master
                </option>
                <option>
                    Grandmaster
                </option>
            </select>
            <select required style="width: 25px;" id="max_rank_2" name="max_rank_2">
                <option selected disabled>
                    Válassz egyet!
                </option>
                <option>
                    1
                </option>
                <option>
                    2
                </option>
                <option>
                    3
                </option>
                <option>
                    4
                </option>
                <option>
                    5
                </option>
            </select>
            <br>
            <input type="submit" name="smt_button" value="Regisztráció">
        </form>
        <form action="externalPHPfiles/register_functionality.php" method="GET">
            <input type="submit" name="smt_button4" value="Bejelentkezés">
        </form>

    </div>
<script src="scripts/register_scripts.js"></script>
</body>
</html>