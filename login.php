<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
if (!isset($_COOKIE["darkmode"])) {
    setcookie("darkmode", false, time() + 86400);
}
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
<body>
    <div class="container">
        <h1 style="position: relative; bottom: 140px;">Treasure of Dragon Port</h1>
        <form style="position: relative; bottom: 120px;" action="externalPHPfiles/login_functionality.php" method="POST">
            <br>
            <label for="username">Felhasználónév
            <br>
            <input name="username" type="text" value="" required></label>
            <br>
            <label for="password">Jelszó
            <br>
            <input type="password" name="password" value="" required></label>
            <br>
            <input type="submit" name="smt-button" value="Bejelentkezés"><br>
        </form>
        <form style="position: relative; bottom: 120px;" action="externalPHPfiles/login_functionality.php" method="POST">
            <input type="submit" name="smt-button2" value="Regisztráció">
        </form>

    </div>
</body>
</html>