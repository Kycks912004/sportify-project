[![Site Live](https://img.shields.io/badge/🌐_Site-Live_GitHub_Pages-4CAF50?style=for-the-badge)](https://kycks912004.github.io/sportify-project/)
[![Interface](https://img.shields.io/badge/HTML5-Code%20Source-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://github.com/Kycks912004/sportify-project/tree/main/TD6_07_Sportify-main/ensemble)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?style=for-the-badge&logo=github)](https://github.com/Kycks912004/sportify-project)

# 🏋️ Sportify - Plateforme de Coaching Sportif

## 🖼️ Aperçu du Projet

<div align="center">

| Page d'accueil | Login | Recherche |
|:-:|:-:|:-:|
| ![Accueil](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/Accueil.jpg) | ![Login](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/Login.jpg) | ![Recherche](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/Recherche.jpg) |

| Activités | Mon compte | Tout parcourir |
|:-:|:-:|:-:|
| ![Activités](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/Acivit%C3%A9s_sportives.jpg) | ![Compte](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/Votre%20compte.jpg) | ![Parcourir](https://raw.githubusercontent.com/Kycks912004/sportify-project/main/TD6_07_Sportify-main/PJ_WEB_2024_MAZLOUM_PINTO_OREL_CHEKROUN/Storyboard/tout_parcourir.jpg) |

</div>

---

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

## 👤 Auteur

**Kylian Pinto** — ECE Paris · Mazloum · Orel · Chekroun  
[![GitHub](https://img.shields.io/badge/GitHub-Kycks912004-181717?style=flat&logo=github)](https://github.com/Kycks912004)

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

