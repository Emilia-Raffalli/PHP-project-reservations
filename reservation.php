<?php
session_start();
include('templates/header.php');
include('templates/footer.php');

$idCustomer = $_SESSION['id_customer'];

// var_dump($_GET);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// var_dump($_POST);

$nbplaces = 1;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $day = $_POST['day'];
    $time = $_POST['time'];
    $nbplaces = $_POST['nbPlaces'];

    $pdo = connect_db();
    $query = "SELECT r.*, s.*
            FROM representations as r 
            LEFT JOIN shows as s 
            ON r.show_id = s.id_show
            WHERE day = :day AND time = :time
            AND id_show = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':day', $day, PDO::PARAM_STR);
    $statement->bindValue(':time', $time, PDO::PARAM_STR);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    if ($statement->execute()) {
        $showRepresentation = $statement->fetch(PDO::FETCH_ASSOC);
        // var_dump($showRepresentation);
    } else {
        echo "Erreur dans la requête.";
    }

 
    if (isset($_POST['nbPlaces'])) {
        $nbPlaces = $_POST['nbPlaces'];
        $tableDiscounts = selectAllFromSql('discounts');
        // var_dump($tableDiscounts);
        $fullPrice = calculateDiscountedPrice($showRepresentation['placePrice'], $tableDiscounts[0]['discount']);
        $kidPrice = calculateDiscountedPrice($showRepresentation['placePrice'], $tableDiscounts[1]['discount']);
        $studentPrice = calculateDiscountedPrice($showRepresentation['placePrice'], $tableDiscounts[2]['discount']);
        $unemployedPrice = calculateDiscountedPrice($showRepresentation['placePrice'], $tableDiscounts[3]['discount']);
        $groupPrice = calculateDiscountedPrice($showRepresentation['placePrice'], $tableDiscounts[4]['discount']);
        ?>
<?php                    
    }
?>
    
<form action="cart.php?id=<?=$id?>&places=<?=$nbPlaces?>" method="POST" class="reservation">
    <table class="table">
        <thead>
        <tr>
            <th class="title-resa" ><?=$showRepresentation['showTitle']?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td  scope="row"><?=$day?> à <?=$time?></td>
        </tr>
        <tr>
            <th class="m-3 border-none" >
                <?php for ($i = 1; $i <= $nbPlaces ; $i++) :?>
                    <label for="tarif_place<?=$i?>">Tarif pour la Place <?=$i?> :</label>
                    <select name="tarif_place<?=$i?>" class="form-select" required>
                        <option value="" selected disabled hidden>Choisissez le tarif</option>
                            <option value="<?=$fullPrice?> €"><?=$tableDiscounts[0]['selectDiscount']?> : <?=$fullPrice?> €</option>
                            <option value="<?=$kidPrice?> €"><?=$tableDiscounts[1]['selectDiscount']?> : <?=$kidPrice?> €</option>
                            <option value="<?=$studentPrice?> €"><?=$tableDiscounts[2]['selectDiscount']?> : <?=$studentPrice?> €</option>
                            <option value="<?=$unemployedPrice?> €"><?=$tableDiscounts[3]['selectDiscount']?> : <?=$unemployedPrice?> €</option>
                            <option value="<?=$groupPrice?> €"><?=$tableDiscounts[4]['selectDiscount']?> : <?=$groupPrice?> €</option>
                    </select>
                <?php endfor; ?>
            </th>
        </tr>   
        <tr class="border-none">
            <th  class="flex-end align-end border-none"><button class="btn btn-dark btn-lg" type="submit">Voir ma réservation</button></th>
        </tr>
    </table>
</form>









<?php
    // $query = "INSERT INTO carts (customer_id, representation_id, nbPlaces, totalPrice)
    //             VALUES ( :customer_id, :representation_id, :nbPlces, :totalPrice)";
    // $statement = $pdo -> prepare($query);
    // $statement ->bindValue(':customer_id', $idCustomer, PDO::PARAM_INT);
    // $statement ->bindValue(':representation_id',$showRepresentation['id_representation'], PDO::PARAM_INT);
    // $statement ->bindValue(':nbPlaces', $$showRepresentation['nbPlaces'], PDO::PARAM_INT);
    // $statement -> bindValue (':totalPrice', $showRepresentation['totalPrice'], PDO::PARAM_STR);

    //     if ($statement -> execute()) {
    //         $cart = $statement -> fetch(PDO::FETCH_ASSOC);
    //         var_dump($carts);
    //     } else {
    //         echo "Erreur dans la requête.";
    //     }

    ?>




     















<?php

}




?>