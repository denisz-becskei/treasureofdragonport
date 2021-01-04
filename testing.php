<?php
session_start();

include "db_connect.php";
include "externalPHPfiles/trading_functionality.php";

echo insert_code();
