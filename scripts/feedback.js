const char_limit = document.getElementById("char_limit");

function get_feedback_length() {
    let ta = document.getElementById("ta_feedback").value;
    char_limit.innerText = ta.length + " / 250";
    console.log(ta)
}

setInterval(function () {
    get_feedback_length();
}, 100)