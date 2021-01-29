function check() {
    document.getElementById("inv").style.opacity = "0";
    document.getElementById("collection").style.opacity = "0";
    if (document.getElementById("champion").value === document.getElementById("champion2").value || document.getElementById("champion").value === "" || document.getElementById("champion2").value === "") {
        document.getElementById("lock").setAttribute("disabled", "");
    } else {
        document.getElementById("lock").removeAttribute("disabled");
    }
}

let entire_array = ["", "Yagorath", "Vora", "Corvus", "Raum", "Tiberius", "Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus",
    "Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye",
    "Jenos", "Vivian", "Buck", "Seris", "Inara", "Grohk", "Viktor", "Cassie", "Lex", "Grover", "Ash", "Ruckus", "Fernando", "Barik", "Pip", "Moji", "Willo"];
entire_array.sort();

let inventory = document.getElementById("inventory").innerText;
let inventory_int = [];
let inventory_broken = inventory.split("|");
inventory_broken.pop();

for (let i = 0; i < inventory.length; i++) {
    inventory_int.push(parseInt(inventory_broken[i]));
}
let what_we_have = [""];
let what_we_have_amount = [0];
for (let i = 0; i < inventory_broken.length; i++) {

    if (inventory_int[i] !== 0) {
        what_we_have.push(entire_array[i+1]);
        what_we_have_amount.push(inventory_int[i]);
    }
}

what_we_have.sort();

let i = 1;
let j = 1;
function generate_images() {
    let inventoryDiv = document.getElementById("inv");
    let collectionDiv = document.getElementById("collection");
    const SIZE = 125;
    let image1 = new Image(SIZE, SIZE);
    let image2 = new Image(SIZE, SIZE);
    let image3 = new Image(SIZE, SIZE);
    let image4 = new Image(SIZE, SIZE);

    let image2_1 = new Image(SIZE, SIZE);
    let image2_2 = new Image(SIZE, SIZE);
    let image2_3 = new Image(SIZE, SIZE);
    let image2_4 = new Image(SIZE, SIZE);

    let amount1 = document.createElement("p");
    let amount2 = document.createElement("p");
    let amount3 = document.createElement("p");
    let amount4 = document.createElement("p");

    amount1.style.position = "absolute";
    amount1.style.left = "120px";
    amount1.style.top = "90px";
    amount2.style.position = "absolute";
    amount2.style.left = "240px";
    amount2.style.top = "90px";
    amount3.style.position = "absolute";
    amount3.style.left = "120px";
    amount3.style.top = "220px";
    amount4.style.position = "absolute";
    amount4.style.left = "240px";
    amount4.style.top = "220px";

    image1.src = get_image_for_name(entire_array[i]);
    image1.dataset.champion = entire_array[i];
    image2.src = get_image_for_name(entire_array[i+=1]);
    image2.dataset.champion = entire_array[i];
    image3.src = get_image_for_name(entire_array[i+=1]);
    image3.dataset.champion = entire_array[i];
    image4.src = get_image_for_name(entire_array[i+=1]);
    image4.dataset.champion = entire_array[i];

    image2_1.src = get_image_for_name(what_we_have[j]);
    image2_1.dataset.champion = what_we_have[j];
    amount1.innerText = what_we_have_amount[j];
    image2_2.src = get_image_for_name(what_we_have[j+=1]);
    image2_2.dataset.champion = what_we_have[j];
    amount2.innerText = what_we_have_amount[j];
    image2_3.src = get_image_for_name(what_we_have[j+=1]);
    image2_3.dataset.champion = what_we_have[j];
    amount3.innerText = what_we_have_amount[j];
    image2_4.src = get_image_for_name(what_we_have[j+=1]);
    image2_4.dataset.champion = what_we_have[j];
    amount4.innerText = what_we_have_amount[j];

    image1.id = "image1";
    image2.id = "image2";
    image3.id = "image3";
    image4.id = "image4";

    image2_1.id = "image2_1";
    image2_2.id = "image2_2";
    image2_3.id = "image2_3";
    image2_4.id = "image2_4";

    amount1.id = "amount1";
    amount2.id = "amount2";
    amount3.id = "amount3";
    amount4.id = "amount4";

    image1.onclick = function () {
        insert_image(this, inventoryDiv, this.dataset.champion);
    };
    image2.onclick = function () {
        insert_image(this, inventoryDiv, this.dataset.champion);
    };
    image3.onclick = function () {
        insert_image(this, inventoryDiv, this.dataset.champion);
    };
    image4.onclick = function () {
        insert_image(this, inventoryDiv, this.dataset.champion);
    };

    image2_1.onclick = function () {
        insert_image2(this, collectionDiv, this.dataset.champion);
    };
    image2_2.onclick = function () {
        insert_image2(this, collectionDiv, this.dataset.champion);
    };
    image2_3.onclick = function () {
        insert_image2(this, collectionDiv, this.dataset.champion);
    };
    image2_4.onclick = function () {
        insert_image2(this, collectionDiv, this.dataset.champion);
    };

    collectionDiv.appendChild(image1);
    collectionDiv.appendChild(image2);
    collectionDiv.appendChild(image3);
    collectionDiv.appendChild(image4);

    if (what_we_have.length !== 1) {
        if ((what_we_have.length - 1 % 4) === 1) {
            inventoryDiv.appendChild(image2_1);
            inventoryDiv.appendChild(amount1);
        } else if (what_we_have.length - 1 % 4 === 2) {
            inventoryDiv.appendChild(image2_1);
            inventoryDiv.appendChild(image2_2);
            inventoryDiv.appendChild(amount1);
            inventoryDiv.appendChild(amount2);
        } else if (what_we_have.length - 1 % 4 === 3) {
            inventoryDiv.appendChild(image2_1);
            inventoryDiv.appendChild(image2_2);
            inventoryDiv.appendChild(image2_3);
            inventoryDiv.appendChild(amount1);
            inventoryDiv.appendChild(amount2);
            inventoryDiv.appendChild(amount3);
        } else {
            inventoryDiv.appendChild(image2_1);
            inventoryDiv.appendChild(image2_2);
            inventoryDiv.appendChild(image2_3);
            inventoryDiv.appendChild(image2_4);
            inventoryDiv.appendChild(amount1);
            inventoryDiv.appendChild(amount2);
            inventoryDiv.appendChild(amount3);
            inventoryDiv.appendChild(amount4);
        }
    }

}

function insert_image(image, hide, name) {
    document.getElementById("trade_coin2").src = image.src;
    document.getElementById("champion2").value = name;
    check();
    hide.style.opacity = "0";
}

function insert_image2(image, hide, name) {
    document.getElementById("trade_coin").src = image.src;
    document.getElementById("champion").value = name;
    check();
    hide.style.opacity = "0";
}

function show_change_1() {
    document.getElementById("inv").style.opacity = "1";
}

function show_change_2() {
    document.getElementById("collection").style.opacity = "1";
}

function page_forward() {
    let image1 = document.getElementById("image1");
    let image2 = document.getElementById("image2");
    let image3 = document.getElementById("image3");
    let image4 = document.getElementById("image4");

    if (i === 0) {
        image4.removeAttribute("hidden");
        image1.src = get_image_for_name(entire_array[i+=1]);
        image1.dataset.champion = entire_array[i];
        image2.src = get_image_for_name(entire_array[i+=1]);
        image2.dataset.champion = entire_array[i];
        image3.src = get_image_for_name(entire_array[i+=1]);
        image3.dataset.champion = entire_array[i];
        image4.src = get_image_for_name(entire_array[i+=1]);
        image4.dataset.champion = entire_array[i];
    } else if (i < 44) {
        image1.src = get_image_for_name(entire_array[i+=1]);
        image1.dataset.champion = entire_array[i];
        image2.src = get_image_for_name(entire_array[i+=1]);
        image2.dataset.champion = entire_array[i];
        image3.src = get_image_for_name(entire_array[i+=1]);
        image3.dataset.champion = entire_array[i];
        image4.src = get_image_for_name(entire_array[i+=1]);
        image4.dataset.champion = entire_array[i];
    } else {
        image1.src = get_image_for_name(entire_array[i+=1]);
        image1.dataset.champion = entire_array[i];
        image2.src = get_image_for_name(entire_array[i+=1]);
        image2.dataset.champion = entire_array[i];
        image3.src = get_image_for_name(entire_array[i+=1]);
        image3.dataset.champion = entire_array[i];
        image4.setAttribute("hidden", "");
        i = 0;
    }
}

function page_forward_inventory() {
    let image2_1 = document.getElementById("image2_1");
    let image2_2 = document.getElementById("image2_2");
    let image2_3 = document.getElementById("image2_3");
    let image2_4 = document.getElementById("image2_4");

    let amount1 = document.getElementById("amount1");
    let amount2 = document.getElementById("amount2");
    let amount3 = document.getElementById("amount3");
    let amount4 = document.getElementById("amount4");

    if (j === 0) {
        image2_1.removeAttribute("hidden");
        image2_2.removeAttribute("hidden");
        image2_3.removeAttribute("hidden");
        image2_4.removeAttribute("hidden");

        amount1.removeAttribute("hidden");
        amount2.removeAttribute("hidden");
        amount3.removeAttribute("hidden");
        amount4.removeAttribute("hidden");

        image2_1.src = get_image_for_name(what_we_have[j+=1]);
        image2_1.dataset.champion = what_we_have[j];
        amount1.innerText = what_we_have_amount[j];
        image2_2.src = get_image_for_name(what_we_have[j+=1]);
        image2_2.dataset.champion = what_we_have[j];
        amount2.innerText = what_we_have_amount[j];
        image2_3.src = get_image_for_name(what_we_have[j+=1]);
        image2_3.dataset.champion = what_we_have[j];
        amount3.innerText = what_we_have_amount[j];
        image2_4.src = get_image_for_name(what_we_have[j+=1]);
        image2_4.dataset.champion = what_we_have[j];
        amount4.innerText = what_we_have_amount[j];

    } else if (j > what_we_have.length - 4) {
        switch ((what_we_have.length - 1) % 4) {
            case 3:
                image2_1.src = get_image_for_name(what_we_have[j+=1]);
                image2_1.dataset.champion = what_we_have[j];
                amount1.innerText = what_we_have_amount[j];
                image2_2.src = get_image_for_name(what_we_have[j+=1]);
                image2_2.dataset.champion = what_we_have[j];
                amount2.innerText = what_we_have_amount[j];
                image2_3.src = get_image_for_name(what_we_have[j+=1]);
                image2_3.dataset.champion = what_we_have[j];
                amount3.innerText = what_we_have_amount[j];
                image2_4.setAttribute("hidden", "");
                amount4.setAttribute("hidden", "");
                break;
            case 2:
                image2_1.src = get_image_for_name(what_we_have[j+=1]);
                image2_1.dataset.champion = what_we_have[j];
                amount1.innerText = what_we_have_amount[j];
                image2_2.src = get_image_for_name(what_we_have[j+=1]);
                image2_2.dataset.champion = what_we_have[j];
                amount2.innerText = what_we_have_amount[j];
                image2_3.setAttribute("hidden", "");
                amount3.setAttribute("hidden", "");
                image2_4.setAttribute("hidden", "");
                amount4.setAttribute("hidden", "");
                break;
            case 1:
                image2_1.src = get_image_for_name(what_we_have[j+=1]);
                image2_1.dataset.champion = what_we_have[j];
                amount2.setAttribute("hidden", "");
                image2_2.setAttribute("hidden", "");
                amount3.setAttribute("hidden", "");
                image2_3.setAttribute("hidden", "");
                amount4.setAttribute("hidden", "");
                image2_4.setAttribute("hidden", "");
                break;
        }
        j = 0;
    } else {
        image2_1.src = get_image_for_name(what_we_have[j+=1]);
        image2_1.dataset.champion = what_we_have[j];
        amount1.innerText = what_we_have_amount[j];
        image2_2.src = get_image_for_name(what_we_have[j+=1]);
        image2_2.dataset.champion = what_we_have[j];
        amount2.innerText = what_we_have_amount[j];
        image2_3.src = get_image_for_name(what_we_have[j+=1]);
        image2_3.dataset.champion = what_we_have[j];
        amount3.innerText = what_we_have_amount[j];
        image2_4.src = get_image_for_name(what_we_have[j+=1]);
        image2_4.dataset.champion = what_we_have[j];
        amount4.innerText = what_we_have_amount[j];
    }
}
/*
function page_back() {
    let image1 = document.getElementById("image1");
    let image2 = document.getElementById("image2");
    let image3 = document.getElementById("image3");
    let image4 = document.getElementById("image4");

    console.log(i);

    if (i === 4) {
        i = 47 - 3;
        image1.src = get_image_for_name(entire_array[i+=1]);
        image2.src = get_image_for_name(entire_array[i+=1]);
        image3.src = get_image_for_name(entire_array[i+=1]);
        image4.setAttribute("hidden", "");
    } else {

    }
}*/
