<?php
// Projet: Applicaition TPI
// Script: Vue header.php
// Description: entête HTML des pages du site 
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial



if (empty($pageTitle)){
    $pageTitle = "sans titre";
}

?>
<!DOCTYPE html>
<html lang="fr" class="h-100">    
    <head>
        <title><?= APP_NAME ?> - <?= $pageTitle ?></title>
        <meta charset="utf-8" />
        <meta name="generator" content="Visual Studio Code" />
        <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="css/tpi.css"/>

    </head>
    <body class="d-flex flex-column h-100">
        <header>
            <?php include_once 'commons/views/menu.php'; ?>
        </header>
        <main class="flex-shrink-0">
            <div class="container">
                <?php include_once 'commons/views/flashmessages.php'; ?>
            
                <div class="row">
                    <div class="col-sm-10">
                        <h4><?= $pageTitle ?></h4>
                    </div>
                </div>
