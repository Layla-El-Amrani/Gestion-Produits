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

    // Récupérer les données soumises par le formulaire
    $refpdt = $_POST['refpdt'];
    $libpdt = $_POST['libpdt'];
    $prix = $_POST['prix'];
    $qte = $_POST['qte'];
    $description = $_POST['description'];

    // Vérifie si un fichier a été téléversé avec succès
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Chemin où vous souhaitez stocker l'image téléversée sur votre serveur
        $upload_directory = "uploads/";

        // Nom du fichier
        $file_name = $_FILES['image']['name'];

        // Déplacer le fichier téléversé vers le répertoire souhaité
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_directory . $file_name);

        // Maintenant, vous pouvez utiliser $file_name comme valeur à insérer dans votre base de données
        // Vous pouvez également stocker le chemin complet du fichier si nécessaire
        $image = $upload_directory . $file_name;

        // Insérer les données dans la base de données
        $stmt = $conn->prepare("INSERT INTO produit (RefPdt, libPdt, Prix, Qte, description, image) VALUES (:refpdt, :libpdt, :prix, :qte, :description, :image)");
        $stmt->bindParam(':refpdt', $refpdt);
        $stmt->bindParam(':libpdt', $libpdt);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':qte', $qte);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->execute();

        // Rediriger vers la page de la liste des produits après l'ajout
        header("Location: liste_produits.php");
    } else {
        // Gérer les erreurs de téléversement d'image
        echo "Erreur lors du téléversement de l'image.";
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
