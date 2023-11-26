<?php
session_start();
include('function.php');


if ((isset($_GET['id'])) && !empty($_GET['places'])) {
    $id = $_GET['id'];
    $nbPlaces = $_GET['places'];
// var_dump($_GET);

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

    $placesArray = [$place1, $place2, $place3, $place4, $place5];
    $total = sum($placesArray);
    // echo $total;



}
    
if (isset($_SESSION['cart'])) {
    echo "Le panier existe !";
    $carts = $_SESSION['cart'];
} else {
    $carts = [];  // Initialisez le panier comme un tableau vide si la session n'existe pas encore
}

$carts[$id] = [
    'nbPlaces' => $nbPlaces,
    'totalPrice' => $total
];

$_SESSION['cart'] = $carts;

header('Location:cart.php');
exit();

?>
