<?php
session_start();
include "../db_connect.php";

function checkNames($username) {
    $conn = OpenCon();

    $sql = "SELECT username FROM user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        for ($i = 0; $i < $result->num_rows; $i++) {
            if ($username == mysqli_fetch_array($result)[$i]) {
                return false;
            }
        }
    }
    CloseCon($conn);
    return true;
}

if (isset($_POST["smt_button"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    $ign = $_POST["ign"];
    $max_rank = $_POST["max_rank"];


    if (isset($_POST["max_rank2"])) {
        $max_rank_2 = $_POST["max_rank_2"];
        $max = $max_rank . " " . $max_rank_2;
    } else {
        $max = $max_rank;
    }

    $conn = OpenCon();

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if (checkNames($username) && strlen($password) >= 6 && $password == $password2) {
        $sql = "INSERT INTO user(username, pass, email, ign, max_rank, user_status, inventory, wheelturns, credits, coronia, avatar, `unique`, achievements) VALUES ('$username', '$password_hash', '$email', '$ign', '$max', 0, '', 0, 0, 0, 0, 0, 'X,X,X,X,X,X,X,X,X,X,X,X,X,X,X,X,X,X')";

        if (mysqli_query($conn, $sql)) {
            echo "ADDED record to DB";
        }

        CloseCon($conn);

        header("Location: ../login.php");
        echo "Sikeres regisztráció";
    } elseif (!checkNames($username)) {
        echo "A felhasználónév foglalt!";
        echo "<form action='register_functionality.php' method='GET'><input name='smt-button3' type='submit' value='Vissza'></form>";
    } elseif ($password < 6) {
        echo "A jelszó nem tartalmaz legalább 6 karaktert!";
        echo "<form action='register_functionality.php' method='GET'><input name='smt-button3' type='submit' value='Vissza'></form>";
    } elseif ($password == $password2) {
        echo "A két jelszó nem egyezik meg!";
        echo "<form action='register_functionality.php' method='GET'><input name='smt-button3' type='submit' value='Vissza'></form>";
    }
}

if (isset($_GET["smt-button3"])) {
    header("Location: ../register.php");
}

if (isset($_GET["smt_button4"])) {
    header("Location: ../login.php");
}

