<?php session_start();

if (isset($_POST["smt-button"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    include "../db_connect.php";

    $conn = OpenCon();


    $sql = "SELECT pass FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $hashedpass = mysqli_fetch_array($result)[0];

        $password = password_verify($password, $hashedpass);
    }

    if ($password == true) {
        $sql = "SELECT username FROM user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Welcome ". mysqli_fetch_array($result)[0];
            $_SESSION["username"] = $username;
            header("Location: ../index.php");
        } else {
            echo "Hibás felhasználónév vagy jelszó";
        }
    } else {
        echo "Hibás felhasználónév vagy jelszó";
    }
}

if (isset($_POST["smt-button2"])) {
    header("Location: ../register.php");
}


