<?php
session_start();
include ('templates/header.php');
include ('templates/footer.php');

// var_dump($_POST);






if (!empty($_GET['id']) && isset($_GET['id'])){
    $id = $_GET['id'];

    //REQUÊTES DONT J'AI BESOIN :
    //---------------------------------------------------
    $discounts = selectAllFromSql('discounts');
    // var_dump($discounts);
    //---------------------------------------------------

    $pdo = connect_db();
    $query = 
    ("SELECT s.*, t.* 
        FROM shows as s 
        LEFT JOIN theaters as t 
        ON s.theater_id = t.id_theater
        WHERE id_show = :id");
    $statement = $pdo -> prepare ($query);
    $statement ->bindValue(':id', $id, PDO::PARAM_INT);
        if ($statement->execute()) {
            $showTheater = $statement -> fetch(PDO::FETCH_ASSOC);
            // var_dump($showTheater);
        } else {
            echo "Erreur lors de l'execution de la requête.";
        } 

//---------------------------------------------------
    if (!empty($_POST)) {
        $day = $_POST['day'];
        $time = $_POST['time'];

        $pdo = connect_db();
        $query = ("SELECT * FROM representations WHERE `day` = :day AND `time` = :time AND `show_id` = :id");
        $statement = $pdo->prepare($query);
        $statement->bindValue(':day', $day, PDO::PARAM_STR);
        $statement->bindValue(':time', $time, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $representation = $statement->fetch(PDO::FETCH_ASSOC);
        
            if (empty($representation)) {
                echo "Aucune correspondance trouvée pour la date et l'heure spécifiées.";
            } else {
                // var_dump($representation);
                $idRepresentation = $representation['id_representation'];
            }
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
//----------------------------------------------------------


        $day = new DateTime($representation['day']);
        // Créer un formateur de date international en français
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN);
        $startDateInLetters = $formatter->format($day);

        // j'affiche les prix en fonction des catégories : 

        if (isset($showTheater['priceCat1'], $showTheater['priceCat2'], $showTheater['priceCat3'])) {
            $priceCat1 = $showTheater['priceCat1'];
            $priceCat2 = $showTheater['priceCat2'];
            $priceCat3 = $showTheater['priceCat3'];
            $placePrice = $showTheater['placePrice'];
        }

    }

}
?>

<table class="table tb-resa table-striped col-4">
  <thead>
    <tr>
        <th colspan="4" scope="col"> <?=$showTheater['showTitle']?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td colspan="4" scope="row"><?=$representation['day']?> - <?=$representation['time']?></td>
    </tr>
    <tr>
        <th>Nombre de places</th>
        <th>Catégorie</th>
        <th>Tarifs</th>
        <th>Total</th>
    </tr>
    <tr>
        <th>
            <a href="action.php?id=<?=$idRepresentation?>&action=del&price=<?=$priceCat1?>">
                <button type="submit" name="action" value="suppr" class="btn btn-spectators btn-dark">-</button> 
            </a>
            1
            <a href="action.php?id=<?=$idRepresentation?>&action=add&price=<?=$priceCat1?>">
                <button type="submit" name="action" value="add&price=<?=$priceCat1?>" class="btn btn-spectators btn-dark">+</button> 
            </a>
        </th>
        <td>
            <?php if ($priceCat1 > 0) : ?>
                CAT 1 : <?=$priceCat1?> €
            <?php else : ?>
                -
            <?php endif; ?>
        </td>
        <td>
            <select class="form-select discounts " name="discount" id="discount">
                <option value ="" selected disabled hidden>Tarifs</option>
                <?php foreach($discounts as $discount) :?>
                <option value ="<?= $discount['id_discount']?>"><?=$discount['selectDiscount']?></option>
                <?php endforeach; ?>                        
            </select>
        </td>
        <td>
            total
        </td>

    </tr>
    <tr>
         <th>
            <a href="action.php?id=<?=$idRepresentation?>&action=del&price=<?=$priceCat2?>">
                <button type="submit" name="action" value="suppr" class="btn btn-spectators btn-dark">-</button> 
            </a>
            0
            <a href="action.php?id=<?=$idRepresentation?>&action=add&price=<?=$priceCat2?>">
                <button type="submit" name="action" value="add" class="btn btn-spectators btn-dark">+</button> 
            </a>
        </th>
        <td>
            <?php if ($priceCat2 > 0) : ?>
                CAT 2 : <?=$priceCat2?> €
            <?php else : ?>
                -
            <?php endif; ?>
        </td>
        <td>
            <select class="form-select discounts " name="discount" id="discount">
                <option value ="" selected disabled hidden>Tarifs</option>
                <?php foreach($discounts as $discount) :?>
                <option value ="<?= $discount['id_discount']?>"><?=$discount['selectDiscount']?></option>
                <?php endforeach; ?>                        
            </select>
        </td>
        <td>
            total
        </td>
    </tr>
    <tr>
         <th>
            <a href="action.php?id=<?=$idRepresentation?>&action=del&price=<?=$priceCat3?>">
                <button type="submit" name="action" value="suppr" class="btn btn-spectators btn-dark">-</button> 
            </a>
            1
            <a href="action.php?id=<?=$idRepresentation?>&action=add&price=<?=$priceCat3?>">
                <button type="submit" name="action" value="add" class="btn btn-spectators btn-dark">+</button> 
            </a>
        </th>
        <td>
            <?php if ($priceCat3 > 0) : ?>
                CAT 1 : <?=$priceCat3?> €
            <?php else : ?>
                -
            <?php endif; ?>
        </td>
        <td>
            <select class="form-select discounts " name="discount" id="discount">
                <option value ="" selected disabled hidden>Tarifs</option>
                <?php foreach($discounts as $discount) :?>
                <option value ="<?= $discount['id_discount']?>"><?=$discount['selectDiscount']?></option>
                <?php endforeach; ?>                        
            </select>
        </td>
        <td>
            total
        </td>

    </tr>
    <tr>
        <th>
            <a href="action.php?id=<?=$idRepresentation?>&action=del&price=<?=$placePrice?>">
                <button type="submit" name="action" value="suppr" class="btn btn-spectators btn-dark">-</button> 
            </a>
            1
            <a href="action.php?id=<?=$idRepresentation?>&action=add&price=<?=$placePrice?>">
                <button type="submit" name="action" value="add" class="btn btn-spectators btn-dark">+</button> 
            </a>
        </th>
        <td>
            <?=$placePrice?> €
        </td>
        <td>
            <select class="form-select discounts " name="discount" id="discount">
                <option value ="" selected disabled hidden>Tarifs</option>
                <?php foreach($discounts as $discount) :?>
                <option value ="<?= $discount['id_discount']?>"><?=$discount['selectDiscount']?></option>
                <?php endforeach; ?>                        
            </select>
        </td>
        <td>
            total
        </td>

    </tr>
  </tbody>
</table>



<?php
//-------------------AJOUT AU PANIER -----------------------------//


























//----------------- FIN AJOUT AU PANIER --------------------//

?>