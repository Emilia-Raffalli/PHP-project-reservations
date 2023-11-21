<?php
include('templates/header.php');
include('templates/footer.php');

$idCustomer = $_SESSION['id_customer'];

// $id = $_GET ['id'];
$carts = $_SESSION['cart'];
// var_dump($carts);


$pdo = connect_db();

foreach($carts as $id=> $details) {
    $nbPlaces = $details['nbPlaces'];
    $totalPrice = $details['totalPrice'];
    // var_dump($id);
    $query = "SELECT r.*, s.*, t.*
    FROM representations as r 
    LEFT JOIN shows as s 
    ON r.show_id = s.id_show
    LEFT JOIN theaters as t 
    ON s.theater_id = t.id_theater
    WHERE id_representation = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);

    if ($statement->execute()) {
        $show = $statement->fetch(PDO::FETCH_ASSOC);
        // var_dump($show);
    }

// var_dump($carts);

?>
<main>
    <h3>Ma réservation</h2>
    <p>Veuillez trouvez les détails de votre réservation</p>

<table class="table table-striped reservation">
        <thead>
        <tr>
            <th colspan="4" class="title-resa" ><?=$show['showTitle']?></th>
        </tr>
        <tr>
            <td colspan="4" ><span><?=$show['theaterName']?></span> | <?=$show['theaterAd']?> | <?=$show['theaterCity']?> - <?=$show['postalCode']?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Date de représentation :</th>
            <td colspan="4" scope="row"><?=$show['day']?></td>
        </tr>
        <tr>
            <th>Heure :</th>
            <td  colspan="4" scope="row"><?=$show['time']?></td>

        </tr>
        <tr>
            <th>Nombre de places :</th>
            <td  colspan="4" scope="row"><?=$nbPlaces?></td>

        </tr>
        <tr>
            <th>Total :</th>
            <td  colspan="4" scope="row"><span><?=$totalPrice?> €</span></td>

        </tr>
    </table>
    <div class="flex space-between">
        <a href="#">Modifier ma réservation</a>
        <a href="delete.php?id=<?=$id?>">Supprimer</a>

        <button type ="submit" class="btn btn-dark btn-lg mb-3" >Valider ma réservation</button>
    </div>

</main>

<?php

}

?>



