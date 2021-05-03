<?php
// Projet: Application TPI
// Script: Vue 404.php
// Description: Page indiquant que le chemin demandé n'a pas été trouvé.
// Très volubile en développement, 
// et beaucoup moins en recettage ou en production 
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial

?>

<div class="row">
    <div class="col-sm-12">
        <h4 class='alert alert-danger'>L'action demandée n'a pas été trouvée</h4>
    </div>

</div>
<?php if (APP_STATUS == "dev"): ?>
    <div class="row">
        <div class="col-sm-12">
            <p>Liste des paramètres reçus en GET :</p>
            <pre><?= var_dump($_GET) ?></pre>
            <p>Liste des paramètres reçus en POST :</p>
            <pre><?= var_dump($_POST) ?></pre>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-sm-12">
            <p>Veuillez prendre contact avec le responsable de l'application</p>
        </div>
    </div>
<?php endif; ?>

