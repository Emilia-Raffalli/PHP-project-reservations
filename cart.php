<?php
session_start();
include('templates/header.php');

// $idCustomer = $_SESSION['id_customer'];
// $id =$_GET['id'];

// $carts = $_SESSION['cart'];
// var_dump($carts);
?>
<div class="wrap">
    <main class='container'>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <?php $carts = $_SESSION['cart']?>
        <h3>Mon panier de réservations</h3>
        <p class="margin-b">Veuillez trouver ci-dessous les détails de vos réservations</p>
    
        <?php
        $pdo = connect_db();
        $totalCart=0;
        foreach ($carts as $id => $details) {
            $nbPlaces = $details['nbPlaces'];
            $totalPrice = $details['totalPrice'];
            $totalCart = $totalCart + $totalPrice;

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

                if ($show) { // Vérifier si la requête a renvoyé des résultats
                    ?>
                    <table class="table table-striped reservation">
                        <thead>
                            <tr>
                                <th colspan="2" class="title-resa"><?= $show['showTitle'] ?></th>
                            </tr>
                            <tr>
                                <td colspan="2"><span><?= $show['theaterName'] ?></span> | <?= $show['theaterAd'] ?> | <?= $show['theaterCity'] ?> - <?= $show['postalCode'] ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Date de représentation :</th>
                                <td class="right" colspan="" scope="row"><?= $show['day'] ?></td>
                            </tr>
                            <tr>
                                <th>Heure :</th>
                                <td class="right" colspan="" scope="row"><?= $show['time'] ?></td>
                            </tr>
                            <tr>
                                <th>Nombre de places :</th>
                                <td class="right" colspan="" scope="row"><?= $nbPlaces ?></td>
                            </tr>
                            <tr>
                                <th colspan="" >Total :</th>
                                <td class="right" scope="row"><span><?= $totalPrice ?> €</span></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="link-table">
                        <a class="link-table" href="edit-reservation.php?id=<?= $show['id_show'] ?>&idrep=<?=$id?>&nbSeats=<?=$nbPlaces?>">Modifier ma réservation</a>
                        <a class="link-table" href="delete.php?id=<?= $id ?>">Supprimer ma réservation</a>
                    </div>
                    
                    <?php
                } else {
                    echo "Aucun résultat trouvé pour l'ID de représentation : $id";
                }
            } else {
                echo "Erreur lors de l'exécution de la requête.";
            }
        }
        ?>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>

        <div class="border-grey right p-3 bold-lg margin-b ">
            <?=$totalCart?> €
        </div>
        <form class ="flex align-end" method="POST" action ="confirm.php?id=<?=$id?>">
            <button class="btn btn-dark" type="submit">Valider ma réservation</button>
        </form>
        <?php endif ; ?>
        <?php else: ?>
        <p>Votre panier est vide !</p>
        <?php endif; ?>
    
    </main>
</div>
<?php
include('templates/footer.php');
?>