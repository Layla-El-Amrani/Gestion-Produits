<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// Vérifier si l'ID du produit à modifier est passé en paramètre
if (!isset($_GET['id'])) {
    // Redirection vers une page d'erreur ou une autre page appropriée si l'ID n'est pas fourni
    header("Location: erreur.php");
    exit;
}

// Paramètres de connexion à la base de données
require_once 'config.php' ;

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour sélectionner le produit à modifier en fonction de son ID
    $stm = $conn->prepare("SELECT * FROM produit WHERE RefPdt = :id");
    $stm->bindParam(':id', $_GET['id']);
    $stm->execute();
    $product = $stm->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le produit existe
    if (!$product) {
        // Redirection vers une page d'erreur ou une autre page appropriée si le produit n'est pas trouvé
        header("Location: produit_non_trouve.php");
        exit;
    }
} catch(PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de requête, afficher un message d'erreur
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Modifier un produit</h1>
        <!-- Formulaire de modification du produit -->
        <form action="modifier_traitement.php" method="post">
            <input type="hidden" name="id" value="<?php echo $product['RefPdt']; ?>">
            <label for="libelle">Libellé:</label>
            <input type="text" id="libelle" name="libelle" value="<?php echo $product['libPdt']; ?>"><br><br>
            <label for="prix">Prix:</label>
            <input type="text" id="prix" name="prix" value="<?php echo $product['Prix']; ?>"><br><br>
            <label for="quantite">Quantité:</label>
            <input type="text" id="quantite" name="quantite" value="<?php echo $product['Qte']; ?>"><br><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"><?php echo $product['description']; ?></textarea><br><br>
            <!-- Ajoutez d'autres champs pour d'autres attributs du produit si nécessaire -->
            <input type="submit" value="Modifier" id="btn">
        </form>
    </div>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn = null;
?>
