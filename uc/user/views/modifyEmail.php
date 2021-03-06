<?php
// Projet: Application TPI / User
// Script: Views modifyEmail.php
// Description: formulaire de modification d'email
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.05.2021

?>

<form action="<?= Routes::PathTo('user', 'modifyEmail') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="email"> Entrez votre email: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="email" name="email" id="email" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="newemail">Nouvel email: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="text" name="newemail" id="newemail"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="token">token: </label>
        <div class="col-sm-9">
            <input class="form-control" required readonly type="text" name="token" id="token" value="<?= $token ?>"/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="modifyEmail" value="Modifier" />
        </div>
    </div>
<form>
