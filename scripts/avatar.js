document.getElementById("avatars").onchange = function () {
    var e = document.getElementById("avatars");
    var selected_avatar = e.options[e.selectedIndex].text;
    $.ajax({
        type: 'post',
        url: 'externalPHPfiles/appearance_changer.php',
        data: {'avatars': selected_avatar},
        cache:false,
        success: function()
        {
            window.location = "settings.php";
        }
    });
}