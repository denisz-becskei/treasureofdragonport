
function start_spin() {
    $.post("externalPHPfiles/initiate_spin.php", function (data, status) {
        if (status === "success") {
            window.location = "wheel_result.php";
        }
    });
}

start_spin();