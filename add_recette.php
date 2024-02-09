
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=coupart','root','root');

}catch(Exception $e){
die('Weuillez vérifee votre serveur :' .$e->getMessage());

}
if (isset($_POST['valider'])) {
    // Récupérer l'identifiant du patient depuis la liste déroulante
    

    // Assurez-vous que les autres champs du formulaire sont également remplis
    if(!empty($_POST['titre']) AND !empty($_POST['description']) AND !empty($_POST['temps_repos']) AND !empty($_POST['temps_preparation']) AND !empty($_POST['temps_cuisson'] AND !empty($_POST['ingredients'])) AND !empty($_POST['etapes']) AND !empty($_POST['allergenes']) AND !empty($_POST['regimes']) AND !empty($_POST['images']) ){
        $titre =  $_POST['titre'] ;
        $description = $_POST['description'];
        $tempsRepos = $_POST['temps_repos'];
        $tempsPreparation = $_POST['temps_preparation'];
        $tempsCuisson = $_POST['temps_cuisson'];
        $ingredients = $_POST['ingredients'];
        $etapes = $_POST['etapes'];
        $allergenes = $_POST['allergenes'];
        $regimes = $_POST['regimes'];
        $images = $_POST['images'];
        $patient_id = $_SESSION['id'];

        $recetteInsert =$bdd->prepare("INSERT INTO recettes (titre, description, temps_repos, temps_preparation, temps_cuisson, ingredients, etapes, allergenes, regimes, images,patient_id,email_patient) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $recetteInsert->execute(array($titre, $description, $tempsRepos, $tempsPreparation, $tempsCuisson, $ingredients, $etapes, $allergenes, $regimes, $images, $patient_id));

        // Redirection après l'ajout de la recette
        header('Location: liste_recette.php');
        exit();
    }
}


       
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ajouter une recette</title>
    
</head>
<body>
<?php
require('navbar.php')
?>
<div class="container">
<h2 class="text-center mb-4">Ajouter une recette</h2>

<form action="ajoute_recette.php" method="POST" class="form-group" >
    <!-- Champs pour le titre -->
    <label>Titre :</label>
    <input type="text" name="titre" required class="form-control">
    <br>
    <!-- Champs pour le temps de repos -->
    <label>Temps de repos :</label>
    <input type="text" name="temps_repos" required class="form-control">
    <br>
    <!-- Champs pour le temps de cuisson -->
    <label>Temps de cuisson :</label>
    <input type="text" name="temps_cuisson" required class="form-control">
    <br>
    <!-- Champs pour le temps de préparation -->
    <label>Temps de préparation :</label>
    <input type="text" name="temps_preparation" required class="form-control">
    <br>
    <!-- Champs pour la description -->
    <label>Description :</label>
    <textarea name="description" required class="form-control"></textarea>
    <br>
    <!-- Champs pour les ingrédients -->
    <label>Ingrédients :</label>
    <textarea name="ingredients" required class="form-control"></textarea>
    <br>
    <!-- Champs pour les étapes -->
    <label>Étapes :</label>
    <textarea name="etapes" required class="form-control"></textarea>
    <br>
    <!-- Champs pour les allergènes -->
    <label>Allergènes :</label>
    <input type="text" name="allergenes" class="form-control">
    <br>
    <!-- Champs pour les régimes -->
    <label>Régimes :</label>
    <input type="text" name="regimes" class="form-control">
    <br>
    <label>Galerie d'images :</label>
    <input type="file" name="images" class="form-control">
    <br>
    <!-- Bouton pour soumettre le formulaire -->
    <input type="submit" value="Ajouter" name="valider" class="btn btn-primary">
</form>
</div>
    
</div>
<label for="patient">Sélectionner le patient :</label>
<select name="patient" class="form-control">
    <?php
    // Récupérer la liste des patients depuis la base de données
    $patients = $bdd->query("SELECT id, nom, prenom FROM patients")->fetchAll();

    // Afficher chaque patient dans la liste déroulante
    foreach ($patients as $patient) {
        echo "<option value=\"{$patient['id']}\">{$patient['nom']} {$patient['prenom']}</option>";
   }

?>

</select>
<input type="submit" value="Ajouter" name="valider" class="btn btn-primary">
</form>
</body>
</html>








