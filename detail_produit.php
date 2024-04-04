    <?php
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location:connexion.php");
        exit;
    }
    // Connexion à la base de données
    require_once 'config.php' ;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer l'identifiant du produit depuis l'URL
        $product_id = isset($_GET['id']) ? $_GET['id'] : null;

        // Vérifier si l'identifiant du produit est défini
        if ($product_id) {
            // Requête SQL pour récupérer les détails du produit
            $stmt = $conn->prepare("SELECT * FROM produit WHERE RefPdt = :id");
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Redirection vers une page d'erreur ou de gestion des erreurs si l'identifiant du produit n'est pas spécifié
            header("Location: erreur.php");
            exit();
        }
    } catch(PDOException $e) {
        // Gérer les erreurs de connexion à la base de données
        die("Erreur de connexion : " . $e->getMessage());
    }
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détails du produit</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php if ($product): ?>
        <h1>Information sur le produits :<?php echo $product['RefPdt']; ?></h1>
        <div id="produits">
    <img src="<?php echo $product['image']; ?>" alt="" class="img_produit">

        <table border="1" class='table1'>

        <tr>
                <td>Reference produit :</td>
                <td><?php echo $product['RefPdt']; ?></td>
            </tr>
            <tr>
                <td>libellé produit</td>
                <td><?php echo $product['libPdt']; ?></td>
            </tr>
            <tr>
            <td>Prix produit</td>
            <td><?php echo $product['Prix']; ?></td>
            </tr>
            <tr>
            <td>Quantité produit</td>
            <td><?php echo $product['Qte']; ?></td>
            </tr>
            <tr>
            <td>Description produit</td>
            <td><?php echo $product['description']; ?></td>
            </tr>
            <tr>
            <td>Type produit</td>
            <td><?php echo $product['type']; ?></td>
            </tr>
            <?php else: ?>
        <p>Produit non trouvé.</p>
        <?php endif; ?>
        </div>  
        </table>
        </div>
        <div><a href="liste_produits.php" class="reteur">reteur</a></div>
    
        
    </body>
    </html>
