
# 🏋️ Sportify - Plateforme de Coaching Sportif

**Projet de Développement Web & Bases de Données (ECE Paris)**

## 📌 Présentation

**Sportify** est une application web interactive conçue pour faciliter la mise en relation entre des coachs sportifs et leurs clients. La plateforme permet de gérer des profils de coachs dans diverses disciplines (musculation, natation, fitness, etc.), de consulter leurs disponibilités et de prendre rendez-vous directement en ligne.

## 🛠️ Fonctionnalités Clés

* 
**Système de Réservation :** Prise de rendez-vous dynamique avec gestion des créneaux horaires (`horaire_salle.php`, `initialize_creneaux.php`).


* 
**Catalogue Multisport :** Recherche de coachs par spécialités : Fitness, Musculation, Natation, Basket, Rugby, etc.


* 
**Espace Utilisateur Complet :** Inscription et connexion sécurisées (`signup.php`, `login.php`) pour les clients et les coachs.


* 
**Communication Intégrée :** Système de messagerie et formulaires de contact (`send_message.php`, `chat.php`).


* **Administration :** Interface dédiée pour la gestion des coachs et des services (`ajouter_coach.php`, `modifier_coach.php`).

## 💻 Technologies Utilisées

* 
**Frontend :** Architecture moderne en HTML5, CSS3 et JavaScript pour une interface fluide et responsive.


* 
**Backend :** Logique serveur développée en **PHP** pour la gestion dynamique du contenu.


* 
**Base de Données :** Gestion des données utilisateurs et des réservations via **SQL**.


* 
**Outils :** Développement effectué sous VS Code avec versionnage Git.



## 📂 Architecture du Projet

D'après l'organisation des fichiers, le projet est structuré comme suit :

* **Racine :** Pages principales (`index.php`), gestion des sessions (`login.php`, `signup.php`) et logique de réservation (`rdv.php`, `reserve.php`).
* **Logique Coach :** Fichiers spécifiques pour l'affichage des profils (`coach_profile.php`) et la gestion administrative (`ajouter_coach.php`).
* **Ressources :** Dossiers dédiés pour le traitement des mails (`PHPMailer`), les fichiers médias (`uploads`) et les données structurées (`XML`).
* **Assets :** Styles CSS personnalisés (`styles.css`) et scripts dynamiques (`script.js`).

