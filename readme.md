Création de l'API pour l'application Pat'Match en cours.

# API de l'application Pat'Match 🦮

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=Symfony&logoColor=white)

---

## Introduction 🎬

todo

---

## Configuration du projet ⚙️

### Installation 🔧
Pour installer les dépendances du projet, exécutez la commande suivante :
```bash
composer install
```

### Utilisation de l'ORM Doctrine de Symfony ✨
1. Creer un fichier `.env.local` à la racine du projet
Ce fichier permettra de configurer la connexion à votre base de données. Voici un exemple de configuration :
```bash
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
```

2. Paramètres à modifier :
    - `app` : Nom d'utilisateur de votre base de données.
    - `!ChangeMe!` : Mot de passe de votre base de données.
    - `3306` : Port utilisé par votre instance MySQL (à modifier si nécessaire).
    - `app` : Nom de la base de données.
    - `8.0.32` : Version de votre serveur MySQL (à adapter).

3. Commandes pour préparer la base de données :
    - Créez la base de données :
        ```bash
        php bin/console doctrine:database:create
      ```

    - Appliquez les migrations (structure de la base de données) :
        ```bash
        php bin/console doctrine:migration:migrate
        ```

    - Chargez les données de test :
        ```bash
        php bin/console doctrine:fixtures:load
        ```

### Lancez le serveur 💻
Pour lancer le serveur local et accéder à votre projet :
```bash
symfony serve --no-tls
```
---