<?php
 
include ('templates/header.php');
include ('templates/footer.php');

$tableTheaters = selectAllOrderByName('theaters','theaterName');

// var_dump($tableTheaters);

?>


<main>

<h1>Nouveau spectacle</h1>
<form method="POST">
    <div class="mb-3">
        <label for="showTitle" class="form-label"></label>
        <input type="text" class="form-control" id="showTitle" name="showTitle" placeholder="Titre du spectacle" required>
    </div>
    <div class="mb-3">
        <label for="theater" class="form-label"></label>
        <select id="theater" name="theater" class="form-select">
            <option value="" selected disabled hidden>Lieu de représentation</option>

            <?php
            if (isset($tableTheaters))
            {
                foreach($tableTheaters as $theater)
                {
                    echo "<option value=" . $theater['id_theater'] . " > " .$theater['theaterName'];
                }
            }
            else {
                echo "Rien à afficher";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label"></label>
        <textarea class="form-control" id="description" rows="3" name ="description" Placeholder="description" required></textarea>
    </div>
    <div class="mb-3">
        <div class="mb-3">
            <label for="duration" class="form-label">Durée du spectacle</label>
            <input type="time" min="00:15" max="05:00" required class="form-control" id="duration" name ="duration" placeholder="Durée du spectacle">
        </div>
        <div class="mb-3">
            <label for="startDate">Début de période</label>
            <input type="date" id="startDate" name="startDate" class="form-control" value="2022-01-01" min="2021-01-01" max="2025-12-31" />
            <label for="endDate">Fin de période</label>
            <input type="date" id="endDate" name="endDate" class="form-control" value="2023-12-31" min="2023-12-31" max="2025-12-31" />
        </div>
    </div>

    <div class="mb-3 flex-row">
        <div class="m-3">
            <label for="placePrice">Prix - placement libre</label>
            <input type="text" id="placePrice" name="placePrice" class="form-control">
        </div>
        <div class="m-3">
            <label for="priceCat1">Prix catégorie 1</label>
            <input type="text" id="priceCat1" name="priceCat1" class="form-control">
        </div>
        <div class="m-3">
            <label for="priceCat2">Prix catégorie 2</label>
            <input type="text" id="priceCat2" name="priceCat2" class="form-control">
        </div>
        <div class="m-3">
            <label for="priceCat3">Prix catégorie 3</label>
            <input type="text" id="priceCat3" name="priceCat3" class="form-control">
        </div>
    </div>

    <button type="submit" class="btn mb-3 btn-dark">Enregistrer</button>




</form>

</main>