# Mini MVC Project

## Compte Admin
- **Email** : admin@admin.com
- **Mot de passe** : admin

## Installation et Lancement

Comment installer et ouvrir le projet avec XAMPP :

1.  **Prérequis** : Avoir [XAMPP](https://www.apachefriends.org/fr/index.html) installé.
2.  **Placement** : Placez le dossier du projet `mini_mvc` dans le répertoire `htdocs` de XAMPP (ex: `C:\xampp\htdocs\mini_mvc`).
3.  **Démarrage** : Ouvrez le panneau de contrôle XAMPP et démarrez **Apache** et **MySQL**.
4.  **Base de données** :
    - Accédez à [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
    - Créez une nouvelle base de données (ex: `mini_mvc`).
    - Cliquez sur "Importer" et choisissez le fichier `mini_mvc.sql` situé à la racine du projet.
    - Exécutez pour créer les tables et insérer les données.
    - *Note : Vérifiez que la configuration dans `app/config.ini` correspond à vos accès MySQL.*
5.  **Accès** : Ouvrez votre navigateur et allez à l'adresse [http://localhost/mini_mvc/public](http://localhost/mini_mvc/public).

### Alternative avec serveur PHP intégré

Si vous avez PHP installé et configuré dans votre PATH, vous pouvez lancer le projet sans Apache (XAMPP reste nécessaire pour MySQL) :

```bash
php -S 127.0.0.1:3004 -t public
```

Accédez ensuite à [http://127.0.0.1:3004](http://127.0.0.1:3004).

## Structure du Projet

```text
mini_mvc/
├── app/
│   ├── Controllers/    # Contrôleurs (Admin, User, Panier, etc.)
│   ├── Core/           # Noyau du framework
│   ├── Models/         # Modèles interagissant avec la BDD
│   ├── Views/          # Vues et templates
│   └── config.ini      # Configuration de la base de données
├── docs/               # Documentation supplémentaire
├── public/             # Point d'entrée (index.php), styles, scripts
├── vendor/             # Dépendances (Composer)
├── mini_mvc.sql        # Fichier SQL pour la base de données
└── README.md           # Ce fichier
```

## Fonctionnalités Principales

- **Administration** :
    - Gestion complète des produits (ajout, modification avec modale, suppression).
    - Gestion de la disponibilité des produits.
    - Vue d'ensemble pour l'administrateur.
- **Utilisateurs** :
    - Inscription et authentification.
    - Gestion du profil et mise à jour des informations.
- **Gestion des Produits (Ordinateurs)** :
    - Affichage de la liste des produits disponibles.
    - Détails des produits.
- **Système de Panier** :
    - Ajout de produits au panier.
    - Gestion du panier.
- **Historique** :
    - Suivi de l'historique d'achat (Commandes).
