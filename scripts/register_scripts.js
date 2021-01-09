function check_rank() {
    document.getElementById("max_rank_2").disabled = document.getElementById("max_rank").value === "Master" || document.getElementById("max_rank").value === "Grandmaster" || document.getElementById("max_rank").value === "Unranked";
}