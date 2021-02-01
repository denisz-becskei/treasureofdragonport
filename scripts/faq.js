document.getElementById("btn1").onclick = function () {
    console.log("Clicked");
    document.getElementById("div1").removeAttribute("hidden");
    document.getElementById("div2").setAttribute("hidden", "");
    document.getElementById("div3").setAttribute("hidden", "");
}

document.getElementById("btn2").onclick = function () {
    document.getElementById("div2").removeAttribute("hidden");
    document.getElementById("div1").setAttribute("hidden", "");
    document.getElementById("div3").setAttribute("hidden", "");
}

document.getElementById("btn3").onclick = function () {
    document.getElementById("div3").removeAttribute("hidden");
    document.getElementById("div2").setAttribute("hidden", "");
    document.getElementById("div1").setAttribute("hidden", "");
}