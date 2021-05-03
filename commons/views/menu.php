<?php
// Projet: Application TPI
// Script: Vue menu.php
// Description: menu dynamique du site
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2021 / Codage initial
// Version 1.0.1 PC 22.04.2021 / Suppression du menu utilisateur statique, remplacé par sa version dynamique (voir uc/user/register.php)


?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
    <a class="navbar-brand pl-5" href="index.php"><?= APP_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container-fluid">
        <?php 
            Html::MainMenu();
        ?>
    </div>
</nav>