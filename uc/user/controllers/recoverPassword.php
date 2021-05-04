<?php
require_once 'commons/views/Html.php';

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if (filter_input(INPUT_POST, "askRecover")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if (User::findByEmail($email) !== false) {
        $token = User::generateToken();
        User::askRecover($email, $token);
        $message = "Bonjour,
        
 Merci pour votre inscription à notre site.
       
 Veuillez valider votre email en cliquant sur ce lien: http://localhost/TPI/index.php?uc=user&action=recoverPassword&token=$token
       
Bonne continuation !
       
L'administration";
        mail($email, "Récupération du mot de passe", $message);
    }
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Votre demande à été prise en compte. Vous avez 2h pour modifier votre mot de passe en cliquant sur le lien reçu par mail.");
    header("Location: " . Routes::PathTo("user", "login"));
    exit;
} else if (filter_input(INPUT_POST, "modifyPassword")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
    $confirmPassword = filter_input(INPUT_POST, "confirmPwd", FILTER_SANITIZE_STRING);
    $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING);
    if ($password == $confirmPassword) {
        if (User::findByEmail($email) !== false) {
            if (User::verifyRecoverTokenEmail($token, $email)) {
                $format = 'Y-m-d H:i:s';
                $now = new DateTime("NOW");
                $date = User::getREcoveryDate($email);
                $validation = DateTime::createFromFormat($format, $date);
                //vérification de la date limite de validation
                if ($now < $validation) {
                    User::modifyPassword($email, $password);
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Le mot de passe à été modifié");
                    header("Location: " . Routes::PathTo("user", "login"));
                    exit;
                }
                else {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Vous avez dépassé les 2h mises à dispositions, refaites une demande !");
                }
            }
            else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le token ne correspond pas avec l'email !");
            }
        }
        else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur n'existe pas !");
        }
    }else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les mots de passes ne correspondent pas");
    }
} else if (!empty($token)) {
    Html::showHtmlPage("Modifier le mot de passe", "uc/user/views/modifyPassword.php", array('token' => $token));
    exit;
}

Html::showHtmlPage("Récupérer le mot de passe", "uc/user/views/askRecoverPassword.php", array());