<?php

function connect_db()
{
    require_once ('_config.php');
    $pdo = new PDO(DSN,USER, PASS);
    return $pdo;
}



//----- REQUETES SQL ------//

function selectAllFromSql($table)
{   
    $pdo = connect_db();
    $query = ("SELECT * FROM $table");
    $statement = $pdo ->query ($query);
    $array = $statement -> fetchAll(PDO::FETCH_ASSOC);
    return $array;
}

function selectAllOrderByName($table, $column)
{
    $pdo = connect_db();
    $query = "SELECT * from $table ORDER BY $column";
    $statement = $pdo ->query($query);
    $array = $statement -> fetchAll(PDO::FETCH_ASSOC);
    return $array;
}

?>