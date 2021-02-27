document.getElementById("btn1").onclick = function () {
    document.getElementById("div1_1").removeAttribute("hidden");
    document.getElementById("div2_1").setAttribute("hidden", "");
    document.getElementById("div3_1").setAttribute("hidden", "");
}

document.getElementById("btn2").onclick = function () {
    document.getElementById("div2_1").removeAttribute("hidden");
    document.getElementById("div1_1").setAttribute("hidden", "");
    document.getElementById("div3_1").setAttribute("hidden", "");
}

document.getElementById("btn3").onclick = function () {
    document.getElementById("div3_1").removeAttribute("hidden");
    document.getElementById("div2_1").setAttribute("hidden", "");
    document.getElementById("div1_1").setAttribute("hidden", "");
}