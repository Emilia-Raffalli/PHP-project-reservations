<?php
include('templates/header.php');
include('templates/footer.php');


if ((isset($_GET['id'])) && !empty($_GET['places'])) {
    $id = $_GET['id'];
    $nbPlaces = $_GET['places'];


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




    
    if (isset($_SESSION['cart'])) {
        echo "Le panier existe !";
        // var_dump($_SESSION['cart']);
        $carts = $_SESSION['cart'];

        // var_dump($carts);
        // Ajouter ou mettre à jour les nouvelles valeurs
        // $carts[$id] = $nbPlaces;
        $carts[$id] = [
            'nbPlaces' => $nbPlaces,
            'totalPrice' => $total
        ];
    
        // Enregistrez le panier mis à jour dans la session
        $_SESSION['cart'] = $carts;
        var_dump($carts);
    } else {
        echo "Rien dans le panier";
    }
    
    // var_dump($_SESSION);

}

header('Location:cart.php');
exit();

// Si vous souhaitez enregistrer les détails du spectacle dans la session
// Vous pouvez décommenter ce bloc et l'adapter selon vos besoins
/*
if (isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        'showTitle' => $info['showTitle'],
        'date' => $info['day'],
        'time' => $info['time'],
        'nbPlaces' => $nbPlaces,
        'totalPrice' => $total
    ];
    var_dump($_SESSION['cart']);
} else {
    $_SESSION['cart'] = [
        'showTitle' => $info['showTitle'],
        'date' => $info['day'],
        'time' => $info['time'],
        'nbPlaces' => $nbPlaces,
        'totalPrice' => $total
    ];
}
*/

// Si vous souhaitez rediriger l'utilisateur après le traitement, vous pouvez décommenter ces lignes
// header('Location: cart.php?id=' . $id);
// exit();

// Sinon, vous pouvez afficher un message comme celui-ci :
// echo "Tarifs non renseignés.";

// var_dump($_SESSION);
?>
