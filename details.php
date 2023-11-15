<?php
include ('templates/header.php');
include ('templates/footer.php');

// var_dump($_GET);
if (!empty($_GET)) {
    $id = $_GET['id'];


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

var_dump($show);



$startDate = new DateTime($show['startDate']);
$endDate = new DateTime($show['endDate']);

// Créer un formateur de date international en français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN);

$startDateInLetters = $formatter->format($startDate);
$endDateInLetters = $formatter->format($endDate);



}
?>

<div class="desc-show flex-column align-center" style="padding: 30px; background:; margin: auto;">
    <h1><?=$show['showTitle']?></h1>

    <p><?= $show['theaterName'] ." - ". $show['theaterCity'] ." ". $show['postalCode']?></p>
    
    <div class="flex flex-wrap">
        
        <img class="img-responsive" src="<?=$show['imageData']?>" alt="Affiche du spectacle <?=$show['showTitle']?>">

        <div class="text-container">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span>Genre :</span> <?=$show['category']?></li>
                <li class="list-group-item"><span>Lieu : </span><br><?=$show['theaterName'] . $show['theaterAd'] . $show['theaterCity'] . $show['postalCode'] . $show['theaterPhone']?></li>
                <li class="list-group-item"><span>Dates de spectacle :</span><br> Du <?=$startDateInLetters?> au <?=$endDateInLetters?></li>
                <li class="list-group-item"><span>Durée du spectacle (en heures)</span> :<br><?=$show['duration']?></li>
                <li class="list-group-item"><span>Artistes : </span><br> <?=$show['artists'] ?></li>
                <li class="list-group-item"><span>Partager sur :</span><br>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                </li>
            </ul>
            <button type="submit" class="btn m-3 btn-dark btn-lg self-end">Reserver</button>
        </div>
    </div>


    <div class="calendar">
        <label for="hour">Date de séance</label>
        <input class="form-control" type="date" min="<?=$show['startDate']?>" max="<?=$show['endDate'] ?>"></input>
        <label for="hour">Heure</label>
        <input class="form-control" type ="time" min=" " max=" " name ="time" id="time"></input>
    </div>

    

</div>