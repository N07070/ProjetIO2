# Project

*Projet d'Internet et Outil du deuxième semestre de la fac Paris 7*

## Présentation

**Abstract**

Tanlax est un site web qui permet aux étudiant.es de la fac de Paris Diderot de déposer et chercher des projets qu'ils cherchent à réaliser avec d'autres étudiant.es. Les projets sont triés selon leur popularité et peuvent être haut-voté ou bas-voté

L'expérience utilisateur typique commence quand on arrive sur la page d'acceuil ou des projets sont mit en avant en fonction de leur popularité ou si ils viennent d'être posté.

Le site se compose des pages suivantes :
- Un profil utilisateur
    - Page de login + signup
    - Page de préférence du compte
        - Photo de profil
        - Infor perso
        - changement de mot de passe
        - thème
        - Accessibilité
        - Désincription / suppression de compte
- Page d'acceuil
    - Page spécifique à un message
        - Commentaires
        - Vote
- Page de recherche / tags
- Page de post de message
- Page de messagerie entre utilisateurs
- Page d'erreurs

### Objets nécéssaires

- User,
    - Admin,
- Projet,
    - Projet mit en avant
- Message,

### Descrition des fonctions

- Projet:
    - Une/plusieurs photos,
    - Titre,
    - Description,
        - résumé du projet,
        - explications concrète.
    - Tags,
    - Status
        - Actif, Terminé avec succès ou fail.
    - Date limite,
    - Date de création
    - Commentaires

- Utilisateur,
    - Photo de profil,
    - Bio,
    - Nom,
    - Informations de contact,
    - Messagerie,
        - Admin
            - Droits


### Structure de la base de données

- projects
    - uuid
    - nbr_upvote
    - nbr_downvote
    - owner
    - participants
    - creation_date
    - is_featured
    - title
    - tags
    - status
    - limit_date
    - pictures
    - resume
    - description

- users
    - uuid
    - username
    - email
    - password
    - profile_picture
    - biography
    - is_admin
    - date_creation
    - is_premium

- comments
    - UUID
    - project
    - comments
    - user
    - date

- Messages
    - user_from
    - user_to
    - date
    - text

### Algorithme de classement pour la page d'index

*Ensuite, l'utilisateur pourra classer dans la recherche en fonction de ce qu'iel veut*

- Variables
    - Ratio : 0.6 ( 0 - 1 )
        - Nombre d'upvote / Nombre de downvote
    - Date de publication de projet : 0.1 ( 1 - 0 )
        - décrémente de façon logarithmique
        - Par rapport au moment où l'utilisateur consulte la page.
    - Ratio d'intérêt : 0.3
        - Nombre de participant.es intéressé.es / nombres de votes  ( 0 - 1 )

### Liens et notes

- PHP MVC : https://www.sitepoint.com/the-mvc-pattern-and-php-1/
- Hash et salt des mots de passe : https://openclassrooms.com/courses/securiser-les-mots-de-passe-des-utilisateurs-avec-php
- Filtrer les infos utilisateur : https://openclassrooms.com/courses/les-filtres-en-php-pour-valider-les-donnees-utilisateur
- Checklist : http://webdevchecklist.com/