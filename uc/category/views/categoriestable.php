<?php
// Projet: Application TPI
// Script: Views usertable.php
// Description: affiche les users pour les admins
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

?>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>id</th>
        <th>Titre</th>
        <th>Description</th>
        <th>IdParent</th>
    </tr>

    <?php
    // On fait une boucle pour lister tout ce que contient la table :
    foreach ($categories as $c) :
        // Seul le Webmanager peut éditer/supprimer toutes les définitions
        // Le ProductManager ou le SaleManager peuvent éditer/supprimer leur propres définitions
    ?>
        <tr>
            <td><?= $c->getIdCategory() ?></td>
            <td><?= $c->getTitle() ?></td>
            <td><?= $c->getDescription() ?></td>
            <td><?= $c->getIdParent() ?></td>
            <?php
            if (Session::getUser()->hasCurrentRole(User::USER_ROLE_WEB_MANAGER)) : ?>
                <td>
                    <form method="POST" action="<?= Routes::PathTo('category', 'updateCategory') ?>">
                        <input type="hidden" name='id' value='<?= $c->getIdCategory() ?>'>
                        <button type="submit" name="edit" class="btn btn-primary"><span class="fas fa-pen"></span></button>
                    </form>


                    <!-- Modal pour delete-->
                    <?php

                    if (!Category::hasChild($c->getIdCategory())) :
                        $count = Category::CountItems($c->getIdCategory());
                        if ($count[0] <= 0) : ?>
                            <button data-toggle="modal" class="btn btn-danger" href="#delete<?= $c->getIdCategory() ?>"><span class="fas fa-trash-alt"></span></button>
                            <div class="modal" id="delete<?= $c->getIdCategory() ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Voulez-vous vraiment supprimer cette catégorie ?</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?= $c->getTitle(); ?>,
                                            <?= $c->getDescription(); ?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?= Routes::PathTo('category', 'deleteCategory') ?>" method="post">
                                                <input type="hidden" name="id" value="<?= $c->getIdCategory() ?>" />
                                                <input class="btn" type="submit" name="deleteCategory" value="Supprimer" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                        endif;
                    endif; ?>

                            </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>