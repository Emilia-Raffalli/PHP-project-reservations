<?php
session_start();
include ('templates/header.php');

// var_dump($_POST);

?>

<h2> Merci <?=$_SESSION['firstName']?> pour votre réservation !</h2>
<p class='text-center'> Notre service client est disponible pour tout complément d'information.</p>
<p class='text-center' ><a  href = "mes-reservations.php">Voir ma réservation</a></p>
