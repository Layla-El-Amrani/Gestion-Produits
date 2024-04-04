<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location:connexion.php");
    exit;
}
// Paramètres de connexion à la base de données
require_once 'config.php' ;

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour sélectionner tous les produits
    $stm = $conn->prepare("SELECT * FROM produit");
    $stm->execute();
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // En cas d'erreur de connexion, afficher un message d'erreur
    die("Erreur de connexion : ".$e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container_produits">
    
    <h1> &nbsp &nbsp &nbsp &nbsp Liste des produits</h1>
    <a href="ajouter_produit.php" class="ajouter_produit">ajouter</a>
    </div>
    <table  style="; background-colr:rgb(126, 76, 7, 0.788);border-radius: 20px;"class='table'>
        <tr>
            <!-- En-têtes de colonnes -->
            <th>Référence</th>
            <th>libellé</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Description</th>
            <th>Type</th>
            <th>Photo </th>
            <th>Action</th>
        </tr>
        <?php foreach($rows as $row): ?>
        <tr>
            <!-- Données de chaque produit -->
            <td><?php echo $row['RefPdt'];?></td>
            <td><?php echo $row['libPdt'];?></td>
            <td><?php echo $row['Prix'];?></td>
            <td><?php echo $row['Qte'];?></td>
            <td><?php echo $row['description'];?></td>
            <td><?php echo $row['type'];?></td>
            <td><img src="<?php echo $row['image'];?>" alt="" srcset=""></td>
            <td>
                <!-- Liens pour afficher les détails et supprimer un produit -->
                <a href="detail_produit.php?id=<?php echo $row['RefPdt']; ?>"><img src="image/icon2.png" alt="" class="icone"></a>
                <a href="supprimer_produit.php?id=<?php echo $row['RefPdt']; ?>"><img src="image/icon3.png" alt="" class="icone"></a>
                <a href="modifier_produit.php?id=<?php echo $row['RefPdt']; ?>"><img src="image/icon1.png" alt="" class="icone"></a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn = null;
?>
