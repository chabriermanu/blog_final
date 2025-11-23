📺 Blog Séries TV de mon Enfance (80-2000)

Projet ECF - Développeur Web et Web Mobile @ AFPA Saint-Jean-de-Védas
Validation des compétences CRUD et développement PHP/MySQL

Blog personnel dédié aux séries télévisées et dessins animés qui ont marqué mon enfance (années 80 à 2000). Ce projet constitue mon évaluation de certification ECF et valide ma maîtrise du CRUD en PHP/MySQL.
Afficher l'image
Afficher l'image
Afficher l'image

🎯 Objectifs du projet ECF
Ce projet valide l'ensemble des compétences acquises en formation, avec un focus particulier sur :

Maîtrise du CRUD (Create, Read, Update, Delete)
Développement d'une application PHP/MySQL complète
Sécurisation d'une application web
Conception de base de données relationnelle

✨ Fonctionnalités développées
📝 Gestion des Articles (CRUD complet)

✅ Create : Création d'articles avec titre, contenu et image
✅ Read : Affichage des articles avec pagination
✅ Update : Modification des articles existants
✅ Delete : Suppression sécurisée d'articles

🔐 Authentification & Rôles

Inscription et connexion sécurisées
Gestion des rôles : Visiteur, Membre, Auteur
Hashage des mots de passe avec password_hash()

🏷️ Système de Catégories

CRUD sur les catégories
Relation many-to-many articles ↔ catégories
Filtrage des articles par catégorie

💬 Commentaires

Système de commentaires sur les articles
Commentaires pour membres et visiteurs anonymes
Modération par les auteurs

🎨 Interface & UX

Design responsive avec Bootstrap 5
Carousel d'articles en page d'accueil
Upload et gestion d'images
Navigation intuitive

🛠️ Stack technique
CatégorieTechnologiesBackendPHP 8Base de donnéesMySQL / MariaDBFrontendHTML5, CSS3, JavaScriptFramework CSSBootstrap 5Serveur localWAMPVersioningGit / GitHub
🔒 Sécurité implémentée
✅ Protection SQL Injection : PDO avec requêtes préparées
✅ Protection XSS : htmlspecialchars() sur toutes les sorties
✅ Hashage sécurisé : password_hash() / password_verify()
✅ Validation des données : Côté serveur et client
✅ Gestion des sessions : Sessions PHP sécurisées
✅ Upload sécurisé : Validation type MIME et taille des fichiers
🏗️ Structure du projet
blog_final/
├── index.php              # Page d'accueil avec carousel
├── article.php            # Affichage d'un article
├── login.php / register.php
├── admin/                 # Interface CRUD
│   ├── articles/
│   ├── categories/
│   └── comments/
├── functions/             # Logique métier séparée
│   ├── users.php
│   ├── articles.php
│   ├── categories.php
│   └── comments.php
├── config/
│   └── database.php       # Configuration BDD
└── assets/
    ├── css/
    ├── js/
    └── images/
📊 Base de données
Tables principales

users : Utilisateurs avec rôles
articles : Articles du blog
categories : Catégories thématiques
articles_categories : Table de liaison (N:N)
comments : Commentaires

Relations

Un utilisateur → plusieurs articles (1:N)
Un article ↔ plusieurs catégories (N:N)
Un article → plusieurs commentaires (1:N)

🚀 Installation locale
bash# 1. Cloner le repository
git clone https://github.com/chabriermanu/blog_final.git

# 2. Créer la base de données
# - Ouvrir phpMyAdmin
# - Créer une BDD "blog_ecf"
# - Importer database.sql

# 3. Configuration
# Modifier config/database.php avec vos identifiants

# 4. Accéder à l'application
# http://localhost/blog_final
📝 Compétences techniques démontrées
Développement Backend
✅ CRUD complet en PHP
✅ Architecture MVC simplifiée
✅ Programmation structurée avec fonctions
✅ Gestion des sessions
✅ Upload et traitement d'images
Base de données
✅ Conception de schéma relationnel
✅ Requêtes SQL (SELECT, INSERT, UPDATE, DELETE)
✅ Jointures (INNER JOIN, LEFT JOIN)
✅ Relations many-to-many
Frontend
✅ HTML5 sémantique
✅ CSS3 responsive
✅ JavaScript vanilla
✅ Bootstrap 5
✅ Formulaires avec validation
Sécurité
✅ Prévention des vulnérabilités OWASP
✅ PDO et requêtes préparées
✅ Sanitisation des données
✅ Gestion sécurisée des mots de passe

## 🎓 Contexte de réalisation
**Formation** : Développeur Web et Web Mobile  
**Organisme** : AFPA Saint-Jean-de-Védas  
**Type de projet** : ECF (Évaluation en Cours de Formation)  
**Objectif pédagogique** : Validation de la maîtrise du CRUD  
**Période** : 2025  
**Durée de développement** : 1 semaine
🔧 Améliorations futures envisagées

 Système de recherche d'articles
 Statistiques de consultation
 Export des articles en PDF
 API REST
 Tests unitaires

👨‍💻 Auteur
Emmanuel Chabrier
Développeur Web & Web Mobile en formation
Afficher l'image
Afficher l'image
📧 chabrier.manu@gmail.com
📍 Saint Genies de Fontedit, France
🔍 Recherche stage 10 semaines - Février 2026
📄 Licence
Projet réalisé dans un cadre pédagogique (AFPA).

⭐ N'hésitez pas à explorer le code et à me faire vos retours !

Dernière mise à jour : Novembre 2024
