<?php
session_start();
include('function.php');


if (isset($_SESSION['cart'])) {
    $carts = $_SESSION['cart'];
    // var_dump($carts);

    // $carts =[]; // supprimer tout le tableau.
    // var_dump($carts);

    // array_pop($carts);//Supprimer la dernière ligne du panier
    // array_shift($carts); // Supprimer la première ligne
    // unset($carts[key($cart)]);//Supprimer la première ligne en conservant l'index
    // var_dump($carts);
}
 

if (((isset($_GET['idup'])) && isset($_GET['idto'])) && !empty($_GET['places'])) {
    $idup = $_GET['idup'];
    $id = $_GET['idto'];
    $nbPlaces = $_GET['places'];
    echo "test".$idup;


var_dump($_GET);

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



    // var_dump($_SESSION['cart']);

    echo "test".$idup;
    if (isset($_SESSION['cart'][$idup])) {
        $_SESSION['cart'][$id] = [
            'nbPlaces' => $nbPlaces,
            'totalPrice' => $total
        ];

        unset($_SESSION['cart'][$idup]);
    }

   header('Location: cart.php');
    exit();
}



    include('templates/footer.php');


?>





<!-- 

    header('Location: cart.php?id=' . $id);
    exit();
} else {
    echo "Erreur.";
} -->