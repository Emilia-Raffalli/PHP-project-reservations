<?php
session_start();
include('templates/header.php');
include('templates/footer.php');

$customerId = $_SESSION['id_customer'];
// echo $customerId;
var_dump($_GET);

if (!empty($_GET) && isset($_GET['id'])) {
    $idRepresentation = $_GET['id'];
    $action = $_GET['action'];
    $total = $_GET['price'];

    // Récupérer les détails de la représentation depuis la base de données
    $representation = selectFromId('representations', 'id_representation', $idRepresentation);
    // var_dump($representation);
    $nbPlacesMax = $representation['nbPlacesMax'];

    // Récupérer le panier actuel de l'utilisateur
    $customerId = $_SESSION['id_customer'];
    $cartValues = selectFromCart($customerId, $idRepresentation);
    $nbPlaces = $cartValues['nbPlaces'];
    // var_dump($cartValues);

    // Si l'entrée existe déjà dans le panier, mettre à jour le nombre de places
    if ($cartValues) {

        if ($action == 'add') {
            // Vérifier si le nombre de places est inférieur à la limite maximale
            if ($nbPlaces < $nbPlacesMax) {
                $nbPlaces++;
                updateCart($customerId, $idRepresentation, $nbPlaces);
            } else {
                echo "Nombre maximal de places atteint.";
            }
        } elseif ($action == 'suppr') {
            // Vérifier si le nombre de places est supérieur à 0 avant de décrémenter
            if ($nbPlaces > 0) {
                $nbPlaces--;
                updateCart($customerId, $idRepresentation, $nbPlaces);
            } else {
                echo "Nombre minimal de places atteint.";
            }
        }
    } else {
        // Si l'entrée n'existe pas dans le panier, l'ajouter
        if ($action == 'add') {
            $nbPlaces = 1;
            addToCart($customerId, $idRepresentation, $nbPlaces, $total);
        }
    }

    // Rediriger vers la page du panier ou effectuer d'autres opérations
    // header('Location: reservation.php');
    // exit();
}
else {
    echo "Pas de données dans l'url.";
}


?>


<table class="table tb-resa table-striped col-4">
    <thead>
        <tr>
            <th colspan="4" scope="col"> </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4" scope="row"></td>
        </tr>
        <tr>
            <th>Nombre de places</th>
            <th>Catégorie</th>
            <th>Tarifs</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>
                <?=$nbPlaces?>                
            </td>
            <td>
                <?=$nbPlaces?> 
            </td>
            <td>
                <?=$nbPlaces?> 
            </td>
            <td>
            <?=$total?>
            </td>

        </tr>
    </tbody>
</table>