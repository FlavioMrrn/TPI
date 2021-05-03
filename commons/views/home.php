<?php
// Projet: Application TPI
// Script: Vue home.php
// Description: Page d'accueil du site
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial

?>

<p>Ce squelette de site web propose l'ossature de base commune pour 3 TPIs.</p>
<p>L'utilisateur peut, dans cette version initiale, s'identifier, changer de rôle en fonction de ses possibilités et se déconnecter</p>
<ul>
    <li>le mot de passe pour tous les comptes est 1234</li>
    <li>l'identification se fait avec l'email</li>
    <li>Les divers comptes mis à disposition sont :
        <ul>
            <li>William Weber, webadmin@gmail.com, WebManager</li>
            <li>Patrick Produit, productadmin@gmail.com, ProductManager</li>
            <li>Vincent Ventout, salemadmin@gmail.com, cumulant SaleManager et Customer</li>
            <li>Chris Client, client1@gmail.com, Customer</li>
            <li>Marie Bambelle, client2@gmail.com, Customer</li>
            <li>Elie Coptaire, client3@gmail.com, Customer</li>
            <li>Alain Térieur, client4@gmail.com, Customer</li>
            <li>Camille Honnête, client5@gmail.com, Customer</li>
            <li>Eléonore Labanquise, client6@gmail.com, Customer</li>
            <li>Marie Navoile, client7@gmail.com, Customer</li>
            <li>Sam Suffit, client8@gmail.com, Customer</li>
            <li>Nathalie Nouvelle, new@gmail.com, NotVerified</li>
            <li>Bernard Banning, banned@gmail.com, cumulant Customer et Banned</li>
            <li>Super Admin, superadmin@gmail.com, cumulant Customer, WebManager, SaleManager et ProductManager</li>
        </ul>
    </li>
</ul>
<h4>Développement</h4>
<p>Durant le développement du TPI, un Use Case <strong>temporaire</strong> simule certaines fonctionnalités qui sont nécessaires à la construction de l'application, 
mais qui sont développées par vos collègues sur ce projet, ou fourni par des partenaires externes. Ces fonctionnalités sont les suivantes :</p>
<ul>
    <li>Arborescence des catégories : le modèle pour les catégories fournit(ra) 2 méthodes :
        <ul>
            <li>getAllCategoriesBelongingTo(idCategory) : donne la liste complète des toutes les catégories descendantes de la catégorie passée en paramètre</li>
            <li>getBreadCrumbsFor(idCategory) : fournit le fil d'Ariane allant de la racine du site à la catégorie passée en paramètre</li>
            <li>Ces méthodes sont simulées dans le Use Case temporaire.
        </ul>
    </li>
    <li>Gestion du stock des produits:
    <ul>
        <li>La gestion du stock comporte une gestion de l'arrivage des produits, dont les numéros de produits/séries sont normalement fournis par le fabricant. </li>
        <li>Ce Use Case fournit un générateur de numéro de produits pour tous les articles (items) disponibles dans le site.</li>
    </ul>
    </li>
</ul>