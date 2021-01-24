function startLiveUpdate() {
    setInterval(function () {
        fetch("externalPHPfiles/check_ready_status.php").then(function (response){
            return response.json();
        }).then(function (data) {
            let trader = data.trader_ready;
            let tradee = data.tradee_ready;
            console.log("got values " + trader + " " + tradee);
            if (trader === 1 && tradee === 1) {
                location.reload();
            }
        }).catch(function (error) {
            console.log(error);
        });
    }, 1000)

    document.addEventListener("DOMContentLoaded", function () {
        startLiveUpdate();
    });
}