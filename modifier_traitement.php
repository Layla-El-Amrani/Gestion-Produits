<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// Vérifier si les données du formulaire sont soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Paramètres de connexion à la base de données
    require_once 'config.php' ;

    try {
        // Connexion à la base de données
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête de mise à jour pour modifier les détails du produit dans la base de données
        $stm = $conn->prepare("UPDATE produit SET libPdt = :libelle, Prix = :prix, Qte = :quantite, description = :description WHERE RefPdt = :id");

        // Liaison des valeurs des paramètres
        $stm->bindParam(':id', $_POST['id']);
        $stm->bindParam(':libelle', $_POST['libelle']);
        $stm->bindParam(':prix', $_POST['prix']);
        $stm->bindParam(':quantite', $_POST['quantite']);
        $stm->bindParam(':description', $_POST['description']);

        // Exécution de la requête de mise à jour
        $stm->execute();

        // Redirection vers la page de liste des produits après la mise à jour
        header("Location: liste_produits.php");
        exit;
    } catch(PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de requête, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Redirection vers une page appropriée si les données du formulaire ne sont pas soumises via POST
    header("Location: erreur.php");
    exit;
}
?>
