<?php
session_start();
$customerId = $_SESSION['id_customer'];
echo $customerId;

include('templates/header.php');
include('templates/footer.php');

// POUR REMPLIR MA TABLE CARTS, J'ai besoin de l'id de la représentation, l'id du client, le nombre de places et le total

if (!empty($_GET) && isset($_GET['id'])) {
    $idRepresentation = $_GET['id'];
    $action = $_GET['action'];
    $total = $_GET['price'];
    // echo $idRepresentation;

    $representation = selectFromId('representations', 'id_representation', $idRepresentation);
    // var_dump($representation);

    $nbPlacesMax = $representation['nbPlacesMax'];

    // Récupération du nombre de places actuel depuis la table carts
    $cart = selectFromCart($customerId, $idRepresentation);
    $nbPlaces = $cart ? $cart['nbPlaces'] : 0;

    // Action add : 
    if ($action == 'add') {
        $nbPlaces++;

        $pdo = connect_db();
        $query = "INSERT INTO carts (customer_id, representation_id, nbPlaces, totalPrice)
                    VALUES (:customer_id, :representation_id, :nbPlaces, :total)
                    ON DUPLICATE KEY UPDATE nbPlaces = :nbPlaces, totalPrice = :total";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
        $statement->bindValue(':representation_id', $idRepresentation, PDO::PARAM_INT);
        $statement->bindValue(':nbPlaces', $nbPlaces, PDO::PARAM_INT);
        $statement->bindValue(':total', $total, PDO::PARAM_INT);

        if ($statement->execute()) {
            echo "Insertion réussie!";
            // Mise à jour de la liste après l'ajout
            $carts = selectAllFromSql('carts');
            var_dump($carts);
            // header('location:reservation.php');
        } else {
            echo "Erreur dans le script.";
        }
    }

    // Action suppr : 
    if ($action == 'suppr') {
        if ($nbPlaces > 0) {
            $nbPlaces--;

            $pdo = connect_db();
            $query = "INSERT INTO carts (customer_id, representation_id, nbPlaces, totalPrice)
                        VALUES (:customer_id, :representation_id, :nbPlaces, :total)
                        ON DUPLICATE KEY UPDATE nbPlaces = :nbPlaces, totalPrice = :total";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->bindValue(':representation_id', $idRepresentation, PDO::PARAM_INT);
            $statement->bindValue(':nbPlaces', $nbPlaces, PDO::PARAM_INT);
            $statement->bindValue(':total', $total, PDO::PARAM_INT);

            if ($statement->execute()) {
                echo "Retrait réussi!";
                // Mise à jour de la liste après la suppression
                $carts = selectAllFromSql('carts');
                var_dump($carts);
                // header('location:reservation.php');
            } else {
                echo "Erreur dans le script.";
            }
        }
    }
}

// Liste initiale en dehors de la condition pour la première exécution
$carts = selectAllFromSql('carts');
var_dump($carts);
?>







        <!-- //Je récupère le nombre de places actuelles
        // $query = "SELECT nbPlaces FROM reservations WHERE id_reservation = :id";
        // $statement = $pdo->prepare($query);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        // $statement->execute();
        // $reservation = $statement->fetch(PDO::FETCH_ASSOC);
        // $nbPlaces = $$reservation['nbPlaces'];



        // // Je mets à jour le nombre de places en fonction de l'action add
        // if ($_POST['action'] === 'add') {
        //     $newPlaceNumber = $nbPlaces + 1;
        // } elseif ($_POST['action'] === 'suppr' && $currentPlaceNumber > 0) {
        //     $newPlaceNumber = $currentPlaceNumber - 1;
        // } else {
        //     $newPlaceNumber = $currentPlaceNumber;
        // }

        // // Mettez à jour le nombre de places dans la base de données
        // $updateQuery = "UPDATE reservations SET placeNumber = :newPlaceNumber WHERE id_reservation = :id";
        // $updateStatement = $pdo->prepare($updateQuery);
        // $updateStatement->bindValue(':newPlaceNumber', $newPlaceNumber, PDO::PARAM_INT);
        // $updateStatement->bindValue(':id', $id, PDO::PARAM_INT);
        // $updateStatement->execute();

        // Redirigez l'utilisateur ou effectuez d'autres opérations après la mise à jour
        // header("Location: votre_page.php");
        // exit();
    // }
// } -->



