<?php
 
include ('templates/header.php');
include ('templates/footer.php');

$tableTheaters = selectAllOrderByName('theaters','theaterName');
$tableCategories = selectAllOrderByName('categories','category');

var_dump($_POST);

if (isset($_POST) && !empty($_POST)) {
    $showTitle = $_POST['showTitle'];
    $idCategory =$_POST['category'];
    $imageData = $_POST['imageDataPath'];
    $idTheater = $_POST['theater'];
    $description = $_POST['description'];
    $artists = $_POST['artists'];
    $duration = $_POST['duration'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $placePrice = $_POST['placePrice'];
    $priceCat1 = $_POST['priceCat1'];
    $priceCat2 = $_POST['priceCat2'];
    $priceCat3 = $_POST['priceCat3'];




    $pdo = connect_db();
    $query = 'INSERT INTO shows (showTitle, startDate, endDate, description, artists, imageData, duration, placePrice, priceCat1, priceCat2, priceCat3, theater_id) VALUES (:showTitle, :startDate, :endDate, :description, :artists, :imageDataPath, :duration, :placePrice, :priceCat1, :priceCat2, :priceCat3, :theater_id)';
    $statement = $pdo ->prepare ($query);
    $statement->bindValue(':showTitle', $showTitle, PDO::PARAM_STR);
    $statement->bindValue(':startDate', $startDate, PDO::PARAM_STR);
    $statement->bindValue(':endDate', $endDate, PDO::PARAM_STR);
    $statement->bindValue(':description', $description, PDO::PARAM_STR);
    $statement->bindValue(':artists', $artists, PDO::PARAM_STR);
    $statement->bindValue(':imageDataPath', $imageData, PDO::PARAM_STR);
    $statement->bindValue(':duration', $duration, PDO::PARAM_STR);
    $statement->bindValue(':placePrice', $placePrice, PDO::PARAM_STR);
    $statement->bindValue(':priceCat1', $priceCat1, PDO::PARAM_STR);
    $statement->bindValue(':priceCat2', $priceCat2, PDO::PARAM_STR);
    $statement->bindValue(':priceCat3', $priceCat3, PDO::PARAM_STR);
    $statement->bindValue(':theater_id', $idTheater, PDO::PARAM_INT);
    $statement ->execute();
    $array = $statement -> fetch(PDO::FETCH_ASSOC);

    var_dump($array);

    $lastInsertId = $pdo->lastInsertId();

    echo "voici le dernier id généré :" . $lastInsertId ;


    // $pdo = null;



}
// $query = 'INSERT INTO shows_categories


 // :category_id,
// $statement->bindValue(':category_id', $idCategory, PDO::PARAM_INT);













?>


<main>

<h1>Nouveau spectacle</h1>
<form  action ="edit.php" method="POST" class="self-end">
        <div class="mb-3">
            <label for="showTitle" class="form-label"></label>
            <input type="text" class="form-control" id="showTitle" name="showTitle" placeholder="Titre du spectacle" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label"></label>
            <select id="category" name="category" class="form-select" multiple required>
            <option value="" selected disabled hidden>Catégorie de spectacle</option>
            <?php
                if (isset($tableCategories))
                {
                    foreach($tableCategories as $category)
                    {
                        echo "<option value=" . $category['id_category'] . " > " .$category['category'];
                    }
                }
                else {
                    echo "Rien à afficher";
                }
                ?>
            </select>
        </div>
        <div>
            <label for ="imageDataPath"></label>
            <input type="text" class="form-control" name="imageDataPath" id="imageDataPath" Placeholder ="Chemin de l'image">
        </div>
        <div class="mb-3">
            <label for="theater" class="form-label"></label>
            <select id="theater" name="theater" class="form-select" required>
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
            <label for="artists" class="form-label"></label>
            <textarea class="form-control" id="artists" rows="3" name ="artists" Placeholder="Noms des artistes" required></textarea>
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

        <p>Prix des places</p>
        <div class=" mb-3 flex-row wrap space-between">
            <div class="margin">
                <label for="placePrice">Placement libre</label>
                <input type="text" id="placePrice" name="placePrice" class="form-control new-show">
            </div>
            <div class="margin">
                <label for="priceCat1">Catégorie 1</label>
                <input type="text" id="priceCat1" name="priceCat1" class="form-control new-show">
            </div>
            <div class="margin">
                <label for="priceCat2">Catégorie 2</label>
                <input type="text" id="priceCat2" name="priceCat2" class="form-control new-show">
            </div>
            <div class="margin">
                <label for="priceCat3">Catégorie 3</label>
                <input type="text" id="priceCat3" name="priceCat3" class="form-control new-show">
            </div>
        </div>
        <div class="flex align-end">
            <button type="submit" class="btn mb-3 btn-dark self-end">Enregistrer</button>
        </div>           
</form>

</main>