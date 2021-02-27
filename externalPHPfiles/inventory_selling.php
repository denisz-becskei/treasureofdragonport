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


