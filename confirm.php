<?php
session_start();
include ('function.php');
// include('templates/header.php');

// include('templates/header.php');
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
    //  else {
//     // echo "Aucun id de représentation.";
// }


// var_dump($_SESSION['email']);
if (!isset($_SESSION['email'])) {
    header("location:login.php");
} else {
    $emailCust = $_SESSION['email'];
    $idCust = $_SESSION['id_customer'];
    $firstNameCust =$_SESSION['firstName'];
}
?>

<?php

// connect to database
$pdo = connect_db();


//2 query : 
$query = "SELECT * FROM customers where custEmail = '$emailCust'";
$statement = $pdo->query($query);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// get cart from session
$carts=$_SESSION['cart'];

// var_dump($user);
echo '<hr>';
// var_dump($carts);
// insert 1 row in orders 
// $query = "INSERT INTO reservations(idorder)
//     VALUES (NULL) ";
// $statement = $pdo->prepare($query);
// $statement->execute();

// get last row in orders
// $query = "SELECT * FROM orders order by idorder desc limit 1";
// $statement = $pdo->query($query);
// $order = $statement->fetch(PDO::FETCH_ASSOC);


foreach ($carts as $id => $details) {
   
   // Je vérifie si une réservation similaire existe déjà
   $allreadyDoneReservation = "SELECT * FROM reservations WHERE customer_id = :idCust AND representation_id = :representation_id AND nbPlaces = :nbPlaces";
    
   $verifyStatement = $pdo->prepare($allreadyDoneReservation);
   $verifyStatement->bindValue(':idCust', $idCust, \PDO::PARAM_INT);
   $verifyStatement->bindValue(':representation_id', $id, \PDO::PARAM_INT);
   $verifyStatement->bindValue(':nbPlaces', $details['nbPlaces'], \PDO::PARAM_INT);

   $verifyStatement->execute();
   $allreadyDoneReservation = $verifyStatement->fetch(PDO::FETCH_ASSOC);
}
   if (isset ($allreadyDoneReservation)) {
?>

<form action="confirm.php" method="post">
Il semble que vous ayez déjà réalisé cette réservation.<br>
Souhaitez-vous continuer ?"       
    <input class='btn btn-primary btn-dark' type="submit" name="continue" value="Oui">
    <input class='btn btn-primary btn-dark' type="submit" name="cancel" value="Non">
    <input type="hidden" name="nbPlaces" value="<?= $details['nbPlaces'] ?>">
</form>
<?php

if (isset($_POST['continue'])) {
    // L'utilisateur a choisi de continuer, continuez avec la réservation
    $query = "INSERT INTO reservations (customer_id, representation_id, nbPlaces, totalPrice)
    VALUES (:idCust, :representation_id, :nbPlaces, :totalPrice)";
    
    $statement = $pdo->prepare($query);
    $statement->bindValue(':idCust', $idCust, \PDO::PARAM_INT);
    $statement->bindValue(':representation_id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':nbPlaces', $details['nbPlaces'], \PDO::PARAM_INT);
    $statement->bindValue(':totalPrice', $details['totalPrice'], \PDO::PARAM_INT);

    $statement->execute();


    header('Location:thank-you.php');




} elseif (isset($_POST['cancel'])) {
    // L'utilisateur choisit d'annuler, je le redirige vers son panier.
    header('Location: cart.php'); 
    exit();
}


}







?>


<?php
include('templates/footer.php');
?>