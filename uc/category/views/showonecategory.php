<?php
// Projet: Application TPI
// Script: Views showonecategory.php
// Description: affiche une seule catégorie
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 17.05.2021 
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?=
        buildBreadCrumb(makeBreadCrumb($category));
        ?>
    </ol>
</nav>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Fabriquant</th>
        <th></th>
    </tr>
    <?php
     /** *
     * Travail de monsieur companha 
     */ ?>
</table>