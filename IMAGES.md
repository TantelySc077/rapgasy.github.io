## 📸 Système de Gestion des Images d'Albums

### Comment ajouter des photos aux albums

#### 1. **Via le Dashboard Admin**

**Créer un nouvel album avec photo:**
- Allez sur `/admin/albums`
- Cliquez sur le bouton "➕ Ajouter un album"
- Remplissez les informations:
  - Titre de l'album
  - Nom de l'artiste
  - Prix
  - Description
  - **Photo de l'album** (nouveau!)

**Ajouter une photo:**
- Cliquez sur la zone de drag-drop
- Ou glissez-déposez une image directement
- L'aperçu s'affichera automatiquement

**Formats acceptés:**
- JPEG, PNG, JPG, GIF
- Taille maximale: 2MB
- Résolution recommandée: 200x200px ou plus

#### 2. **Éditer un album existant**

- Allez sur `/admin/albums`
- Cliquez sur "Éditer" pour l'album
- La photo actuelle s'affiche
- Vous pouvez:
  - **Changer l'image:** Drag-drop ou cliquez
  - **Garder l'image:** Ne modifiez pas le champ
- Cliquez sur "Mettre à jour l'album"

#### 3. **Voir les images**

Les photos s'affichent automatiquement:
- **Accueil des albums** (`/albums`): Voir toutes les images en grille
- **Détail de l'album** (`/albums/{id}`): Grande image avec détails
- **Admin** (`/admin/albums`): Liste avec aperçus

### 📁 Structure de stockage

Les images sont stockées dans:
```
storage/app/public/albums/
```

Le lien symbolique permet l'accès via:
```
/storage/albums/album_*.jpg
```

### ⚙️ Configuration technique

**Fichiers modifiés:**
1. `app/Http/Controllers/AdminController.php` - Upload et suppression
2. `resources/views/admin/albums/create.blade.php` - Formulaire création
3. `resources/views/admin/albums/edit.blade.php` - Formulaire édition
4. `resources/views/albums/index.blade.php` - Affichage grille
5. `resources/views/albums/show.blade.php` - Affichage détail

**Fonctionnalités:**
- ✅ Upload multiple formats
- ✅ Drag & drop support
- ✅ Aperçu en temps réel
- ✅ Suppression automatique de l'ancienne image
- ✅ Validation des fichiers
- ✅ Responsive design

### 🎨 Exemple d'utilisation

```html
<!-- Afficher l'image dans une vue -->
@if($album->cover_image)
    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}">
@else
    <div>📷 Pas de photo</div>
@endif
```

### ⚠️ Notes importantes

1. **Lien symbolique:** Le dossier `/public/storage` doit être lié à `/storage/app/public`
   - Créer le lien: `php artisan storage:link`

2. **Permissions:** Assurez-vous que le serveur web peut écrire dans `/storage/app/public`

3. **Sauvegardes:** Sauvegardez régulièrement le dossier `storage/app/public/albums/`

4. **Performance:** Les images grandes ralentissent le chargement
   - Compressez avant upload
   - Optimisez la taille

### 🔧 Dépannage

**Les images ne s'affichent pas?**
- Vérifiez que le lien symbolique existe: `public/storage` → `storage/app/public`
- Exécutez: `php artisan storage:link`

**Erreur de permission?**
- Vérifiez les permissions du dossier: `chmod 755 storage/app/public`

**Upload échoue?**
- Vérifiez la taille du fichier (max 2MB)
- Utilisez les formats acceptés (JPEG, PNG, JPG, GIF)
