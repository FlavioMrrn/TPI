<?php
// Projet: Application TPI
// Script: Views usertable.php
// Description: affiche les users pour les admins
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

?>
<form class="form-inline" action="<?= Routes::PathTo('user', 'showUsers') ?>" method="post">
    <div class="form-group mr-sm-3 mb-2">
        <label for="word" class="m-2">Mot à trouver</label>
        <input type="text" class="form-control" name="word" id="word" size="50" placeholder="Laisser le texte vide pour visualiser tout le dictionnaire" value="<?= $word ?>">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Rechercher</button>
</form>
<div class="d-flex flex-row justify-content-between">
    <div class="my-2"><?= $count ?> Utilisateurs trouvés</div>
    <div><?= Html::PageNavigator($pages, $page) ?></div>
</div>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>adresse</th>
        <th>email</th>
        <th>status</th>
        <th></th>
    </tr>

    <?php
    // On fait une boucle pour lister tout ce que contient la table :
    foreach ($users as $u) :
        // Seul le Webmanager peut éditer/supprimer toutes les définitions
        // Le ProductManager ou le SaleManager peuvent éditer/supprimer leur propres définitions
    ?>
        <tr>
            <td><?= $u->getFirstName() ?></td>
            <td><?= $u->getLastName() ?></td>
            <td><?= $u->getAddress() ?></td>
            <td><?= $u->getEmail() ?></td>
            <td><?= implode(', ', $u->getStatus()) ?></td>
            <td>
                <form action="<?= Routes::PathTo('user', 'editUser') ?>">
                    <input type="hidden" name='id' value='<?= $u->getIdUser() ?>'>
                    <button type="submit" name="update" class="btn btn-primary"><span class="fas fa-pen"></span></button>
                </form>


                <!-- Modal pour delete-->
                <?php



                $date = new DateTime("NOW");
                $lastYear = $date->modify('-1 year');
                $validateDate = $u->getValidationDate;
                $validateDate = DateTime::createFromFormat('Y-m-d H:i:s', $validateDate);
                $lastConnection = date('Y-m-d H:i:s', strtotime($u->getLastConnection()));
                $countCommands = User::countCommands($u->getIdUser());

                if (($validateDate !== false && ($validateDate < $date && $u->hasRole(User::USER_ROLE_NOT_VERIFIED))) || ($countCommands <=  0 && $lastConnection < $lastYear)) : ?>
                    <button data-toggle="modal" class="btn btn-danger" href="#delete<?= $u->getIdUser() ?>"><span class="fas fa-trash-alt"></span></button>
                    <div class="modal" id="delete<?= $u->getIdUser() ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Voulez-vous vraiment supprimer cet utilisateur ?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><?= $u->getFirstName(); ?>
                                        <?= $u->getLastName(); ?>,
                                        <?= $u->getEmail(); ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="<?= Routes::PathTo('user', 'deleteUser') ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $u->getIdUser() ?>" />
                                        <input class="btn" type="submit" name="delete" value="Supprimer" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                endif; ?>

                    </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>