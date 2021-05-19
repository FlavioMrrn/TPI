<?php
// Projet: Application TPI 
// Script: Views updatecategoryform.php
// Description: Formulaire de modification des catégories par un admin
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021

?>

<form action="<?= Routes::PathTo('category', 'updateCategory') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="name">Titre: *</label>
        <div class="col-sm-9">
            <input class="form-control" type="hidden" name="id" value="<?= $category->getIdCategory()?>"/>
            <input class="form-control" type="text" name="title" id="name" value="<?= $category->getTitle() == null ? '' :  $category->getTitle()?>"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="firstname">Description:</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="description" id="firstname" value="<?= $category->getDescription() == null ? '' :  $category->getDescription()?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="address">Parent: *</label>
        <div class="col-sm-9">
            <?= Category::makeParentSelect($category->getIdCategory(), $category->getIdParent()) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            (* champs obligatoires)
        </div>
        <div class="col-sm-9">
            <input type="submit" name="updateCat" value="Modifier" />
        </div>
    </div>
</form>