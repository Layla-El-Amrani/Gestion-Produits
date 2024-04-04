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
        $stmt = $conn->prepare("DELETE  FROM produit WHERE RefPdt = :id");
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        header("Location: liste_produits.php");

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

