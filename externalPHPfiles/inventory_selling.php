<?php

function array_unique_own($array) {
    $new_array = [];
    foreach ($array as $ar) {
        if (!array_search($ar, $new_array)) {
            if ($ar != "") {
                array_push($new_array, $ar);
            }
        }
    }
    return $new_array;
}

function remove_from_inventory($user, $item_num, $selling) {
    $number_to_delete = $item_num;

// | | |Tiberius| |Sha Lin| |Ash| |Grohk| | |

    $conn = OpenCon();
    $username = $user;

    $sql = "SELECT inventory FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    $original_inventory = explode(",", mysqli_fetch_array($result)[0]);

    $new_inventory_array = [];

    if ($selling) {
        $deleted_champion = get_rarity_by_champion($original_inventory[$number_to_delete]);
        if ($deleted_champion == "&ltGyakori&gt") {
            $credits_to_gib = 25;
        } elseif ($deleted_champion == "&ltEgyedi&gt") {
            $credits_to_gib = 50;
        } elseif ($deleted_champion == "&ltRitka&gt") {
            $credits_to_gib = 75;
        } elseif ($deleted_champion == "&ltEpikus&gt") {
            $credits_to_gib = 100;
        } else {
            $credits_to_gib = 150;
        }

        $sql = "SELECT credits FROM user WHERE username='$username'";
        $result = $conn->query($sql);
        $current_credits = mysqli_fetch_array($result)[0];
        $current_credits = strval($current_credits);
        $current_credits += $credits_to_gib;

        $sql = "UPDATE user SET credits = '$current_credits' WHERE username = '$username'";
        mysqli_query($conn, $sql);
    }

    unset($original_inventory[$number_to_delete]);


    foreach ($original_inventory as $oi) {
        if (isset($oi)) {
            array_push($new_inventory_array, $oi);
        }
    }
    $new_inventory = "";
    for($i = 0; $i < count($new_inventory_array)-1; $i++) {
        $new_inventory = $new_inventory . $new_inventory_array[$i] . ",";
    }

    $sql = "UPDATE user SET inventory = '$new_inventory' WHERE username = '$username'";
    mysqli_query($conn, $sql);


    $sql = "SELECT inventory FROM user WHERE username = '$username'";

    $result = $conn->query($sql);
    $result =  mysqli_fetch_array($result)[0];
    $champions = explode(",", $result);
    $unique_arr = array_unique_own($champions);
    $unique = count($unique_arr);

    $sql = "UPDATE user SET `unique` = '$unique' WHERE username = '$username'";
    mysqli_query($conn, $sql);

    CloseCon($conn);
}


