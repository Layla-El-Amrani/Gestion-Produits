<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login">
   <div class="container">
    <h1>Se connecter</h1>
    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="post">

    <table>
        <tr>
            <td><label for="nom">Login</label><br><br> </td>
            <td><input type="Login" id="Login" name='login' class='login_input'><br><br> </td>
        </tr>
        
        <tr>
            <td><label for="Password">Password</label><br><br> </td>
            <td><input type="Password" id="Password" name='password'class='login_input'><br><br> </td>
        </tr>
        <tr>
            <td colspan="2">
            <?php
                // Vérifier si la connexion a échoué
                if (isset($_GET['login']) && $_GET['login'] == 'failed') {
                    echo "<p class='message'>Nom d'utilisateur ou mot de passe incorrect.</p>";
                }
            ?>
            </td>
        </tr>


        <tr>
            <td></td>
            <!-- Bouton de soumission du formulaire -->
            <td colspan="2"><input type="submit" name="" id="login" value='Login' > </td>

        </tr>
        
        
    </table>
    </form>
   </div>

</body>
</html>

<?php
session_start();
// Paramètres de connexion à la base de données
require_once 'config.php' ;

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur
    die("Erreur de connexion :".$e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Préparation de la requête SQL pour vérifier l'authentification de l'utilisateur
    $stm = $conn->prepare("SELECT * FROM utilisateur WHERE login = :login AND password = :password");
    $stm->bindParam(':login', $login);
    $stm->bindParam(':password', $password);
    $stm->execute();

    // Vérification du résultat de la requête
    if($stm->rowCount() > 0) {
        $_SESSION['loggedin'] = true; // Initialiser la session pour l'utilisateur connecté
        header("Location:liste_produits.php");
        exit;
    } else {
        header("Location:connexion.php?login=failed");
        exit;
    }
}

// Fermeture de la connexion à la base de données
$conn = null;
?>
