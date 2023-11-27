<?php
session_start();
include ('templates/header.php');
?>

<?php
$idCustomer = $_SESSION['id_customer'];

$pdo = connect_db();
$customer = selectFromId( 'customers', 'id_customer', $idCustomer);
?>

<div class="wrap">
    <div class="flex flex-column">
        <h2> Mon compte</h2>
        <a href = "mes-reservations.php">Mes réservations</a>
    </div>

<table class='table'>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
        </tr>
        <tr>
            <th><?=$customer['custLastName']?></th>
            <th><?=$customer['custFirstName']?></th>
            <th><?=$customer['custEmail']?></th>
            <th><?=$customer['custPhone']?></th>
        </tr>

    </thead>
</table>

</div>


<?php
include ('templates/footer.php');
?>