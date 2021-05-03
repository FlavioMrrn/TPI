<?php

if (!$token) {
    header("Location:".Routes::PathTo('main','home'));
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_WARNING, "Il n'y a pas de compte à vérifier !");
    exit();
}

?>

<form action="<?= Routes::PathTo('user', 'verify') ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-3" for="email">email: *</label>
        <div class="col-sm-9">
            <input class="form-control" required type="email" name="email" id="email" />
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
            <input type="submit" name="verify" value="Verifier" />
        </div>
    </div>
<form>
