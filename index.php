<?php
include ('templates/header.php');
include ('templates/footer.php');

$tableTheaters = selectAllFromSql('theaters');
$tableShows = selectAllFromSql('shows');

// var_dump($tableShows);
// var_dump($tableTheaters);
// var_dump($_POST);

if(isset($_POST)) {
    echo "Success!";
}

?>


<h2>Ici, tous les spectacles à découvrir.</h2>

<main>
<!-- AFFICHER TOUS LES SPECTACLES DE LA TABLE PAR LEU IMAGE -->

<div class="flex-row flex-wrap justify-center">
<?php foreach($tableShows as $show): ?>
    <div class="card m-3" style="width: 18rem; box-shadow: 5px 5px 5px #dcdcdc; ">
        <img class = 'poster' src="<?=$show['imageData']?>" class="card-img-top" alt="...">
        <div class="card-body flex space-between align-center">
            <a class="link-offset-2 link-underline link-underline-opacity-25" href="details.php?id=<?=$show['id_show']?>">Découvrir</a>
            <a class='btn btn-dark' href="reservation.php">Je réserve !</a>
        </div>
    </div>
<?php endforeach; ?>
</div>



</main>






