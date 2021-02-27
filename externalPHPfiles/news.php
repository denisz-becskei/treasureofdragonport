<?php

function add_news($content) {
    $conn = OpenCon();

    $username = $_SESSION["username"];
    $today = date("Y/m/d H:i:s");
    $sql = "INSERT INTO news(date, content, author) VALUES ('$today', '$content', '$username')";
    mysqli_query($conn, $sql);
    CloseCon($conn);
}

function get_news() {
    $conn = OpenCon();

    $sql = "SELECT * FROM news ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {
        echo str_replace(";", "<br>", utf8_encode($row["content"])) . "<br>By:: ". utf8_encode($row["author"]) . "<br>Közzétéve::" . utf8_encode($row["date"]) . "<br><br>";
    }

}
