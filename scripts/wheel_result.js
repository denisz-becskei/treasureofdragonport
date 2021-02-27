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

    }
}

function get_rarity_for_champion(champion) {
    let legendary = "Yagorath";
    let epic_array = ["Vora", "Corvus", "Raum", "Tiberius"];
    let rare_array = ["Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus"];
    let uncommon_array = ["Lian", "Tyra", "Bomb_King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye"];

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

async function spin() {
    let get_db_spin_status = function () {
        var tmp = null;
        $.ajax({
            'type': "POST",
            'async': false,
            'global': false,
            'url': "externalPHPfiles/get_initiated.php",
            'success': function (data) {
                tmp = data;
            }
        });
        return tmp;
    }();
    console.log(get_db_spin_status)
    if (get_db_spin_status === "1") {
        let entire_array = ["Yagorath", "Vora", "Corvus", "Raum", "Tiberius", "Atlas", "Dredge", "Io", "Zhin", "Talus", "Imani", "Koga", "Furia", "Strix", "Khan", "Terminus",
            "Lian", "Tyra", "Bomb King", "Sha Lin", "Drogoz", "Makoa", "Ying", "Torvald", "Maeve", "Evie", "Kinessa", "Mal'Damba", "Androxus", "Skye",
            "Jenos", "Vivian", "Buck", "Seris", "Inara", "Grohk", "Viktor", "Cassie", "Lex", "Grover", "Ash", "Ruckus", "Fernando", "Barik", "Pip", "Moji", "Willo"];

        let final_coins;

        const item_image1 = getElement('item1');
        const item_image2 = getElement('item2');
        const item_image3 = getElement('item3');

        const item_name1 = getElement('item_name1');
        const item_name2 = getElement('item_name2');
        const item_name3 = getElement('item_name3');

        const item_rarity1 = getElement('item_rarity1');
        const item_rarity2 = getElement('item_rarity2');
        const item_rarity3 = getElement('item_rarity3');

        $.post("externalPHPfiles/add_coin.php");
        $.post("externalPHPfiles/get_spun.php", function (data) {
            final_coins = data.split("|");
        });
        $.post("externalPHPfiles/deinitiate_spin.php");

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
    } else {
        window.location = "wheel.php";
    }
}

/*var _0x101d=["\x59\x61\x67\x6F\x72\x61\x74\x68","\x56\x6F\x72\x61","\x43\x6F\x72\x76\x75\x73","\x52\x61\x75\x6D","\x54\x69\x62\x65\x72\x69\x75\x73",
    "\x41\x74\x6C\x61\x73","\x44\x72\x65\x64\x67\x65","\x49\x6F","\x5A\x68\x69\x6E","\x54\x61\x6C\x75\x73","\x49\x6D\x61\x6E\x69","\x4B\x6F\x67\x61",
    "\x46\x75\x72\x69\x61","\x53\x74\x72\x69\x78","\x4B\x68\x61\x6E","\x54\x65\x72\x6D\x69\x6E\x75\x73","\x4C\x69\x61\x6E","\x54\x79\x72\x61",
    "\x42\x6F\x6D\x62\x20\x4B\x69\x6E\x67","\x53\x68\x61\x20\x4C\x69\x6E","\x44\x72\x6F\x67\x6F\x7A","\x4D\x61\x6B\x6F\x61","\x59\x69\x6E\x67",
    "\x54\x6F\x72\x76\x61\x6C\x64","\x4D\x61\x65\x76\x65","\x45\x76\x69\x65","\x4B\x69\x6E\x65\x73\x73\x61","\x4D\x61\x6C\x27\x44\x61\x6D\x62\x61",
    "\x41\x6E\x64\x72\x6F\x78\x75\x73","\x53\x6B\x79\x65","\x3C\x4C\x65\x67\x65\x6E\x64\xE1\x73\x3E","\x69\x6E\x63\x6C\x75\x64\x65\x73","\x3C\x45\x70\x69\x6B\x75\x73\x3E",
    "\x3C\x52\x69\x74\x6B\x61\x3E","\x3C\x45\x67\x79\x65\x64\x69\x3E","\x3C\x47\x79\x61\x6B\x6F\x72\x69\x3E","\x72\x65\x73\x65\x72\x76\x65\x64",
    "\x67\x65\x74\x49\x74\x65\x6D","\x74\x72\x75\x65","\x4A\x65\x6E\x6F\x73","\x56\x69\x76\x69\x61\x6E","\x42\x75\x63\x6B","\x53\x65\x72\x69\x73",
    "\x49\x6E\x61\x72\x61","\x47\x72\x6F\x68\x6B","\x56\x69\x6B\x74\x6F\x72","\x43\x61\x73\x73\x69\x65","\x4C\x65\x78","\x47\x72\x6F\x76\x65\x72",
    "\x41\x73\x68","\x52\x75\x63\x6B\x75\x73","\x46\x65\x72\x6E\x61\x6E\x64\x6F","\x42\x61\x72\x69\x6B","\x50\x69\x70","\x4D\x6F\x6A\x69",
    "\x57\x69\x6C\x6C\x6F","\x65\x78\x74\x65\x72\x6E\x61\x6C\x50\x48\x50\x66\x69\x6C\x65\x73\x2F\x61\x64\x64\x5F\x63\x6F\x69\x6E\x2E\x70\x68\x70",
    "\x70\x6F\x73\x74","\x69\x74\x65\x6D\x31","\x69\x74\x65\x6D\x32","\x69\x74\x65\x6D\x33","\x69\x74\x65\x6D\x5F\x6E\x61\x6D\x65\x31",
    "\x69\x74\x65\x6D\x5F\x6E\x61\x6D\x65\x32","\x69\x74\x65\x6D\x5F\x6E\x61\x6D\x65\x33","\x69\x74\x65\x6D\x5F\x72\x61\x72\x69\x74\x79\x31",
    "\x69\x74\x65\x6D\x5F\x72\x61\x72\x69\x74\x79\x32","\x69\x74\x65\x6D\x5F\x72\x61\x72\x69\x74\x79\x33",
    "\x65\x78\x74\x65\x72\x6E\x61\x6C\x50\x48\x50\x66\x69\x6C\x65\x73\x2F\x67\x65\x74\x5F\x73\x70\x75\x6E\x2E\x70\x68\x70","\x7C","\x73\x70\x6C\x69\x74",
    "\x72\x61\x6E\x64\x6F\x6D","\x6C\x65\x6E\x67\x74\x68","\x66\x6C\x6F\x6F\x72","\x73\x72\x63","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","",
    "\x74\x69\x63\x6B\x69\x6E\x67","\x63\x75\x72\x72\x65\x6E\x74\x54\x69\x6D\x65","\x70\x6C\x61\x79","\x63\x68\x69\x6E\x67\x69\x6E\x67","\x68\x69\x64\x64\x65\x6E",
    "\x69\x6E\x6E\x65\x72\x54\x65\x78\x74","\x63\x6F\x6C\x6F\x72","\x73\x74\x79\x6C\x65","\x72\x65\x64","\x67\x72\x61\x79","\x6C\x69\x6D\x65\x67\x72\x65\x65\x6E",
    "\x62\x6C\x75\x65","\x70\x75\x72\x70\x6C\x65",
    "\x65\x78\x74\x65\x72\x6E\x61\x6C\x50\x48\x50\x66\x69\x6C\x65\x73\x2F\x75\x70\x64\x61\x74\x65\x5F\x73\x70\x75\x6E\x2E\x70\x68\x70","\x62\x61\x63\x6B",
    "\x72\x65\x6D\x6F\x76\x65\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x66\x61\x6C\x73\x65","\x73\x65\x74\x49\x74\x65\x6D","\x68\x72\x65\x66",
    "\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x77\x68\x65\x65\x6C\x2E\x70\x68\x70"];
eval(function(p,a,c,k,e,d)
{e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};
if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};
while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}
('M e(v){i 1g=a[0];i 1f=[a[1],a[2],a[3],a[4]];i 1e=[a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15]];i 1d=[a[16],a[17],a[18],a[19],a[20],a[21],a[22],a[23],a[24],a[25],a[26],a[27],a[28],a[29]];c(1g===v){u a[w]}d{c(1f[a[L]](v)){u a[D]}d{c(1e[a[L]](v)){u a[y]}d{c(1d[a[L]](v)){u a[z]}d{u a[x]}}}}}1F M 1E(){c(1k[a[1D]](a[1i])===a[1C]){i l=[a[0],a[1],a[2],a[3],a[4],a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15],a[16],a[17],a[18],a[19],a[20],a[21],a[22],a[23],a[24],a[25],a[26],a[27],a[28],a[29],a[1y],a[1A],a[1z],a[1p],a[1x],a[1w],a[1t],a[1M],a[1s],a[1r],a[1q],a[1n],a[1o],a[1u],a[1v],a[1L],a[1B]];i b=[];$[a[X]](a[1N]);k F=j(a[1V]);k G=j(a[2j]);k H=j(a[2h]);k I=j(a[2g]);k J=j(a[2b]);k K=j(a[2e]);k o=j(a[2d]);k m=j(a[2c]);k n=j(a[2i]);$[a[X]](a[2f],M(1c,2a){b=1c[a[1Y]](a[1X])});1W(i p=0;p<13;p++){i V=t[a[U]](t[a[W]]()*l[a[P]]);i T=t[a[U]](t[a[W]]()*l[a[P]]);i O=t[a[U]](t[a[W]]()*l[a[P]]);F[a[q]]=s(l[V]);G[a[q]]=s(l[T]);H[a[q]]=s(l[O]);I[a[r]]=`${a[f]}${l[V]}${a[f]}`;J[a[r]]=`${a[f]}${l[T]}${a[f]}`;K[a[r]]=`${a[f]}${l[O]}${a[f]}`;i N=j(a[1S]);N[a[1l]]=0;N[a[1m]]();c(p<=2){A B(1h)}d{c(p<=8){A B(1Q)}d{c(p<=10){A B(1h)}d{A B(1P)}}}};F[a[q]]=s(b[0]);G[a[q]]=s(b[1]);H[a[q]]=s(b[2]);I[a[r]]=`${a[f]}${b[0]}${a[f]}`;J[a[r]]=`${a[f]}${b[1]}${a[f]}`;K[a[r]]=`${a[f]}${b[2]}${a[f]}`;i Q=j(a[1R]);Q[a[1l]]=0;Q[a[1m]]();o[a[C]]=R;m[a[C]]=R;n[a[C]]=R;o[a[S]]=`${a[f]}${e(b[0])}${a[f]}`;m[a[S]]=`${a[f]}${e(b[1])}${a[f]}`;n[a[S]]=`${a[f]}${e(b[2])}${a[f]}`;c(e(b[0])===a[w]){o[a[g]][a[h]]=a[Y]}d{c(e(b[0])===a[x]){o[a[g]][a[h]]=a[1a]}d{c(e(b[0])===a[z]){o[a[g]][a[h]]=a[1b]}d{c(e(b[0])===a[y]){o[a[g]][a[h]]=a[E]}d{c(e(b[0])===a[D]){o[a[g]][a[h]]=a[Z]}}}}};c(e(b[1])===a[w]){m[a[g]][a[h]]=a[Y]}d{c(e(b[1])===a[x]){m[a[g]][a[h]]=a[1a]}d{c(e(b[1])===a[z]){m[a[g]][a[h]]=a[1b]}d{c(e(b[1])===a[y]){m[a[g]][a[h]]=a[E]}d{c(e(b[1])===a[D]){m[a[g]][a[h]]=a[Z]}}}}};c(e(b[2])===a[w]){n[a[g]][a[h]]=a[Y]}d{c(e(b[2])===a[x]){n[a[g]][a[h]]=a[1a]}d{c(e(b[2])===a[z]){n[a[g]][a[h]]=a[1b]}d{c(e(b[2])===a[y]){n[a[g]][a[h]]=a[E]}d{c(e(b[2])===a[D]){n[a[g]][a[h]]=a[Z]}}}}};$[a[X]](a[1T]);k 1j=j(a[1U]);1j[a[1O]](a[C]);1k[a[1G]](a[1i],a[1H])}d{1I[a[1J]][a[1K]]=a[1Z]}}',62,144,'||||||||||_0x101d|_0x3d8cx9|if|else|get_rarity_for_champion|75|83|82|let|getElement|const|_0x3d8cx8|_0x3d8cx11|_0x3d8cx12|_0x3d8cx10|_0x3d8cx15|73|74|get_image_for_name|Math|return|_0x3d8cx2|30|35|33|34|await|sleep|80|32|87|_0x3d8cxa|_0x3d8cxb|_0x3d8cxc|_0x3d8cxd|_0x3d8cxe|_0x3d8cxf|31|function|_0x3d8cx19|_0x3d8cx18|71|_0x3d8cx1a|false|81|_0x3d8cx17|72|_0x3d8cx16|70|57|84|88|||||||||||85|86|_0x3d8cx13|_0x3d8cx6|_0x3d8cx5|_0x3d8cx4|_0x3d8cx3|500|36|_0x3d8cx1b|localStorage|77|78|50|51|42|49|48|47|45|52|53|44|43|39|41|40|55|38|37|spin|async|93|92|window|95|94|54|46|56|91|1000|250|79|76|89|90|58|for|68|69|96|||||||||||_0x3d8cx14|62|65|64|63|67|61|60|66|59'.split('|'),0,{}));
*/

setTimeout(function () {
    spin();
}, 1500);
