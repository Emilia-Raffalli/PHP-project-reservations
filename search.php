<?php

session_start();
include ('templates/header.php');
include ('templates/footer.php');

// var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $day = $_POST['day'];
    $theater = $_POST['theater'];

    echo "Résultats de la recherche pour : " . $title . "  " . $day . " " . $theater . "<br>";

    $pdo = connect_db();
    
    if (isset($title) && !empty($title)) {
        // Je recherche par titre
        $query = "SELECT * FROM shows WHERE showTitle LIKE :title";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);
    } elseif (isset($theater) && !empty($theater)) {
        //Je recherche par théâtre
        $query = "SELECT s.*, t.* 
                FROM shows as s 
                LEFT JOIN theaters as t ON s.theater_id = t.id_theater
                WHERE theaterName = :theater";
        $statement = $pdo ->prepare($query);
        $statement -> bindValue(':theater', $theater, PDO::PARAM_STR);
    } elseif (isset($day) && !empty($day)) {
        // Je recherche par date
        $query = "SELECT s.*
                  FROM shows as s
                  JOIN representations as r ON s.id_show = r.show_id
                  WHERE r.day = :day
                  GROUP BY s.id_show"; // j'utilise 'GROUP BY' pour éviter les doublons avec les id
        $statement = $pdo->prepare($query);
        $statement->bindValue(':day', $day, PDO::PARAM_STR);
    } else {
        echo "Vous n'avez renseigné aucun champ à votre recherche.";
        exit(); // On n'éxecute pas le code si la condition n'est pas satisfaite.
    }

    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo "Aucun spectacle correspondant.";
    } else {
        ?>
        <main>
            <div class="flex-row flex-wrap justify-center">
                <?php foreach ($results as $result): ?>
                    <div class="card m-3" style="width: 18rem; box-shadow: 5px 5px 5px #dcdcdc; ">
                        <a href="details.php?id=<?= $result['id_show'] ?>">
                            <img class='poster' src="<?= $result['imageData'] ?>" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body flex space-between align-center">
                            <a class="link-offset-2 link-underline link-underline-opacity-25" href="details.php?id=<?= $result['id_show'] ?>">Découvrir</a>
                            <a class='btn btn-dark' href="reservation.php">Réserver</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <?php
    }
}


// if ((isset($day) && !empty($day)) || (isset($title) && !empty($title))) {

//     $pdo = connect_db();
//     $query = "SELECT r.*, s.*, t.*
//     FROM representations as r 
//     LEFT JOIN shows as s ON r.show_id = s.id_show
//     LEFT JOIN theaters as t ON s.theater_id = t.id_theater";
//     $statement = $pdo->query($query);
//     $statement->execute();
//     $completeTable = $statement->fetchAll(PDO::FETCH_ASSOC);
//     var_dump($completeTable);
   
//   }



?>