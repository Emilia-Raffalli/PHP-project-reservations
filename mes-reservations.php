<?php
session_start();
include ('templates/header.php');

$idCust = $_SESSION['id_customer'];





?>



<?php
//1 Je me connecte à la base de données:

$pdo = connect_db();

// 2 Je fais une requête pour récupérer les informations des réservations réalisées par le customer:

    $query = 
    "SELECT res.*, s.*, t.*, rep.*
    FROM reservations as res
    LEFT JOIN representations as rep ON res.representation_id = rep.id_representation
    LEFT JOIN shows as s ON rep.show_id = s.id_show
    LEFT JOIN theaters as t ON s.theater_id = t.id_theater
    WHERE customer_id = :idCust
    ORDER BY createdDate";
    
    $statement = $pdo -> prepare($query);
    $statement -> bindValue(':idCust', $idCust, PDO::PARAM_INT);
    $statement -> execute();

    $reservations = $statement -> fetchAll(PDO::FETCH_ASSOC);

    // var_dump($reservations);

  




foreach ($reservations as $i => $reservation):
    $reservationDate = new DateTime($reservation['createdDate']);
    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM, 'Europe/Paris', IntlDateFormatter::GREGORIAN);

?>
<main>
    <p><span>Reservation n° <?=$i +1?></span></p>
    <p>Effectuée le <?= $formatter ->format($reservationDate)?>
    <table class="table table-striped reservation">
        <thead>
            <tr>
                <th colspan="2" class="title-resa"><?= $reservation['showTitle'] ?></th>
            </tr>
            <tr>
                <td colspan="2"><span><?= $reservation['theaterName'] ?></span> | <?= $reservation['theaterAd'] ?> | <?= $reservation['theaterCity'] ?> - <?= $reservation['postalCode'] ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Date de représentation :</th>
                <td class="right" colspan="" scope="row"><?= $reservation['day'] ?></td>
            </tr>
            <tr>
                <th>Heure :</th>
                <td class="right" colspan="" scope="row"><?= $reservation['time'] ?></td>
            </tr>
            <tr>
                <th>Nombre de places :</th>
                <td class="right" colspan="" scope="row"><?= $reservation['nbPlaces'] ?></td>
            </tr>
            <tr>
                <th colspan="" >Total :</th>
                <td class="right" scope="row"><span><?= $reservation['totalPrice'] ?> €</span></td>
            </tr>
            
        </tbody>
    </table>

 </main>
<?php endforeach ;?>

