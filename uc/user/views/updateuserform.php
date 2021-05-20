<?php
// Projet: Application TPI 
// Script: Views updateuserform.php
// Description: Formulaire de modification des utilisateurs par un admin
// Auteur: Morrone Flavio
// Version 0.1.1 MF 11.05.2021

?>

<?php if (!empty($errors['Register'])) : ?>
    <div class="alert alert-danger col-sm-9 col-sm-offset-3">
        <?php echo $errors['Register']; ?>
    </div>
<?php endif; ?>

<form action="<?= Routes::PathTo('user', 'editUser') ?>" method="post" class="form-horizontal">


    <div class="form-group">
        <label class="control-label col-sm-3" for="name">Nom: *</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="name" id="name" value="<?= $user == null ? '' : $user->getLastName() ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="firstname">Prénom: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="text" name="firstname" id="firstname" value="<?= $user == null ? '' : $user->getFirstName() ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="address">Adresse: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="text" name="address" id="address" value="<?= $user == null ? '' : $user->getAddress() ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="email">Email: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="email" name="email" id="email" value="<?= $user == null ? '' : $user->getEmail() ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="status">Status: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="text" name="status" id="status" value="<?= $user == null ? '' : implode(',', $user->getStatus()) ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="pwd">Mot de passe: </label>
        <div class="col-sm-9">
            <input class="form-control" type="password" name="pwd" id="pwd" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="update" value="Modifier" />
        </div>
    </div>
</form>