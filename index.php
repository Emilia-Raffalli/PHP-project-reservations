<?php
 
include ('templates/header.php');
include ('templates/footer.php');


$tableTheaters = selectAllFromSql('theaters');


var_dump($tableTheaters);



?>

