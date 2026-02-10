# Laravel Music Store - Plateforme de vente d'albums

- [x] Verify that the copilot-instructions.md file in the .github directory is created.
- [x] Clarify Project Requirements - Plateforme de musique avec authentification
- [x] Scaffold the Project - Laravel scaffolding completed
- [x] Customize the Project - Project configured avec modèles et migrations
- [x] Install Required Extensions - No specific extensions required
- [x] Compile the Project - Composer et base de données configurés
- [x] Create and Run Task - Laravel Serve task created and running
- [x] Launch the Project - Server running on http://127.0.0.1:8000
- [x] Ensure Documentation is Complete - README and instructions updated

## Aperçu du projet

Plateforme de vente d'albums en ligne avec authentification client/admin, gestion de panier, système de paiement sécurisé et téléchargement d'albums.

### Fonctionnalités principales

#### Côté Client
- ✅ Inscription et connexion
- ✅ Consultation des albums disponibles
- ✅ Ajout d'albums au panier
- ✅ Paiement via MVola, Orange Money, Airtel Money
- ✅ Suivi des commandes et des paiements
- ✅ Téléchargement d'albums après paiement approuvé

#### Côté Admin
- ✅ Dashboard avec statistiques
- ✅ Gestion des albums (créer, modifier, supprimer)
- ✅ Gestion des morceaux (durée, titre)
- ✅ Historique complet des paiements
- ✅ Approbation/Rejet des paiements en attente
- ✅ Contrôle d'accès par rôle

## Accès à la plateforme

**URL:** http://127.0.0.1:8000

### Comptes de test

**Administrateur:**
- Email: admin@example.com
- Password: password

**Client:**
- Email: client@example.com
- Password: password

## Structure de la base de données

### Tables principales
- `users` - Utilisateurs (client/admin)
- `albums` - Albums avec artiste, titre, prix
- `tracks` - Morceaux de l'album
- `orders` - Commandes d'albums
- `payments` - Paiements des commandes

## Routes principales

### Client
- `GET /` - Accueil
- `GET /albums` - Liste des albums
- `GET /albums/{id}` - Détails d'un album
- `POST /orders` - Créer une commande
- `GET /orders` - Mes commandes
- `GET /payments/{order}` - Formulaire de paiement
- `POST /payments` - Enregistrer un paiement

### Admin
- `GET /admin/dashboard` - Dashboard
- `GET /admin/albums` - Mes albums
- `POST /admin/albums` - Créer un album
- `PUT /admin/albums/{id}` - Modifier un album
- `DELETE /admin/albums/{id}` - Supprimer un album
- `GET /admin/payments` - Historique des paiements
- `POST /admin/payments/{id}/approve` - Approuver un paiement
- `POST /admin/payments/{id}/reject` - Rejeter un paiement

## Architecture

### Modèles Eloquent
- `User` - Relations: albums, orders
- `Album` - Relations: user, tracks, orders
- `Track` - Relation: album
- `Order` - Relations: user, album, payment
- `Payment` - Relation: order

### Contrôleurs
- `AuthController` - Authentification
- `AlbumController` - Gestion des albums (clients)
- `AdminController` - Administration
- `OrderController` - Gestion des commandes
- `PaymentController` - Gestion des paiements

### Middleware
- `AdminMiddleware` - Vérification du rôle admin

## Flux d'achat

1. Client browse albums sur `/albums`
2. Client consulte détails sur `/albums/{id}`
3. Client ajoute au panier → crée une `Order`
4. Redirection vers `/payments/{order}` pour payer
5. Client sélectionne méthode de paiement
6. Client entre la référence de paiement
7. Admin valide le paiement via `/admin/payments`
8. Une fois approuvé, client peut télécharger l'album

## Données de test

**Albums créés:**
1. Album One - Artist One (9.99€, 3 morceaux)
2. Album Two - Artist Two (12.99€, 4 morceaux)
3. Album Three - Artist Three (10.99€, 2 morceaux)

## Commandes Laravel utiles

```bash
# Serveur de développement
php artisan serve

# Migrations
php artisan migrate          # Exécuter les migrations
php artisan migrate:reset    # Réinitialiser la DB
php artisan migrate:refresh  # Reset + Seed

# Seeders
php artisan db:seed         # Exécuter les seeders
php artisan db:seed --class=AlbumSeeder  # Seeder spécifique

# Génération
php artisan make:model Album -m          # Model + Migration
php artisan make:controller AlbumController --resource

# Autres
php artisan tinker          # Shell interactif
php artisan route:list      # Lister les routes
```

## Stack technologique

- **Framework:** Laravel 12
- **Base de données:** SQLite
- **Frontend:** Blade (templates PHP)
- **Authentification:** Session-based
- **Validation:** Laravel Validator

## Notes de sécurité

- Les mots de passe sont hashés avec bcrypt
- Les middlewares protègent les routes admin
- CSRF protection activée par défaut
- Validation des entrées utilisateur
- Relations protégées par user_id

## Pour continuer le développement

1. Implémenter les véritables passerelles de paiement
2. Ajouter les uploads de fichiers audio
3. Implémentation d'un système de recommandation
4. Notifications par email
5. API REST pour mobile
6. Optimisation des performances
7. Cache des albums populaires

