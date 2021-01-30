function getElement(id) {
    return document.getElementById(id);
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function get_image_for_name(name) {
    switch (name) {
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

    }
}

function createCookie(name, value) {
    document.cookie = escape(name) + "=" +
        escape(value) + "" + "; path=/";
}

function get_rarity_for_champion(champion) {
    let legendary = "Yagorath";
    let epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
    let rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
    let uncommon_array = ["Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye"];

    if (legendary === champion) {
        return "<Legendás>";
    } else if (epic_array.includes(champion)) {
        return "<Epikus>";
    } else if (rare_array.includes(champion)) {
        return "<Ritka>";
    } else if (uncommon_array.includes(champion)) {
        return "<Egyedi>";
    } else {
        return "<Gyakori>";
    }
}

let numberz = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
    30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58,
    59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87,
    88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100];

function shuffle() {
    let currentIndex = numberz.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = numberz[currentIndex];
        numberz[currentIndex] = numberz[randomIndex];
        numberz[randomIndex] = temporaryValue;
    }

    return numberz;
}

let done = false;

async function spin() {
    let random_array;
    if (localStorage.getItem("reserved") === "true") {
        let entire_array = ["Yagorath", "Vora", "Corvus", "Raum", "Tiberius", "Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus",
            "Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye",
            "Jenos", "Vivian", "Buck", "Seris", "Inara", "Grohk", "Viktor", "Cassie", "Lex", "Grover", "Ash", "Ruckus", "Fernando", "Barik", "Pip", "Moji", "Willo"];
        let final_coins = [];

        $.post("externalPHPfiles/add_coin.php");

        const item_image1 = getElement('item1');
        const item_image2 = getElement('item2');
        const item_image3 = getElement('item3');

        const item_name1 = getElement('item_name1');
        const item_name2 = getElement('item_name2');
        const item_name3 = getElement('item_name3');

        const item_rarity1 = getElement('item_rarity1');
        const item_rarity2 = getElement('item_rarity2');
        const item_rarity3 = getElement('item_rarity3');

        $.post("externalPHPfiles/get_spun.php", function(data, status){
            final_coins = data.split("|");
        });

        for (let i = 0; i < 13; i++) {
            let num1 = Math.floor(Math.random() * entire_array.length);
            let num2 = Math.floor(Math.random() * entire_array.length);
            let num3 = Math.floor(Math.random() * entire_array.length);

            item_image1.src = get_image_for_name(entire_array[num1]);
            item_image2.src = get_image_for_name(entire_array[num2]);
            item_image3.src = get_image_for_name(entire_array[num3]);

            item_name1.innerHTML = `${entire_array[num1]}`;
            item_name2.innerHTML = `${entire_array[num2]}`;
            item_name3.innerHTML = `${entire_array[num3]}`;

            let tick = getElement("ticking");
            tick.currentTime = 0;
            tick.play();

            if (i <= 2) {
                await sleep(500);
            } else if (i <= 8) {
                await sleep(250);
            } else if (i <= 10) {
                await sleep(500);
            } else {
                await sleep(1000);
            }
        }

        item_image1.src = get_image_for_name(final_coins[0]);
        item_image2.src = get_image_for_name(final_coins[1]);
        item_image3.src = get_image_for_name(final_coins[2]);

        item_name1.innerHTML = `${final_coins[0]}`;
        item_name2.innerHTML = `${final_coins[1]}`;
        item_name3.innerHTML = `${final_coins[2]}`;

        let ching = getElement("chinging");
        ching.currentTime = 0;
        ching.play();

        item_rarity1.hidden = false;
        item_rarity2.hidden = false;
        item_rarity3.hidden = false;
        item_rarity1.innerText = `${get_rarity_for_champion(final_coins[0])}`;
        item_rarity2.innerText = `${get_rarity_for_champion(final_coins[1])}`;
        item_rarity3.innerText = `${get_rarity_for_champion(final_coins[2])}`;
        if (get_rarity_for_champion(final_coins[0]) === "<Legendás>") {
            item_rarity1.style.color = "red";
        } else if (get_rarity_for_champion(final_coins[0]) === "<Gyakori>") {
            item_rarity1.style.color = "gray";
        } else if (get_rarity_for_champion(final_coins[0]) === "<Egyedi>") {
            item_rarity1.style.color = "limegreen";
        } else if (get_rarity_for_champion(final_coins[0]) === "<Ritka>") {
            item_rarity1.style.color = "blue";
        } else if (get_rarity_for_champion(final_coins[0]) === "<Epikus>") {
            item_rarity1.style.color = "purple";
        }

        if (get_rarity_for_champion(final_coins[1]) === "<Legendás>") {
            item_rarity2.style.color = "red";
        } else if (get_rarity_for_champion(final_coins[1]) === "<Gyakori>") {
            item_rarity2.style.color = "gray";
        } else if (get_rarity_for_champion(final_coins[1]) === "<Egyedi>") {
            item_rarity2.style.color = "limegreen";
        } else if (get_rarity_for_champion(final_coins[1]) === "<Ritka>") {
            item_rarity2.style.color = "blue";
        } else if (get_rarity_for_champion(final_coins[1]) === "<Epikus>") {
            item_rarity2.style.color = "purple";
        }

        if (get_rarity_for_champion(final_coins[2]) === "<Legendás>") {
            item_rarity3.style.color = "red";
        } else if (get_rarity_for_champion(final_coins[2]) === "<Gyakori>") {
            item_rarity3.style.color = "gray";
        } else if (get_rarity_for_champion(final_coins[2]) === "<Egyedi>") {
            item_rarity3.style.color = "limegreen";
        } else if (get_rarity_for_champion(final_coins[2]) === "<Ritka>") {
            item_rarity3.style.color = "blue";
        } else if (get_rarity_for_champion(final_coins[2]) === "<Epikus>") {
            item_rarity3.style.color = "purple";
        }

        $.post("externalPHPfiles/update_spun.php");

        const btn = getElement('back');
        btn.removeAttribute("hidden");
        localStorage.setItem("reserved", "false");
        done = true;
    }
}

setTimeout(function () {
    spin();
}, 1500);
