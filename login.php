<?php
include('templates/header-connect.php');

// var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = connect_db();
    $query = "SELECT * FROM customers WHERE custEmail = :email";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);

    if ($statement->execute()) {
        $customer = $statement->fetch(PDO::FETCH_ASSOC);
        var_dump($customer);

        if ($customer && $password == $customer['custPassword']) {
            echo "Connexion réussie !";   
            session_start();
            $_SESSION['id_customer'] = $customer['id_customer']; 
            $_SESSION['email'] = $customer['custEmail'];  
            $_SESSION['firstName'] = $customer['custFirstName'];
            
            header("Location: index.php");
            exit();
        } else {
            echo "Email ou mot de passe invalide.";
        }
    } else {
        echo "Erreur dans la requête.";
    }
}
?>

<div class="login flex-column-center">
    <p>MyShows</p>
    <h1>Connexion</h1>
    <p>Veuillez entrer vos identifiants de connexion.</p>

    <form class="login flex-column-center" method="POST">
        <label for="email" class="form-label"></label>
        <input type="login" class="form-control-login form-control" name="email" id="email" placeholder="Email">
        <label for="password" class="form-label"></label>
        <input type="password" class="form-control-login form-control" id="password" name ="password" Placeholder="Mot de passe">
        <button type="submit" class="btn btn-dark">Connexion</button>
    </form>

</div>