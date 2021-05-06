<?php
// Projet: Application TPI / User
// Script: Views recoverPasswordform.php
// Description: formulaire de modification de mot de passe
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.05.2021

?>

<form action="<?= Routes::PathTo('user', 'recoverPassword') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="email"> Entrez votre email: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="email" name="email" id="email" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="pwd">Nouveau mot de passe: </label>
        <div class="col-sm-9">
            <input class="form-control" required type="password" name="pwd" id="pwd"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="confirmPwd">Confirmer: </label>
        <div class="col-sm-9">
            <input class="form-control" required type="password" name="confirmPwd" id="confirmPwd"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="token">Token: </label>
        <div class="col-sm-9">
            <input class="form-control" required readonly type="text" name="token" id="token" value="<?= $token ?>"/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="modifyPassword" value="Récupérer" />
        </div>
    </div>
<form>
