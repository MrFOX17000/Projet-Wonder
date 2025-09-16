# 🧠 Wonder – Version 5

Bienvenue dans la version 5 de **Wonder**, un projet réalisé dans le cadre de ma formation Symfony sur [Dyma](https://dyma.fr).

Après avoir posé les **bases visuelles** (V1), intégré les **formulaires** (V2), mis en place la **persistance des données** (V3) et ajouté l’**authentification** (V4), cette version se concentre sur une fonctionnalité incontournable : la **réinitialisation de mot de passe** 📧🔑.

---

## 🎯 Objectifs de la V5

-   Mise en place du **composant Mailer** pour l’envoi d’emails
-   Création d’un flux complet de **réinitialisation de mot de passe** :
    -   ✅ Formulaire de demande de réinitialisation (saisie de l’email)
    -   ✅ Envoi d’un **email** avec un **lien unique et temporaire**
    -   ✅ Formulaire sécurisé pour **définir un nouveau mot de passe**
-   Protection contre les abus (tokens uniques, **expiration**)
-   UX améliorée via des **messages flash** adaptés

---

## 🧰 Tech utilisées

-   Symfony 6.x
-   Twig
-   Security Bundle
-   Doctrine ORM
-   Symfony Mailer
-   Bootstrap 5 (via Webpack Encore)

---

## 📸 Aperçu

A venir !!!

---

## 🗂️ Structure des fichiers (simplifiée)

src/
├── Controller/
│ └── ResetPasswordController.php # Gère la réinitialisation de mot de passe
├── Entity/
│ └── User.php # Entité utilisateur
├── Security/
│ └── LoginFormAuthenticator.php # Authentification
templates/
├── reset_password/
│ ├── request.html.twig # Formulaire de demande de reset
│ ├── check_email.html.twig # Confirmation d’envoi
│ └── reset.html.twig # Nouveau mot de passe
email/
├── css/
│ └── welcome.css # Styles pour l'email de bienvenue
└── templates/
└── welcome.html.twig # Template Twig pour l'email de bienvenue

---

## 🚀 Prochaine étape : Version 6

👉 Mise en place de l’upload de fichiers (ex. upload d’images ou documents) et intégration avancée avec Webpack Encore pour gérer les assets (JS/CSS).
L’application commencera à manipuler des fichiers côté utilisateur 📂.

---

## 👨‍💻 Auteur

Projet fil rouge développé par **Mathias**  
📚 Formation Symfony – [Dyma](https://dyma.fr)  
👉 En recherche active d’un poste en développement web (Symfony/PHP)  
📫 [Me contacter](mailto:renardmathias2@gmail.com)

---

## 📝 Licence

Projet sous licence MIT – à but pédagogique 😎
