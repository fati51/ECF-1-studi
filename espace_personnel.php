
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=coupart', 'root', 'root');
} catch (Exception $e) {
    die('Veuillez vérifier votre base de données : ' . $e->getMessage());
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getId = $_GET['id'];

    // Utilisation de la requête préparée pour récupérer toutes les recettes du même id_patient
    $recettesRecup = $bdd->prepare('SELECT * FROM recette WHERE id_patient = ?');
    $recettesRecup->execute(array($getId));
    

    // Vérifiez si des résultats ont été trouvés
    if ($recettesRecup->rowCount() > 0) {
        // Bouclez à travers les résultats
        while ($recette = $recettesRecup->fetch()) {
            // Accédez aux colonnes en utilisant les noms spécifiés dans la requête SQL
            $titre = $recette['titre'];
            $description = $recette['description'];
            $regime = $recette['regime'];

            // Affichez les données comme souhaité
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h3><?= $titre; ?></h3>
                <p><?= $description; ?></p>
                <p>Régime : <?= $regime; ?></p>
                <!-- Le reste de votre contenu HTML ici -->
            </body>
            </html>
            <?php
        }
    } else {
        echo "Aucune recette trouvée.";
    }
}
?>

