<?php
session_start();
$id = $_GET['id'];

if (isset($_GET['id']) && isset($_SESSION['cart'])) {
    $carts = $_SESSION['cart'];

    if (array_key_exists($id, $carts)) {
        unset($carts[$id]);
        $_SESSION['cart'] = $carts; // Mettre à jour la session avec le nouveau tableau
        header('location:cart.php');
        die;
    }
} 

include('templates/header.php');
echo "L'élément avec l'identifiant $id n'existe pas dans le panier.";

include('templates/footer.php');

var_dump($_SESSION['cart']);
?>
