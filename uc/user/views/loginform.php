<?php
// Projet: Application TPI 
// Script: Vue loginform.php
// Description: Formulaire d'identification des utilisateurs
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial

?>

<?php if (!empty($errors['Login'])) : ?>
    <div class="alert alert-danger col-sm-9 col-sm-offset-3">
        <?php echo $errors['Login']; ?>
    </div>
<?php endif; ?>

<form action="<?= Routes::PathTo('user','login') ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-3" for="email">Email: *</label>
        <div class="col-sm-9">
            <input class="form-control" type="email" name="email" id="email"  />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="pwd">Mot de passe: *</label>
        <div class="col-sm-9">
            <input class="form-control" type="password" name="pwd" id="pwd"  />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="submit" value="Connexion" />
        </div>
    </div>
    <div class="form-group">
        <div class="control-label col-sm-3">
            <a href="<?= Routes::PathTo('user','registration') ?>">pas encore inscrit ?</a>
        </div>
    </div>
</form>
