<?php
include ('templates/header.php');
include ('templates/footer.php');

// var_dump($_GET);
if (!empty($_GET)) {
    $id = $_GET['id'];


    
//--Je recupere la table shows et fais une jointure pour recuperer les infos de la table categories, theaters, et shows_categories:
$pdo = connect_db();
$query = ('SELECT s.*, c.category, t.*
FROM shows AS s
LEFT JOIN shows_categories AS sc ON sc.show_id = s.id_show
LEFT JOIN categories AS c ON sc.category_id = c.id_category
LEFT JOIN theaters AS t ON s.theater_id = t.id_theater 
WHERE s.id_show = :id');
$statement = $pdo->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$show = $statement->fetch(PDO::FETCH_ASSOC);
// var_dump($show);

$tableDiscounts = selectAllFromSql('discounts');
// var_dump($tableDiscounts);
$firstPlace = calculateDiscountedPrice($show['placePrice'], $tableDiscounts[1]['discount']);
// echo $firstPlace;

$startDate = new DateTime($show['startDate']);
$endDate = new DateTime($show['endDate']);
// Créer un formateur de date international en français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN);
$startDateInLetters = $formatter->format($startDate);
$endDateInLetters = $formatter->format($endDate);


//--Je recupere toutes les dates disponibles de la table représentations : en semectionnant toutes les dates associées à l'id su spectacle et non les places disponibles sont supérieures à 0.
$pdo = connect_db();
$query = ("SELECT day from representations WHERE show_id = :id AND availablePlaces > 0");
$statement = $pdo -> prepare ($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
if ($statement -> execute()) {
    $availablesDates = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    Echo "Erreur lors de l'execution de la requête.";
}
// var_dump($availablesDates);

}
?>

<div class="desc-show flex-column align-center" style="padding: 30px; max-width:1200px; margin:auto;">
    <div class="flex space-between">
        <div class="flex-column">
            <h1><?=$show['showTitle']?></h1>
            <p><?= $show['theaterName'] ." - ". $show['theaterCity'] ." ". $show['postalCode']?></p>
        </div>
        <a href = "#day" ><button type="button" class="btn btn-resa m-3 btn-dark btn-lg self-end">Réserver ma séance</button></a>
    </div>
    <div class="flex flex-wrap">
        <img class="img-responsive" src="<?=$show['imageData']?>" alt="Affiche du spectacle <?=$show['showTitle']?>">
        <div class="text-container">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span>Genre :</span> <?=$show['category']?></li>
                <li class="list-group-item"><span>Lieu : </span><br><?=$show['theaterName'] ." - ". $show['theaterAd'] ." - ".$show['theaterCity'] ." - ". $show['postalCode'] ."<br> ".$show['theaterPhone']?></li>
                <li class="list-group-item"><span>Dates de spectacle :</span><br> Du <?=$startDateInLetters?> au <?=$endDateInLetters?></li>
                <li class="list-group-item"><span>Durée du spectacle (en heures)</span> :<br><?=$show['duration']?></li>
                <li class="list-group-item"><span>Artistes : </span><br> <?=$show['artists'] ?></li>
                <li class="list-group-item"><span>Partager sur :</span><br>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                </li>
            </ul>
        </div>
    </div>
    <p class="m-3"><span>Description :</span><br><?=$show['description']?></p>
    <p class="m-3"><span>À partir de <?=$show['placePrice']?> € </span></p>    

</div>


<form action='reservation.php?id=<?=$id?>' class="reservation" method="POST">
        <label for="day"></label>
        <select class="form-select  day" name="day" id="day" required>
            <option value ="" selected disabled hidden>Dates de représentations</option>
            <?php foreach($availablesDates as $date) :?>
            <option value ="<?=$date['day']?>"><?=$date['day']?></option>
            <?php endforeach; ?>                        
        </select>

        <div>
            <label for="time"></label>
            <select id="time" name="time" class="form-select " required>
                <option value="" selected disabled hidden>Choisissez votre horaire</option>
                <option value="15:30">15:30</option>
                <option value="20:00">20:00</option>
            </select>

        </div>

        <label for="nbPlaces">Nombre de Places :</label>
        <input type="number" name="nbPlaces" min="1" class="form-control" value ="1" required><br></input>
        <div class="flex align-end">
            <button type="submit" class="btn btn-dark btn-lg">Je réserve</button>
        </div>
</form>





     


 