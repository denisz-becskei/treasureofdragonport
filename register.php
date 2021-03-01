<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="/assets/logo.png">
    <title>Treasure of Dragon Port</title>
</head>
<style>
    .margins * {
        margin-left: 5px;
    }
</style>
<body onload="loader();">
<canvas id="canvas" width="420px" height="420px" hidden style="position: absolute; left: calc(100vw / 2 - 420px / 2); top: calc(100vh / 2 - 420px / 2); background: white; border: 2px solid black; z-index: 5;"></canvas>
<div id="instructions" class="margins" style="opacity: 0; display: flex; width: 50vw; text-align: center; position:absolute; left: calc(100vw / 2 - 14vw); top: 10vh;"><p>Kattints egy </p><p style="color: green">ZÖLD </p><p> körre, majd egy </p><p style="color: red;">PIROS </p><p>négyzetre, amíg minden el nem tűnik!</p></div>
    <div class="container2" style="height: 420px;">
        <form action="externalPHPfiles/register_functionality.php" method="POST">
            <br>
            <label for="username">Felhasználónév</label><br>
            <p style="position:absolute; font-size: 8pt;">A felhasználóneved csakis számokat és az angol ábécé betűit tartalmazhatja!</p><br><br>
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
            <input id="email" type="email" name="email" value="">
            <br>
            <label for="ign">In-game név</label>
            <p style="position:absolute; font-size: 8pt;">A mező csakis számokat és az angol ábécé betűit tartalmazhatja! Amennyiben Paladinsban ékezetes az ign-ed, annélkül írd le!</p><br><br>
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
                    Unranked
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
            <select required style="width: 35px;" id="max_rank_2" name="max_rank_2">
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
            <button type="button" onclick="show_captcha();" id="not_robot">Bizonyítsd be, hogy nem vagy robot!</button>
            <input type="submit" name="smt_button" disabled id="register_btn" value="Regisztráció">
        </form>
        <form action="externalPHPfiles/register_functionality.php" method="GET">
            <input type="submit" name="smt_button4" value="Bejelentkezés">
        </form>

    </div>
<script src="scripts/register_scripts.js"></script>
<script src="scripts/captcha.js"></script>
<script>
    function show_captcha() {
        document.getElementById("canvas").removeAttribute("hidden");
        document.getElementById("instructions").style.opacity = "1";
    }
</script>
</body>
</html>