<?php

function is_champion($champion) {
    $champions = ["Androxus", "Ash", "Atlas", "Barik", "Bomb King", "Buck", "Cassie", "Corvus", "Dredge", "Drogoz", "Evie", "Fernando", "Furia", "Grohk", "Grover", "Imani",
        "Inara", "Io", "Jenos", "Khan", "Kinessa", "Koga", "Lex", "Lian", "Maeve", "Makoa", "MalDamba", "Moji", "Pip", "Raum", "Ruckus", "Seris", "Sha Lin", "Skye",
        "Strix", "Talus", "Terminus", "Tiberius", "Torvald", "Tyra", "Viktor", "Vivian", "Vora", "Willo", "Yagorath", "Ying", "Zhin"];
    foreach ($champions as $ch) {
        if ($ch == $champion) {
            return true;
        }
    }
    return false;
}

function get_rarity_by_champion($champion): string
{
    $legendary_array = ["Yagorath"];
    $epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
    $rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
    $uncommon_array = ["Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye"];

    $right_trimmed_champion = rtrim($champion);
    $champion = ltrim($right_trimmed_champion);

    if (in_array($champion, $legendary_array)) {
        return "&ltLegendás&gt";
    } elseif (in_array($champion, $epic_array)) {
        return "&ltEpikus&gt";
    } elseif (in_array($champion, $rare_array)) {
        return "&ltRitka&gt";
    } elseif (in_array($champion, $uncommon_array)) {
        return "&ltEgyedi&gt";
    } else {
        return "&ltGyakori&gt";
    }
}

function get_color_by_champion($champion): string
{
    $legendary_array = ["Yagorath"];
    $epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
    $rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
    $uncommon_array = ["Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye"];

    $right_trimmed_champion = rtrim($champion);
    $champion = ltrim($right_trimmed_champion);

    if (in_array($champion, $legendary_array)) {
        return "red";
    } elseif (in_array($champion, $epic_array)) {
        return "purple";
    } elseif (in_array($champion, $rare_array)) {
        return "blue";
    } elseif (in_array($champion, $uncommon_array)) {
        return "lime";
    } else {
        return "lightgray";
    }
}

function get_image_for_name($name): string
{
    switch ($name) {
        case "Androxus":
            return "https://i.imgur.com/zXlhJl6.png";
        case "Ash":
            return "https://i.imgur.com/2TAkWbp.png";
        case "Atlas":
            return "https://i.imgur.com/AaawF8b.png";
        case "Barik":
            return "https://i.imgur.com/4FR5Iae.png";
        case "Bomb King":
            return "https://i.imgur.com/g4B0GIf.png";
        case "Buck":
            return "https://i.imgur.com/NyG2GH8.png";
        case "Cassie":
            return "https://i.imgur.com/hXMEf0i.png";
        case "Corvus":
            return "https://i.imgur.com/krKI6Dl.png";
        case "Dredge":
            return "https://i.imgur.com/TpbEsaZ.png";
        case "Drogoz":
            return "https://i.imgur.com/iKmXPNH.png";
        case "Evie":
            return "https://i.imgur.com/YpnlfDa.png";
        case "Fernando":
            return "https://i.imgur.com/TCF680g.png";
        case "Furia":
            return "https://i.imgur.com/NhGXUFg.png";
        case "Grohk":
            return "https://i.imgur.com/MvWObyQ.png";
        case "Grover":
            return "https://i.imgur.com/Xiw8RKk.png";
        case "Imani":
            return "https://i.imgur.com/46S2XOx.png";
        case "Inara":
            return "https://i.imgur.com/eMZAhqR.png";
        case "Io":
            return "https://i.imgur.com/zgGGRzk.png";
        case "Jenos":
            return "https://i.imgur.com/sy4nGJ3.png";
        case "Khan":
            return "https://i.imgur.com/f6F3hTs.png";
        case "Kinessa":
            return "https://i.imgur.com/rgP3hd8.png";
        case "Koga":
            return "https://i.imgur.com/d1dWVnb.png";
        case "Lex":
            return "https://i.imgur.com/hD3SRE4.png";
        case "Lian":
            return "https://i.imgur.com/l9M3kan.png";
        case "Maeve":
            return "https://i.imgur.com/6hVU8Dh.png";
        case "Makoa":
            return "https://i.imgur.com/Ea1NmkK.png";
        case "Mal'Damba":
        case "MalDamba":
            return "https://i.imgur.com/ejPTOc9.png";
        case "Moji":
            return "https://i.imgur.com/x9APW4y.png";
        case "Pip":
            return "https://i.imgur.com/GK3o61U.png";
        case "Raum":
            return "https://i.imgur.com/izxlbLP.png";
        case "Ruckus":
            return "https://i.imgur.com/3L30iNI.png";
        case "Seris":
            return "https://i.imgur.com/aC8NZWv.png";
        case "Sha Lin":
            return "https://i.imgur.com/RaH2pvt.png";
        case "Skye":
            return "https://i.imgur.com/9nqqix3.png";
        case "Strix":
            return "https://i.imgur.com/gjOVtNj.png";
        case "Talus":
            return "https://i.imgur.com/nIDiqYV.png";
        case "Terminus":
            return "https://i.imgur.com/NTASjG2.png";
        case "Tiberius":
            return "https://i.imgur.com/nIyDcDt.png";
        case "Torvald":
            return "https://i.imgur.com/aK0Vuqk.png";
        case "Tyra":
            return "https://i.imgur.com/3Z8OGNA.png";
        case "Viktor":
            return "https://i.imgur.com/hJMSdFx.png";
        case "Vivian":
            return "https://i.imgur.com/55o2gDB.png";
        case "Vora":
            return "https://i.imgur.com/oIzayNY.png";
        case "Willo":
            return "https://i.imgur.com/xwR7B1e.png";
        case "Yagorath":
            return "https://i.imgur.com/kdJTjCe.png";
        case "Ying":
            return "https://i.imgur.com/GkNWB8i.png";
        case "Zhin":
            return "https://i.imgur.com/2OALEpQ.png";
        default:
            return "HOLD UP!";

    }
}