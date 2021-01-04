<?php

function clear_trades() {
    $conn = OpenCon();

    $username = $_SESSION["username"];

    $sql = "DELETE FROM active_trades WHERE trader = '$username'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM active_trades WHERE tradee = '$username'";
    mysqli_query($conn, $sql);
    CloseCon($conn);
    setcookie("trade-initiated", false);
    setcookie("trader", false);
    setcookie("tradee", false);
    setcookie("trade-code", null);
}
