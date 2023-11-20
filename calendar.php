<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $heure = $_POST["heure"];

    // Vous pouvez faire quelque chose avec la date et l'heure, comme les enregistrer dans une base de données
    echo "Date sélectionnée : $date<br>";
    echo "Heure sélectionnée : $heure";


}


var_dump($_POST);

?>


<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier PHP</title>
    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Inclure jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-2.1.1.js"></script>
</head>
<body>

<form action="" method="post">
    <label for="datepicker">Sélectionnez une date :</label>
    <input type="text" id="datepicker" name="date">
    
    <label for="heure">Sélectionnez une heure :</label>
    <input type="time" id="heure" name="heure">
    
    <input type="submit" value="Soumettre">
</form>

<script>
    // Initialisez le sélecteur de date avec jQuery UI
    $(function() {
        $("#datepicker").datepicker();
    });
</script>

</body>
</html>








