# Upload de fichiers

Petit site en HTML / PHP qui permet d'envoyer un document sur le serveur.
Projet réalisé dans le cadre du module Maintenance Applicative.

**Démo en ligne : [yacineharrache.fr/maintenance](https://yacineharrache.fr/maintenance)**

## Fonctionnalités

- Formulaire avec un bouton pour parcourir ses documents et un bouton Envoyer
- Validation côté serveur en PHP
- Formats autorisés : PDF, JPG, JPEG, PNG, TXT, DOCX
- Taille maximale : 2 Mo
- Fichier renommé avec un identifiant unique puis déposé dans `uploads/`
- Enregistrement des infos du fichier (nom, extension, taille, date) en base MySQL

## Structure

```
upload-fichiers/
├── index.php            Page 1 : formulaire d'envoi
├── upload.php           Page 2 : validation, dépôt et résultat
├── config.example.php   Modèle de configuration de la base
├── sql/
│   └── base.sql         Script de création de la table
└── uploads/             Dossier où sont déposés les fichiers
```

## Technologies

- HTML5
- PHP 8
- MySQL / MariaDB
- Bootstrap 5 (CDN)

## Installation

1. Cloner le dépôt
2. Importer `sql/base.sql` dans la base de données (phpMyAdmin sur AlwaysData)
3. Copier `config.example.php` en `config.php` et renseigner les identifiants de la base
4. Vérifier que le dossier `uploads/` est accessible en écriture
5. Ouvrir `index.php` dans le navigateur

En local :

```bash
php -S localhost:8000
```

## Auteur

Yacine Harrache
