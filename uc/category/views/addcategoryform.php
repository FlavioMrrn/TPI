<?php
// Projet: Application TPI 
// Script: Vue addcategoryform.php
// Description: Formulaire d'enregistrement des categories par un admin
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021

?>

<?php if (!empty($errors['Register'])) : ?>
    <div class="alert alert-danger col-sm-9 col-sm-offset-3">
        <?php echo $errors['Register']; ?>
    </div>
<?php endif; ?>

<form action="<?= Routes::PathTo('category', 'addCategory') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="name">Titre: *</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="title" id="name" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="firstname">Description:</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="description" id="firstname" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="address">Parent: *</label>
        <div class="col-sm-9">
            <?= Category::makeParentSelect() ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="addCategory" value="S'enregistrer" />
        </div>
    </div>
</form>