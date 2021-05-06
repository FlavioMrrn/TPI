<?php
// Projet: Application TPI
// Script: Views showLogs.php
// Description: affiche les logs pour les admins
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

?>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Id</th>
        <th>message</th>
        <th>date</th>
    </tr>

    <?php
    // On fait une boucle pour lister tout ce que contient la table :
    foreach ($logs as $l) :
        // Seul le Webmanager peut éditer/supprimer toutes les définitions
        // Le ProductManager ou le SaleManager peuvent éditer/supprimer leur propres définitions
    ?>
        <tr>
            <td><?= $l->getIdLog() ?></td>
            <td><?= $l->getMessage(); ?></td>
            <td><?= $l->getDate() ?></td>
        </tr>
    <?php endforeach; ?>
</table>