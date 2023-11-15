<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traitez l'ajout de spectateurs (ajustez selon votre logique)
    // ...

    // Redirigez l'utilisateur vers une autre page ou actualisez la même page
    header("Location: add-spectator.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Spectateurs</title>
    <style>
        button {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>Ajouter Spectateurs</h1>

    <form method="post">
        <button type="submit">Ajouter Spectateurs</button>
    </form>



</body>
</html>
