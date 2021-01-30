<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">

    <title>Treasure of Dragon Port</title>
</head>
<script src="scripts/jquery-3.5.1.js"></script>
<script>
    function add_coin() {
            $.post("externalPHPfiles/add_coin.php", function(data, status){
                alert("Data: " + data + "\nStatus: " + status);
            });
    }
</script>

<body style="background-color: black" onload="add_coin();">


</body>
<script src="scripts/captcha.js"></script>
</html>
