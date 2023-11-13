<?php

function connect_db()
{
    require_once ('_config.php');
    $pdo = new PDO(DSN,USER, PASS);
    return $pdo;
}



?>