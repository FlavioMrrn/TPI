<?php
// Projet: Application TPI
// Script: Vue flashmessages.php
// Description: affiche les messages flash disponibles
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial

//require_once "commons/model/FlashMessage.php";

$flashMessages = FlashMessage::GetAllMessages();

?>
<?php foreach ($flashMessages as $m): ?>
    <div class="alert alert-<?= $m->getRanking() ?> fade-in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?= $m->getMessage() ?>
    </div>    
<?php endforeach; ?>
