<?php
function select_image_by_rank() {
    $user_rank = get_rank();
    $sploded = explode(" ", $user_rank);

    switch ($sploded[0]) {
        case "Bronze":
            switch ($sploded[1]) {
                case "5":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/d/d0/RankIcon_Bronze_5.png";
                case "4":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/d/d2/RankIcon_Bronze_4.png";
                case "3":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/5/55/RankIcon_Bronze_3.png";
                case "2":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/5/5b/RankIcon_Bronze_2.png";
                case "1":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/6/6e/RankIcon_Bronze_1.png";
            }
        case "Silver":
            switch ($sploded[1]) {
                case "5":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/1/1c/RankIcon_Silver_5.png";
                case "4":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/1/13/RankIcon_Silver_4.png";
                case "3":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/9/95/RankIcon_Silver_3.png";
                case "2":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/7/77/RankIcon_Silver_2.png";
                case "1":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/1/17/RankIcon_Silver_1.png";
            }
        case "Gold":
            switch ($sploded[1]) {
                case "5":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/48/RankIcon_Gold_5.png";
                case "4":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/6/6d/RankIcon_Gold_4.png";
                case "3":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/1/12/RankIcon_Gold_3.png";
                case "2":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/2/21/RankIcon_Gold_2.png";
                case "1":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/ed/RankIcon_Gold_1.png";
            }
        case "Platinum":
            switch ($sploded[1]) {
                case "5":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/0/05/RankIcon_Platinum_5.png";
                case "4":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/e/e1/RankIcon_Platinum_4.png";
                case "3":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/3/3c/RankIcon_Platinum_3.png";
                case "2":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/9/9a/RankIcon_Platinum_2.png";
                case "1":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/c/c3/RankIcon_Platinum_1.png";
            }
        case "Diamond":
            switch ($sploded[1]) {
                case "5":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/0/03/RankIcon_Diamond_5.png";
                case "4":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/8/8a/RankIcon_Diamond_4.png";
                case "3":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/8/84/RankIcon_Diamond_3.png";
                case "2":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/4/4d/RankIcon_Diamond_2.png";
                case "1":
                    return "https://static.wikia.nocookie.net/paladins_gamepedia/images/f/f1/RankIcon_Diamond_1.png";
            }
        case "Master":
            return "https://static.wikia.nocookie.net/paladins_gamepedia/images/9/9c/RankIcon_Master.png";
        case "Grandmaster":
            return "https://static.wikia.nocookie.net/paladins_gamepedia/images/8/86/RankIcon_Grandmaster.png";
        case "Unranked":
            return "https://www.halberesford.com/content/images/2018/07/null.png";
        default:
            return "WTF NO GOOD";
    }

}
