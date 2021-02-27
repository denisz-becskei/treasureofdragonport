for (let i = 0; i < 47; i++) {
    if (document.getElementById("name"+i).innerText === "0") {
        document.getElementById("image"+i).style.opacity = "0.4";
    }
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

function open_sidebar(image) {
    let opacity_double = parseFloat(document.getElementById("champion_aside").style.opacity);
    document.getElementById("champion_info").src = image.src;
    //document.getElementById("champion_name").innerText = image.dataset.champion === "MalDamba" ? "Mal'Damba" : image.dataset.champion;

    if (image.dataset.champion === "MalDamba") {
        document.getElementById("champion_name").innerText = "Mal'Damba";
    } else if (image.dataset.champion === "Bomb_King") {
        document.getElementById("champion_name").innerText = "Bomb King";
    } else if (image.dataset.champion === "Sha_Lin") {
        document.getElementById("champion_name").innerText = "Sha Lin";
    } else {
        document.getElementById("champion_name").innerText = image.dataset.champion;
    }

    document.getElementById("rarity").innerText = get_rarity_for_champion(image.dataset.champion);
    let color;
    let price;
    switch (document.getElementById("rarity").innerText) {
        case "<Legendás>":
            color = "red";
            price = "150";
            break;
        case "<Epikus>":
            color = "purple";
            price = "100";
            break;
        case "<Ritka>":
            color = "blue";
            price = "75";
            break;
        case "<Egyedi>":
            color = "lime";
            price = "50";
            break;
        default:
            color = "white";
            price = "25";
    }
    document.getElementById("rarity").style.color = color;
    document.getElementById("credit_price").innerText = price;

    let interv = setInterval(function () {
        if(opacity_double < 1) {
            opacity_double += 0.15;
            document.getElementById("champion_aside").style.opacity = opacity_double.toString();
        } else {
            clearInterval(interv);
        }
    }, 1000/30);
}

function close_sidebar() {
    document.getElementById("champion_aside").style.opacity = "0";
}