<?php
require_once 'commons/views/Html.php';
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if (filter_input(INPUT_POST, "verify")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING);
    if (!empty($email) && !empty($token)) {
        if (User::verifyTokenEmail($token, $email)) {

            $now = new DateTime("NOW");
            $date = User::getValidationDate($email);
            $format = 'Y-m-d H:i:s';
            $validation = DateTime::createFromFormat($format, $date[0]);

            if ($now < $validation) {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Félicitation, votre compte à été validé !");
                User::validateAccount($email);
                header("Location: " . Routes::PathTo("user", "login"));
                exit();
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Votre date limite de validation à expiré !");
            }
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le token et l'email ne correspondent pas !");
        }
    }
}

Html::showHtmlPage("Valider", "uc/user/views/verifyform.php", array("token" => $token));
