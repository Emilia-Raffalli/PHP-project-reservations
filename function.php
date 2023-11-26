<?php

function connect_db()
{
    require_once ('_config.php');
    $pdo = new PDO(DSN,USER, PASS);
    return $pdo;
}



//----- REQUETES SQL ------//

function selectAllFromSql($table)
{   
    $pdo = connect_db();
    $query = ("SELECT * FROM $table");
    $statement = $pdo ->query ($query);
    $array = $statement -> fetchAll(PDO::FETCH_ASSOC);
    return $array;
}

function selectAllOrderByName($table, $column)
{
    $pdo = connect_db();
    $query = "SELECT * from $table ORDER BY $column";
    $statement = $pdo ->query($query);
    $array = $statement -> fetchAll(PDO::FETCH_ASSOC);
    return $array;
}



function selectFromId(string $table, string $idName, $id): array
{
    $pdo = connect_db();
    $query = ("SELECT * FROM $table WHERE $idName = :id");
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement ->execute();
    $array = $statement->fetch(PDO::FETCH_ASSOC); //fetchAll affiche tous les array | fetch n'affiche que le premier tableau
    return $array;
}



//selectionner toutes les informations reliées à une representation
function selectAllShowInfoFromIdRe($id)
{
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
        return $show = $statement->fetch(PDO::FETCH_ASSOC);
        // var_dump($info);
    } else {
        echo "Erreur dans la requête.";
    }
}




function selectFetchAllFromId(string $table, string $idName, $id): array
{
    $pdo = connect_db();
    $query = ("SELECT * FROM $table WHERE $idName = :id");
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement ->execute();
    $array = $statement->fetchAll(PDO::FETCH_ASSOC); 
    return $array;
}


//----- SELECTION DU PANIER DONT ON TRAITE l'IDLA RESA ET CLIENT ------//

function selectFromCart($customerId, $representationId) {
    $pdo = connect_db();

    $query = "SELECT * FROM carts WHERE customer_id = :customer_id AND representation_id = :representation_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
    $statement->bindValue(':representation_id', $representationId, PDO::PARAM_INT);
    $statement->execute();
    $array = $statement->fetch(PDO::FETCH_ASSOC); 
    return $array;
}

//----- FONCTION AJOUT AU PANIER ------//


// function addToCart(int $customerId, int $idRepresentation, int $nbPlaces, float $total) 
// {
//         $pdo = connect_db();
//         $cartValues = selectFromCart($customerId, $idRepresentation);

//         if ($cartValues) {
// //Si il y a une valeur, mettre à jour le nombre de places et le total :
//             $newNbPlaces = $isValue['nbPlaces'] + $nbPlaces;
//             $newTotal = $isValue['totalPrice'] + $total;

//             $query = "UPDATE carts SET nbPlaces = :nbPlaces, totalPrice = :totalPrice WHERE customer_id = :customer_id AND representation_id = :representation_id";
//         } else {
// // Sil il n'y a pas de valeur, faire un insert :
//             $query = "INSERT INTO carts (customer_id, representation_id, nbPlaces, totalPrice) VALUES (:customer_id, :representation_id, :nbPlaces, :totalPrice)";
//         }

//         $statement = $pdo->prepare($query);
//         $statement->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
//         $statement->bindValue(':representation_id', $idRepresentation, PDO::PARAM_INT);
//         $statement->bindValue(':nbPlaces', $nbPlaces, PDO::PARAM_INT);
//         $statement->bindValue(':totalPrice', $total, PDO::PARAM_INT);
//         $statement->execute();
//         $cart = $statement->fetch(PDO::FETCH_ASSOC);
//         return $cart;
// }



//----- FONCTION MISE A JOUR PANIER ------//


function updateCart($customerId, $idRepresentation, $nbPlaces) 
{
        $pdo = connect_db();
        $cartValues = selectFromCart($customerId, $idRepresentation);

        if ($cartValues) {
            $query = "UPDATE carts SET nbPlaces = :nbPlaces WHERE customer_id = :customer_id AND representation_id = :representation_id";

            $statement = $pdo->prepare($query);
            $statement->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
            $statement->bindValue(':representation_id', $idRepresentation, PDO::PARAM_INT);
            $statement->bindValue(':nbPlaces', $nbPlaces, PDO::PARAM_INT);

            return $statement->execute();
        } else {
            return "Pas de valeur associée à la requête.";
        }
    
}


function calculateDiscountedPrice($placePrice, $discount) 
{
    $discountedPrice = $placePrice - ($discount / 100 * $placePrice);
    return $discountedPrice;
}

function sum($array) {
    return array_sum($array);
}


?>