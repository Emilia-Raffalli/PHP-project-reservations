<?php
session_start();
include ('function.php');

if (isset($_POST) && !empty($_POST)) {
    $showTitle = $_POST['showTitle'];
    $idCategory =$_POST['category'];
    $imageData = $_POST['imageDataPath'];
    $idTheater = $_POST['theater'];
    $description = $_POST['description'];
    $artists = $_POST['artists'];
    $duration = $_POST['duration'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $placePrice = $_POST['placePrice'];
    $priceCat1 = $_POST['priceCat1'];
    $priceCat2 = $_POST['priceCat2'];
    $priceCat3 = $_POST['priceCat3'];



    $pdo = connect_db();
    $query = 'INSERT INTO shows (showTitle, startDate, endDate, description, artists, imageData, duration, placePrice, priceCat1, priceCat2, priceCat3, theater_id) VALUES (:showTitle, :startDate, :endDate, :description, :artists, :imageDataPath, :duration, :placePrice, :priceCat1, :priceCat2, :priceCat3, :theater_id)';
    $statement = $pdo ->prepare ($query);
    $statement->bindValue(':showTitle', $showTitle, PDO::PARAM_STR);
    $statement->bindValue(':startDate', $startDate, PDO::PARAM_STR);
    $statement->bindValue(':endDate', $endDate, PDO::PARAM_STR);
    $statement->bindValue(':description', $description, PDO::PARAM_STR);
    $statement->bindValue(':artists', $artists, PDO::PARAM_STR);
    $statement->bindValue(':imageDataPath', $imageData, PDO::PARAM_STR);
    $statement->bindValue(':duration', $duration, PDO::PARAM_STR);
    $statement->bindValue(':placePrice', $placePrice, PDO::PARAM_STR);
    $statement->bindValue(':priceCat1', $priceCat1, PDO::PARAM_STR);
    $statement->bindValue(':priceCat2', $priceCat2, PDO::PARAM_STR);
    $statement->bindValue(':priceCat3', $priceCat3, PDO::PARAM_STR);
    $statement->bindValue(':theater_id', $idTheater, PDO::PARAM_INT);
    
    $statement ->execute();
    $array = $statement -> fetch(PDO::FETCH_ASSOC);

    // var_dump($array);

    // to retrieve the last inserted id :
    $lastInsertId = $pdo->lastInsertId();

    echo "voici le dernier id généré :" . $lastInsertId ;

    $query = ("INSERT INTO shows_categories (category_id, show_id) VALUES (:category_id, :lastInsertId)");
    $statement = $pdo -> prepare($query);
    $statement->bindValue(':category_id' , $idCategory, PDO::PARAM_INT);
    $statement->bindValue(':lastInsertId' , $lastInsertId, PDO::PARAM_INT);

    $statement-> execute();

    header('location:index.php');
    exit();

}

?>