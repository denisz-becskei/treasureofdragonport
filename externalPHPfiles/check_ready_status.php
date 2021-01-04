<?php
$conn = OpenCon();
$username = $_SESSION["username"];
if (is_trader($username)) {
    $code = find_code_by_trader($username);
} else {
    $code = find_code_by_tradee($username);
}

$sql = "SELECT trader_ready, tradee_ready FROM active_trades WHERE trade_code = '$code'";
$result = $conn->query($sql);
$result = mysqli_fetch_array($result);
if ($result["trader_ready"] == 1 && $result["tradee_ready"] == 1) {
    swap();
    header("Location: ../inventory.php");
}

CloseCon($conn);
header("Location: ../finish_trade.php");
