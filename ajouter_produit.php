<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un nouveau produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<fieldset class="list_produit">
    <h2 class="h2_list_produit">Ajouter un nouveau produit</h2>
    <form action="traitement_ajout_produit.php" method="POST" enctype="multipart/form-data" class="ajouter_produits">

        <label for="refpdt">Référence produit:</label>
        <input type="text" id="refpdt" name="refpdt" class='produit'><br>
        
        <label for="libpdt">libellé:</label>
        <input type="text" id="libpdt" name="libpdt"><br>
        
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix"><br>
        
        <label for="qte">Quantité:</label>
        <input type="number" id="qte" name="qte"><br>
        
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description"><br>
        
        <label for="type">Type:</label><br>
        <select name="type" id="type" class="select">
        <option value="Electronique">Electronique</option>
            <option value="Electricite">Electricite</option>
            <option value="Informatique">Informatique</option>
        </select>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>
        
        <input type="submit" value="Ajouter" id="btn">
    </form>
    </fieldset>
</body>
</html>
