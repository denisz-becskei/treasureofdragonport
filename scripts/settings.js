document.getElementById("toggle_dm").onclick = function () {
    $.post("externalPHPfiles/theme.php", function (data, status) {
        if (status === "success") {
            window.location = "settings.php";
        }
    });
}