<?php
// Projet: Application TPI
// Script: Views logtable.php
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
    foreach ($logs as $l) :
    ?>
        <tr>
            <td><?= $l->getIdLog() ?></td>
            <td><?= $l->getMessage(); ?></td>
            <td><?= $l->getDate() ?></td>
        </tr>
    <?php endforeach; ?>
</table>