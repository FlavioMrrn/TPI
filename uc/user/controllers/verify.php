<?php
require_once 'commons/views/Html.php';
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if (filter_input(INPUT_POST, "verify")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    
}


Html::showHtmlPage("Valider", "uc/user/views/verifyform.php", ["token" => $token]);
