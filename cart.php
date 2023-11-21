<?php
session_start();
include('templates/header.php');
include('templates/footer.php');

$idCustomer = $_SESSION['id_customer'];

if (isset($_GET['id']) && isset($_GET['places'])) {
    $id = $_GET['id'];
    $nbPlaces = $_GET['places'];
    // echo $nbPlaces;


// var_dump($_POST);
$place1 = $place2 = $place3 = $place4 = $place5 = null;

if (isset($_POST['tarif_place1'])) {
    $place1 = $_POST['tarif_place1'];
}

if (isset($_POST['tarif_place2'])) {
    $place2 = $_POST['tarif_place2'];
}

if (isset($_POST['tarif_place3'])) {
    $place3 = $_POST['tarif_place3'];
}

if (isset($_POST['tarif_place4'])) {
    $place4 = $_POST['tarif_place4'];
}

if (isset($_POST['tarif_place5'])) {
    $place5 = $_POST['tarif_place5'];
}
    // echo $place3;


$placesArray = [$place1, $place2, $place3];
$total = sum($placesArray);
// echo $total;



$pdo = connect_db();
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
        $info = $statement->fetch(PDO::FETCH_ASSOC);
        // var_dump($info);
    } else {
        echo "Erreur dans la requête.";
    }


//INSERTION DES INFORMATIONS DANS UN PANIER:
if (isset($_SESSION['cart'])) {

$cart = $_SESSION['cart'] = [
    'showTitle' => $info['showTitle'],
    'date' => $info['day'],
    'time' => $info['time'],
    'nbPlaces' => $nbPlaces,
    'totalPrice' => $total
];
var_dump($_SESSION['cart']);

}

//INSERTION DES INFOS RECUPEREES DANS LA TABLE CARTS:
// $query = "INSERT INTO carts (customer_id, representation_id, nbPlaces, totalPrice)
//         VALUES (:customer_id, :id_representation, :nbPlaces, :total)";
// $statement = $pdo->prepare($query);
// $statement->bindValue(':customer_id', $idCustomer, PDO::PARAM_INT);
// $statement->bindValue(':id_representation', $id, PDO::PARAM_INT);
// $statement->bindValue(':nbPlaces', $nbPlaces, PDO::PARAM_INT);
// $statement->bindValue(':total', $total, PDO::PARAM_INT);

// if ($statement->execute()) {

//     // echo "Insertion réussie.";
// } else {
//     echo "Erreur lors de l'insertion.";
// }

// $cart = selectFromCart($idCustomer, $id);

// var_dump($cart);
?>
<main>
    <h3>Ma réservation</h2>
    <p>Veuillez trouvez les détails de votre réservation</p>

<table class="table table-striped reservation">
        <thead>
        <tr>
            <th colspan="4" class="title-resa" ><?=$cart['showTitle']?></th>
        </tr>
        <tr>
            <td colspan="4" ><span><?=$info['theaterName']?></span> | <?=$info['theaterAd']?> | <?=$info['theaterCity']?> - <?=$info['postalCode']?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Date de représentation :</th>
            <td colspan="4" scope="row"><?=$cart['date']?></td>
        </tr>
        <tr>
            <th>Heure :</th>
            <td  colspan="4" scope="row"><?=$cart['time']?></td>

        </tr>
        <tr>
            <th>Nombre de places :</th>
            <td  colspan="4" scope="row"><?=$cart['nbPlaces']?></td>

        </tr>
        <tr>
            <th>Total :</th>
            <td  colspan="4" scope="row"><span><?=$total?> €</span></td>

        </tr>
    </table>
    <div class="flex space-between">
        <a href="#">Modifier ma réservation</a>
        <button type ="submit" class="btn btn-dark btn-lg mb-3" >Valider ma réservation</button>
    </div>

</main>
<?php
}
?>