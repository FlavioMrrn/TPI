<?php
// Projet: Application TPI / temporary
// Script: Contrôleur command
// Description: simule une commande de produits auprès des fournisseurs
// Génère un fichier CSV, avec une première ligne d'entête comportant les noms des colonnes (manufacturer,partNumber,serialNumber)
// Le séparateur de colonne est le point-virgule, et le séparateur de ligne un CR-LF
// Auteur: Pascal Comminot
// Version 1.0.0 PC 01.05.2021 / Codage initial

require_once 'uc/temporary/model/Simulation.php';
require_once "commons/model/FlashMessage.php";


if (filter_has_var(INPUT_POST, "submit")) {
    // construction de 2 tableaux : 
    // le premier assiociatif PartNumber => Quantité, utile pour traiter les quantités en ligne 38
    // le second tableau simple de PartNumber, utile pour sélectionner les détails des items correspondants dans la base (ligne 34).
    $commands = array();
    $selection = array();
    $quantities = filter_input(INPUT_POST,'quantity',FILTER_VALIDATE_INT,FILTER_REQUIRE_ARRAY);

    foreach ($quantities as $partNumber => $quantity) {
        $partNumber = filter_var($partNumber, FILTER_SANITIZE_STRING);
        $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);
        // on élimine les lignes qui ne comportent aucune commande
        if ($quantity != "0") {
            $commands["$partNumber"] = (int)$quantity;
            $selection[] = "$partNumber";
        }
    }

    // s'il y a des articles à commander :
    if (count($selection) > 0) {
        $selectedItems = Simulation::findAllItemsByPartNumber($selection);
        $output = "manufacturer;partNumber;serialNumber\r\n";
        $nbProducts = 0;
        foreach ($selectedItems as $item) {
            $quantity = $commands[$item->partNumber];
            for ($i = 1; $i <= $quantity; $i++) {
                $nbProducts++;
                // Le numéro de série fictif est basé sur un hachage du nom du fabriquant, d'un uniqid PHP et du numéro de ligne de la commande
                $serialNumber = strtoupper(md5($item->manufacturer . uniqid() . $nbProducts));
                $output .= $item->manufacturer . ";" . $item->partNumber . ";" . $serialNumber . "\r\n";
            }
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="arrivage.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($output));
        flush(); // Flush system output buffer
        echo $output;

        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "$nbProducts articles ont été commandés");
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_WARNING, "la commande est vide, aucun article n'a été commandé");
    }
}

// bug : la redirection ne marche pas si on a eu un téléchargement d'un arrivage... 
// header("Location:" . Routes::PathTo("temporary", "list"));
exit;
