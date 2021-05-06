<?php
// Projet: Application TPI / User
// Script: Views views/profil.php
// Description: affichage du profil
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021

?>
<form action="<?= Routes::PathTo('user', 'profil') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="name">Nom: *</label>
        <div class="col-sm-9">
            <input class="form-control" <?= Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED)) ? 'readonly' : '' ?> type="text" name="name" id="name" value="<?= Session::getUser()->getLastName() ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="firstname">Prénom: *</label>
        <div class="col-sm-9">
            <input class="form-control" <?= Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED)) ? 'readonly' : '' ?> required type="text" name="firstname" value="<?= Session::getUser()->getFirstName() ?>" id="firstname" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="address">Adresse: *</label>
        <div class="col-sm-9">
            <input class="form-control" <?= Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED)) ? 'readonly' : '' ?> required type="text" name="address" value="<?= Session::getUser()->getAddress() ?>" id="address" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="email">Email: *</label>
        <div class="col-sm-9">
            <input class="form-control" <?= Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED)) ? 'readonly' : '' ?> required type="email" name="email" value="<?= Session::getUser()->getEmail() ?>" id="email" />
        </div>
    </div>
    <?php if (!Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED))) : ?>
        <div class="form-group">
            <label class="control-label col-sm-3" for="pwd">Mot de passe actuel: </label>
            <div class="col-sm-9">
                <input class="form-control" type="password" name="pwd" id="pwd" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="newpwd">Nouveau mot de passe: </label>
            <div class="col-sm-9">
                <input class="form-control" type="password" name="newpwd" id="newpwd" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="confirmnewpwd">Confirmation du nouveau mot de passe: </label>
            <div class="col-sm-9">
                <input class="form-control" type="password" name="confirmnewpwd" id="confirmnewpwd" />
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                (* champs obligatoires)
            </div>
            <div class="col-sm-9">
                <input type="submit" name="updateProfil" value="Modifier" />
            </div>
        </div>
    <?php endif; ?>
</form>