<?php


// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coupart";

try {
    // Créer une connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer toutes les recettes
    $sqlRecettes = "SELECT * FROM recettes";
    $stmtRecettes = $pdo->prepare($sqlRecettes);
    $stmtRecettes->execute();
    $recettes = $stmtRecettes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    require('navbar.php');
    ?>
    <div class="container">
        <h1 class="text-center">Liste des recettes</h1>
        <?php
        if (count($recettes) > 0) {
            echo '<div class="row mb-4" >';
            echo '<div class="row">';
            foreach ($recettes as $recette) {
               
                $titre = $recette['titre'];
                $images = $recette['images'];
                $description = $recette['description'];
                ?>
                
                <div class="col-md-6 card-margin">
                    <div class="card card-development">
                        <img src="<?php echo $images; ?>" class="card-img-top card-img-fixed-height">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titre; ?></h5>
                            
                            <a href="detail_recette.php?id_recette=<?php echo $recette['id']; ?>" class="btn btn-primary">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <?php
                
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo "Aucune recette trouvée.";
        }
    
        ?>
    </div>
    <a href="mention.html">Mentions légales </a>
    <br>
    <a href="politique de confidentialité.html">Politique de confidentialité</a>

</body>
</html>
