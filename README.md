# Projet : Application TPI
Contexte : TPI réalisé par 3 candidats travaillant chacun sur leur partie
## Avancement : 
- structure de base permettant d'identifier (de manière très basique) les utilisateurs
- exemple d'implémentation d'un Use Case avec la gestion d'un dictionnaire

## Versions : 
- 1.0.0 : Livraison initiale
- 1.0.1 : 22.04.2021
  - adjonction de la gestion dynamique du menu utilisateur. Les fichiers modifiés sont :
    - commons/model/Menu.php
    - commons/views/menu.php
    - commons/views/Html.php
    - uc/user/register.php 
  - bugs dans le script sql de création de la bd et du compte corrigés. Cela concerne le fichier :
    - db/xyloglotte.sql

## Pour démarrer :
- installer la base de données avec le script db/tpi.sql
- ajuster si nécessaire les paramètres de connexion à la base de données (commons/model/config.php)

Il n'y a pas de réécriture des URL au niveau principal, contrairement à l'usage dans ce type de construction.
Le but est de ne pas rajouter une complexité de plus dans la résolution des URLs.



# Découpage du code : MVC
L'application est répartie dans une arborescence de répertoires, afin de permettre à plusieurs développeurs de travailler sur des parties distinctes du projet et d'en faciliter le regroupement après coup.

Les dossiers publics sont directement accessibles depuis le navigateur :
- css : contient la css du site
- js : contient le javascript du site
- images : (vide) destiné à contenir les images publiques du site 

Les dossiers dont l'accès depuis internet n'est pas autorisé :
- Ces dossiers contiennent un fichier .htaccess qui interdit explicitement l'accès depuis internet 
- Le dossier commons : contient la base du MVC
- Le dossier uc : contient les Use Case, qui sont eux-même réalisés en MVC :
  - user : contient la gestion des utilisateurs et des rôles. L'implémentation est minimaliste pour permettre à chacun de developper sa partie
  - temporary : contient du code "statique" utile à certains, en attendant que le candidat qui doit réaliser cette partie ait fait sa partie. 

Les dossiers et fichiers temporaires servant au développement de l'application
- bd : contient le script SQL de création de la BD, utile durant le développement, mais qui devra être supprimé en production
- .vscode : paramètres de configuration de Visual Studio Code, même remarque.

## Routage
- Tous les accès se font au travers du fichier index.php à la racine de l'application. Celui reçoit en paramètre GET le nom du Use Case concerné, ainsi que l'action demandée.
- La classe Routes (commons/controllers/Routes.php) définit la structure pour gérer le routage.
- Les diverses UC s'enregistrent dans l'application (uc/xx/register.php) en spécifiant les routes qui les concernent. A ce stade, le statut (rôle) de l'utilisateur est déjà connu, et on peut donc effectuer un routage différencié en fonction de ce rôle.
- En fonction des paramètres reçus, le contrôleur correspondant à l'action demandée est appelé.
- Les cas non désirés (erreurs 403, 404, 500) sont gérés.
  
## Contrôleurs
- Les contrôleurs correspondent à des actions. Ils se chargent, avec l'aide des modèles, de récupérer l'information où elle se trouve, de la traiter, puis d'appeler vues qui se chargent de l'affichage.
- Pour éditer un enregistrement, on aura 2 actions, 
  - débuter l'édition (et accéder au formulaire) puis 
  - enregister (soumettre et valider les données, puis les enregistrer dans la bd).

## Modèles
- Les modèles sont la mémoire du système, que ce soit de manière pérenne avec une base de données, ou plus temporaire, avec l'aide de la session.
- Les classes servant d'interface aux tables de la base de données ont un double rôle :
  - De manière dynamique, une instance de la classe représente l'objet qu'on a modélisé,
  - De manière statique, la classe fournit toutes les méthodes permettant d'interagir avec la base de données.

## Vues
- Les vues correspondent essentiellement aux pages HTML qui sont affichées dans par le navigateur.
- La classe statique Html (commons/views/Html.php) comporte plusieurs méthodes statiques utilitaires :
- La méthode showHtmlPage permet de construire une page complète :
  - Celle-ci prend en paramètre :
    - le nom de la page, 
    - le chemin d'accès au contenu à afficher et 
    - un tableau associatif contenant les données que la vue va afficher
  - Seuls ces paramètres sont accessibles par la vue.
- Les méthodes Select, CheckBoxes et RadioButtons servent à construire des éléments HTML de manière dynamiques, à l'aide des données provenant du modèle.
- La méthode MainMenu affiche le menu de l'application, en fonction de ce qui a été défini au moment de l'enregistrement des UC.

# Définir votre propre Use Case

Sur la base de l'exemple fourni avant le TPI, vous pouvez construire votre propre Use Case.
- créez un dossier pour votre usage dans le dossier uc, avec 3 sous-dossiers (models, views, controllers)
- dans le dossier models, définissez le(s) modèle(s) pour accéder à vos tables dans la base
- dans le dossier views, créez les vues correspondants aux affichages que vous voulez implémenter
- dans le dossier controllers, créez les contrôleurs qui se chargeront d'effectuer le traitement des actions demandées par l'utilisateur
- créez un fichier register.php qui permettra de référencer les routes que vous avez prévu, ainsi que les items visibles dans le menu
- finalement, dans le fichier index.php à la racine du site, ajoutez une référence à votre fichier register.php
- Vous pouvez évidemment créer d'autres dossiers dans l'UC, par exemple pour stocker des images ou des pdf dont l'accès doit être contrôlé.