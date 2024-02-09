<?php

session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=coupart','root','root');
}catch(Exception $e){
   die('Veuillez vérifee votre serveur :'.$e->getMessage());
}


if(isset($_POST['valider'])){
    if(!empty($_POST['lastname']) AND !empty($_POST['firstname']) AND !empty($_POST['email']) AND !empty($_POST['password'])){
    $user_lastname = htmlspecialchars($_POST['lastname']);
    $user_firstname =  htmlspecialchars($_POST['firstname']);
    $user_email = htmlspecialchars($_POST['email']);
    $user_password = password_hash($_POST['password'] , PASSWORD_DEFAULT);


    $userRecup = $bdd->prepare('SELECT email FROM patients WHERE email = ?');
    $userRecup->execute(array($user_email));

    if($userRecup->rowCount() == 0){
        $userInsert = $bdd->prepare('INSERT INTO patients (Nom,Prenom,Email,MotDePasse) VALUES (?,?,?,?)');
        $userInsert->execute(array($user_lastname,$user_firstname,$user_email,$user_password));

        $userExcite = $bdd->prepare('SELECT id FROM patients WHERE nom = ? AND prenom =? AND email = ?');
        $userExcite->execute(array($user_lastname,$user_firstname,$user_email));

        $userInfo = $userExcite->fetch();

        $_SESSION['auth'] = true;
        $_SESSION['id'] =$userInfo['id'];
        $_SESSION['lastname'] =$userInfo['Nom'];
        $_SESSION['firstname'] =$userInfo['Prenom'];
        $_SESSION['email'] = $userInfo['Email'];

        header('Location:connexion.php');
      





    }else{
        $errorMsg = "vous avez déja un compte ";
    }
}else{

    $errorMsg = "Veuillez remplir tous les champs...";
}


}
?>





<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<style>
a {
    text-decoration: none;
}

div {
    color: black;
}

.navbar-nav li:not(:last-child) {
    margin-right: 30px;
}
</style>
<?php
require('navbar.php')
?>
    <?php if(isset($errorMsg)) {echo '<p>'.$errorMsg.'</p>';}?>

<form method="POST">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Inscription</h2>
                <div class="form-group">
                    <label for="Nom"><b>Nom</b></label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="Prenom"><b>Prénom</b></label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="Email"><b>Email</b></label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="MotDePasse"><b>Mot de passe</b></label>
                    <input type="password" class="form-control" name="password"  >
                </div>
                <button type="submit" class="btn btn-success" name="valider">S'inscrire</button>
                <br>
                
                <a href="connexion.php">Connectez-vous</a>
            </div>
        </div>
    </div>
</form>
   
</body>
</html>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
