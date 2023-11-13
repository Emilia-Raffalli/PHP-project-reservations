<?php
 
 require_once ('_config.php');
 require_once ('function.php');

 echo "coucou !";

$pdo = connect_db();


$query = ("SELECT * FROM theaters");
$statement = $pdo ->query ($query);
$tableTheaters = $statement -> fetchAll(PDO::FETCH_ASSOC);

var_dump($tableTheaters);



?>