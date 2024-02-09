
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=coupart','root','root');

}catch(Exception $e){
die('Weuillez vérifee votre serveur :' .$e->getMessage());

}
if(isset($_POST['Valider'])){
    if(!empty($_POST['email']) AND !empty($_POST['password'])){

        $user_email = htmlspecialchars($_POST['email']);
        $user_password = htmlspecialchars($_POST['password']);

        $userExcite = $bdd->prepare('SELECT * FROM patients WHERE email = ?');
        $userExcite->execute(array($user_email));

        if($userExcite->rowCount() > 0){
            $userInfo = $userExcite->fetch();
          if(password_verify($user_password,$userInfo['MotDePasse'])){

            $_SESSION['auth'] = true;
            $_SESSION['id'] = $userInfo['id'];
            $_SESSION['lastname'] = $userInfo['Nom'];
            $_SESSION['firstname'] = $userInfo['Prenom'];
            $_SESSION['email'] = $userInfo['Email'];


            header('Location: espace_personnel.php?id=' . $_SESSION['id']);
            exit();
            

          }else{
            $errorMsg = "vous identifiant sont incorrecte ";
          }

        }else{
            $errorMsg = "vous identifiant sont incorrecte ";
        }

        

    }else{
        $errorMsg ='Veuillez remploir tous les champs...';
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<?php
require('navbar.php')
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Connexion</h2>
            
            <?php
            
            if (isset($message)) {
                echo '<p>' . $message . '</p>';
            }
            ?>
            <?php if(isset($errorMsg)) {echo '<p>'.$errorMsg.'</p>';}?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email"><b>Email</b></label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password"><b>Mot de passe</b></label>
                    <input type="password" class="form-control" name="password" >
                </div>
                <button type="submit" class="btn btn-success" name="Valider">Connexion</button>
            </form>
        </div>
    </div>
</div>



</body>
</html>
