# Gestion de patrimoine

Projet de base pour une application de gestion de patrimoine en architecture microservices.

## Structure

- `backend/` : code PHP du service principal
- `backend/database/schema.sql` : schéma PostgreSQL initial
- `docker-compose.yml` : conteneur PostgreSQL et Adminer

## Lancer le projet

1. Démarrer PostgreSQL :
   ```bash
   docker compose up -d
   ```

2. Démarrer le serveur PHP local :
   ```bash
   cd backend
   php -S 127.0.0.1:8000 -t public
   ```

3. Ouvrir :
   - http://127.0.0.1:8000
   - http://127.0.0.1:8080 pour Adminer

## Base de données

Nom de la base : `patrimoine`
Utilisateur : `patrimoine`
Mot de passe : `patrimoine`

## Fonctionnalités de base

- gestion des biens
- gestion des propriétaires
- historique des transactions
- tableau de bord des valeurs

## Maquettes UI

Les maquettes de conception sont disponibles dans le dossier :

- `backend/public/mockups/login.html`
- `backend/public/mockups/dashboard.html`
- `backend/public/mockups/assets.html`
- `backend/public/mockups/users.html`

Ces pages sont des maquettes statiques de l’interface utilisateur, utiles pour la présentation visuelle du projet et pour la conception Figma.

## Prochaine étape recommandée

Migrer ce squelette vers Laravel pour obtenir une architecture backend plus complète, plus proche du sujet du projet.
