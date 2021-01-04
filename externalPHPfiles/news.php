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
        echo str_replace(";", "<br>", $row["content"]) . "<br>By:: ". $row["author"] . "<br>Közzétéve::" . $row["date"] . "<br><br>";
    }

}
