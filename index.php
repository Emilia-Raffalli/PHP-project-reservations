<?php
session_start();
include ('templates/header.php');
include ('templates/footer.php');

// On prolonge la session
if(empty($_SESSION['email'])) 
{
  header('Location:login.php');
  exit();
}
// var_dump($_SESSION);

$tableTheaters = selectAllFromSql('theaters');
$tableShows = selectAllFromSql('shows');


?>


<h2>Bienvenue <?=$_SESSION['firstName']?>, tous les spectacles à découvrir.</h2>

<main>
<!-- AFFICHER TOUS LES SPECTACLES DE LA TABLE PAR LEUR IMAGE -->

<div class="flex-row flex-wrap justify-center">
    <?php foreach ($tableShows as $show): ?>
        <div class="card m-3" style="width: 18rem; box-shadow: 5px 5px 5px #dcdcdc; ">
            <a href="details.php?id=<?= $show['id_show'] ?>">
                <img class='poster' src="<?= $show['imageData'] ?>" class="card-img-top" alt="...">
            </a>
            <div class="card-body flex space-between align-center">
                <a class="link-offset-2 link-underline link-underline-opacity-25" href="details.php?id=<?= $show['id_show'] ?>">Découvrir</a>
                <a class='btn btn-dark' href="details.php?id=<?= $show['id_show'] ?>">Réserver</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>



</main>






