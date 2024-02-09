<?php
// Paramètres de connexion à la base de données (similaires à votre code existant)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coupart";

try {
    // Créer une connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id_recette'])) {
        $id_recette = $_GET['id_recette'];

        // Requête SQL pour récupérer les détails de la recette en fonction de son ID
        $sqlRecette = "SELECT * FROM recettes WHERE id = :id_recette";
        $stmtRecette = $pdo->prepare($sqlRecette);
        $stmtRecette->bindParam(':id_recette', $id_recette, PDO::PARAM_INT);
        $stmtRecette->execute();
        $recette = $stmtRecette->fetch(PDO::FETCH_ASSOC);

        if ($recette) {
            $titre = $recette['titre'];
            $description = $recette['description'];
            $image = $recette['image'];
            $temps_preparation = $recette['temps_preparation'];
            $temps_repos = $recette['temps_repos'];
            $etapes = $recette['etapes'];

            // Code HTML pour afficher les détails de la recette
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Détails de la recette</title>
                <link rel="stylesheet" href="style.css">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container">
                    <h1>Détails de la recette</h1>
                    <img src="<?php echo $image; ?>" >
                    <h2><?php echo $titre; ?></h2>
                    <p><?php echo $description; ?></p>
                    <p>Temps de préparation : <?php echo $temps_preparation; ?> minutes</p>
                    <p>Temps de repos : <?php echo $temps_repos; ?> minutes</p>
                    <h3>Étapes :</h3>
                    <ul>
                        <?php
                        $etapes = explode("\n", $etapes);
                        foreach ($etapes as $etape) {
                            echo "<li>$etape</li>";
                        }
                        ?>
                    </ul>
                    <a href="index.php" class="btn btn-danger">Retour</a>
                </div>
                <!-- ... Vos scripts JavaScript ... -->
            </body>
            </html>
            <?php
        } else {
            echo "Recette non trouvée.";
        }
    } else {
        echo "Identifiant de recette non spécifié.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

