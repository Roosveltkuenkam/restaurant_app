# Gestion des Utilisateurs - Guide Complet

## Vue d'ensemble

Le système de gestion des utilisateurs permet aux administrateurs de :
- **Lister** tous les utilisateurs avec pagination
- **Créer** de nouveaux utilisateurs avec rôles et succursale
- **Consulter** les détails d'un utilisateur
- **Modifier** les informations d'un utilisateur
- **Supprimer** (soft delete) un utilisateur

## Routes

Les routes suivantes sont disponibles pour les administrateurs authentifiés :

```
GET    /admin/users              → Liste des utilisateurs (index)
GET    /admin/users/create       → Formulaire de création
POST   /admin/users              → Enregistrer nouvel utilisateur (store)
GET    /admin/users/{id}         → Afficher détails utilisateur (show)
GET    /admin/users/{id}/edit    → Formulaire de modification
PUT    /admin/users/{id}         → Mettre à jour utilisateur (update)
DELETE /admin/users/{id}         → Supprimer utilisateur (destroy)
```

## Architecture

### Modèle (Model)
- **Fichier** : `app/Models/User.php`
- **Traits** : `HasApiTokens`, `HasFactory`, `Notifiable`, `SoftDeletes`
- **Fillable** : `name`, `email`, `password`, `branch_id`
- **Relations** :
  - `branch()` : Succursale associée
  - `roles()` : Rôles (many-to-many)
  - `openedOrders()` : Commandes ouvertes
  - `takenPayments()` : Paiements traités

### Contrôleur (Controller)
- **Fichier** : `app/Http/Controllers/Web/Admin/UserController.php`
- **Méthodes** :
  - `index()` : Liste avec pagination
  - `create()` : Formulaire de création
  - `store()` : Validation et enregistrement
  - `show()` : Affichage détails
  - `edit()` : Formulaire de modification
  - `update()` : Validation et mise à jour
  - `destroy()` : Suppression logique (soft delete)

### Validation (FormRequests)
- **StoreUserRequest** (`app/Http/Requests/StoreUserRequest.php`)
  - Email unique
  - Mot de passe min 8 caractères
  - Confirmation de mot de passe
  - Rôles optionnels
  
- **UpdateUserRequest** (`app/Http/Requests/UpdateUserRequest.php`)
  - Email unique (sauf l'utilisateur actuel)
  - Mot de passe optionnel
  - Rôles optionnels

### Vues (Views)
- `resources/views/admin/users/index.blade.php` : Liste avec actions
- `resources/views/admin/users/create.blade.php` : Formulaire de création
- `resources/views/admin/users/edit.blade.php` : Formulaire de modification
- `resources/views/admin/users/show.blade.php` : Détails utilisateur
- `resources/views/admin/users/_form.blade.php` : Composant formulaire réutilisable

## Utilisation

### 1. Accéder à la liste des utilisateurs
```
Naviguer vers : http://localhost/admin/users
```

### 2. Créer un nouvel utilisateur
```
1. Cliquer sur "+ Ajouter un utilisateur"
2. Remplir le formulaire :
   - Nom (obligatoire)
   - Email (obligatoire, unique)
   - Mot de passe (obligatoire, min 8 caractères)
   - Confirmation du mot de passe
   - Succursale (optionnel)
   - Rôles (optionnel : checkboxes)
3. Cliquer sur "Créer l'utilisateur"
```

### 3. Consulter les détails d'un utilisateur
```
1. Cliquer sur "Voir" dans la ligne de l'utilisateur
2. Page affichant :
   - Nom, Email
   - Dates de création/modification
   - Succursale assignée
   - Rôles assignés
   - Boutons : Éditer, Supprimer
```

### 4. Modifier un utilisateur
```
1. Accès via "Éditer" dans la liste ou page de détails
2. Modifier les champs voulus :
   - Mot de passe (optionnel, laisser vide pour ne pas changer)
   - Rôles
   - Succursale
3. Cliquer sur "Mettre à jour"
```

### 5. Supprimer un utilisateur
```
1. Cliquer sur "Supprimer" dans la liste ou page de détails
2. Confirmer la suppression
3. Utilisateur soft-deleted (conservé en DB avec deleted_at)
```

## Tests

Exécuter les tests feature pour valider la fonctionnalité :

```bash
# Tous les tests de gestion utilisateur
php artisan test tests/Feature/UserManagementTest.php

# Test spécifique
php artisan test tests/Feature/UserManagementTest.php --filter=test_store_user

# Avec output détaillé
php artisan test tests/Feature/UserManagementTest.php -v

# Avec coverage
php artisan test tests/Feature/UserManagementTest.php --coverage
```

### Tests inclus
1. ✅ `test_list_users_page` : Page liste accessible
2. ✅ `test_create_user_page` : Page création accessible
3. ✅ `test_store_user` : Création utilisateur valide
4. ✅ `test_store_user_validation_fails` : Validation échouée
5. ✅ `test_show_user` : Affichage détails
6. ✅ `test_edit_user_page` : Page modification accessible
7. ✅ `test_update_user` : Mise à jour utilisateur
8. ✅ `test_delete_user` : Suppression soft-delete
9. ✅ `test_non_admin_cannot_access_users` : Protection RBAC
10. ✅ `test_unauthenticated_redirect_to_login` : Redirect non-auth

## Sécurité

- **Authentification** : Middleware `web.auth` (login requis)
- **Autorisation** : Middleware `web.role:ADMIN` (rôle ADMIN requis)
- **Validation** : FormRequest avec règles strictes
- **Mot de passe** : Hashé avec `bcrypt`
- **CSRF** : Protection automatique Blade `@csrf`
- **Soft Delete** : Utilisateurs supprimés conservés (not actually deleted)

## Commandes artisan utiles

```bash
# Migrer la DB (ajouter colonne deleted_at à users)
php artisan migrate

# Lister les routes utilisateurs
php artisan route:list --name=admin.users

# Seed des utilisateurs de test
php artisan tinker
> User::factory(5)->create();
```

## Exemples

### Créer un utilisateur via Tinker
```bash
php artisan tinker
```

```php
> $user = User::create([
    'name' => 'Alice Admin',
    'email' => 'alice@example.com',
    'password' => bcrypt('secret123'),
]);
> $admin = Role::where('name', 'ADMIN')->first();
> $user->roles()->attach($admin);
> $user
```

### Récupérer les utilisateurs avec rôles
```php
$users = User::with('roles')->get();
foreach ($users as $user) {
    echo $user->name . ": " . $user->roles->pluck('name')->join(', ') . "\n";
}
```

## Prochaines améliorations possibles

- [ ] Recherche/filtres avancés par nom/email/rôle
- [ ] Import/export CSV
- [ ] Logs d'audit (qui a créé/modifié)
- [ ] Permissions granulaires (au-delà des rôles)
- [ ] Avatar/photo de profil
- [ ] Activation/désactivation (flag booléen)
- [ ] Double authentification (2FA)
- [ ] Session management (forcer déconnexion)

---

**Version** : 1.0  
**Dernier mise à jour** : 28 Janvier 2026
