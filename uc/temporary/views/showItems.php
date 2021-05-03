<?php
// Projet: Application TPI
// Script: Vue showItems.php
// Description: Page affichant tous les articles du catalogue permettant de sélectionner des articles
//    afin de simuler la livraison de la part des fournisseurs.
// Auteur: Pascal Comminot
// Version 1.0.0 PC 01.05.2021 / Codage initial

?>

<p>Cette page sert à simuler un arrivage de produits dans le stock. </p>
<p>Choisissez les articles que vous commandez aux fournisseurs, et le résultat fournira un fichier 
    csv prêt à l'emploi pour effectuer un arrivage multiple (TPI de M. Rapin, point 5.4.1.4)</p>
<form action="<?= Routes::PathTo('temporary','command') ?>" method="POST">
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Id</th>
        <th>Catégorie</th>
        <th>Fabricant</th>
        <th>Article</th>
        <th>No Article</th>
        <th>Quantité à commander</th>
    </tr>

    <?php
    // On fait une boucle pour lister tout ce que contient la table :
    foreach ($items as $i) :
    ?>
        <tr>
            <td><?= $i->idItem ?></td>
            <td><?= $i->categoryName; ?></td>
            <td><?= $i->manufacturer; ?></td>
            <td><?= $i->name; ?></td>
            <td><?= $i->partNumber; ?></td>
            <td><input type="number" name="quantity[<?= $i->partNumber?>]" value="0" /></td>
        </tr>
    <?php endforeach; ?>
</table>
    <div class="col"><input class="btn btn-success btn-block" name="submit" type="submit" value='"commander" auprès des fournisseurs'></div>
<div class="row">
</div>
</form>
