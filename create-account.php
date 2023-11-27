<?php
session_start();
include('templates/header-connect.php');

// var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($lastName) || empty($firstName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        echo "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
    } else {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $pdo = connect_db();
    $query = "INSERT INTO customers (custLastName, custFirstName, custEmail, custPhone, custPassword)
    VALUES (:lastname, :firstname , :email , :phone , :password)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':lastname', $lastName, PDO::PARAM_STR);
    $statement->bindValue(':firstname', $firstName, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
    $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);


    if ($statement->execute()) {
        header("Location: account-success.php");
        exit();
    } else {
        echo "Erreur lors de la création du compte.";
    }
}
}

// var_dump($customer);

        // if ($customer && $password == $customer['custPassword']) {
        //     echo "Connexion réussie !";   
        //     session_start();
        //     $_SESSION['id_customer'] = $customer['id_customer']; 
        //     $_SESSION['email'] = $customer['custEmail'];  
        //     $_SESSION['firstName'] = $customer['custFirstName'];
            
            // header("Location: index.php");
            // exit();
    //     } else {
    //         echo "Email ou mot de passe invalide.";
    //     }
    // } else {
    //     echo "Erreur dans la requête.";
    // }

?>

<div class="login flex-column-center">
    <p>MyShows</p>
    <h1>Création de compte</h1>
    <p>Créez votre compte en renseignant vos informations.</p>

    <form class="login flex-column-center" method="POST">
        <label for="lastName" class="form-label"></label>
        <input type="text" class="form-control-login form-control" name="lastName" id="lastName" placeholder="Nom">
        <label for="firstName" class="form-label"></label>
        <input type="text" class="form-control-login form-control" name="firstName" id="firstName" placeholder="Prénom">
        <label for="email" class="form-label"></label>
        <input type="login" class="form-control-login form-control" name="email" id="email" placeholder="Email">
        <label for ="phone" class="form-label"></label>
        <input type="tel" class="form-control-login form-control" id ="phone" name="phone" placeholder ="Téléphone">
        <label for="password" class="form-label"></label>
        <input type="password" class="form-control-login form-control" id="password" name ="password" Placeholder="Mot de passe">
        <label for="confirmPassword" class="form-label"></label>
        <input type="password" class="form-control-login form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmez le mot de passe">
        <button type="submit" class="btn btn-dark">Je crée mon compte</button>
    </form>
</div>