<?php
session_start();

$_SESSION["username"] = null;
$_SESSION = null;
session_destroy();
header("Location: ../login.php");