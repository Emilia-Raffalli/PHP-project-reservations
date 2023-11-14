<?php
include ('templates/header-connect.php');
?>

<div class="login flex-column-center">
    <p>MoreShows</p>
    <h1>Connexion</h1>
    <p>Veuillez entrer vos identifiants de connexion.</p>

    <form class="login flex-column-center" method="POST">
        <label for="login" class="form-label"></label>
        <input type="login" class="form-control" id="login" placeholder="Identifiant">
        <label for="password" class="form-label"></label>
        <input type="password" class="form-control" id="password" name ="password" Placeholder="Mot de passe">
        <button type="submit" class="btn btn-dark">Connexion</button>
    </form>

</div>