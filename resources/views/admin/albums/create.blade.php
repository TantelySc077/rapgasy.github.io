@extends('layout.app')

@section('title', 'Créer un album')

@section('styles')
<style>
    .form-container {
        max-width: 600px;
        margin: 2rem auto;
    }
    
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-card h1 {
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
    }
    
    input, textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: inherit;
        font-size: 1rem;
    }
    
    input:focus, textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
    }
    
    textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .image-input-wrapper {
        position: relative;
        border: 2px dashed #667eea;
        border-radius: 5px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .image-input-wrapper:hover {
        background-color: rgba(102, 126, 234, 0.05);
        border-color: #764ba2;
    }
    
    .image-input-wrapper input[type="file"] {
        display: none;
    }
    
    .image-preview {
        margin-top: 1rem;
        display: none;
    }
    
    .image-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .upload-placeholder {
        color: #999;
        font-size: 0.9rem;
    }
    
    small {
        display: block;
        margin-top: 0.5rem;
        color: #999;
    }
    
    .btn-submit {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        width: 100%;
        padding: 0.75rem;
        background-color: #95a5a6;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 0.5rem;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    
    .btn-cancel:hover {
        background-color: #7f8c8d;
    }

    .tracks-section {
        background: #f9f9f9;
        padding: 1.5rem;
        border-radius: 5px;
        margin: 2rem 0;
        border: 1px solid #eee;
    }

    .tracks-section h3 {
        color: #333;
        margin-bottom: 1rem;
    }

    .track-item {
        display: grid;
        grid-template-columns: 3fr 1fr 2fr auto;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 5px;
        border: 1px solid #ddd;
        align-items: center;
    }

    .track-item input {
        margin: 0;
    }

    .btn-remove-track {
        padding: 0.5rem 0.75rem;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-remove-track:hover {
        background-color: #c0392b;
    }

    .btn-add-track {
        padding: 0.75rem 1.5rem;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .btn-add-track:hover {
        background-color: #229954;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="form-card">
        <h1>Créer un nouvel album</h1>
        
        <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Titre de l'album</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="artist_name">Nom de l'artiste</label>
                <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name') }}" required>
                @error('artist_name')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">Prix (Ar)</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                @error('price')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="cover_image">Photo de l'album</label>
                <div class="image-input-wrapper" onclick="document.getElementById('cover_image').click()">
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    <div class="upload-placeholder">
                        📷 Cliquez pour télécharger une image<br>
                        <small>ou glissez-déposez</small>
                    </div>
                </div>
                <div class="image-preview" id="imagePreview">
                    <p style="font-size: 0.9rem; color: #999; margin-bottom: 0.5rem;">Aperçu:</p>
                    <img id="previewImage" alt="Aperçu">
                </div>
                <small style="color: #999;">Formats acceptés: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                @error('cover_image')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="album_file">Fichier de l'album (ZIP/RAR)</label>
                <div class="image-input-wrapper" style="padding: 1rem;" onclick="document.getElementById('album_file').click()">
                    <input type="file" id="album_file" name="album_file" accept=".zip,.rar,.7z">
                    <div class="upload-placeholder" id="filePlaceholder">
                        📦 Cliquez pour télécharger l'album complet (ZIP)<br>
                        <small>ou glissez-déposez</small>
                    </div>
                </div>
                <small style="color: #999;">Fichier unique contenant tous les morceaux (Max: 200MB)</small>
                @error('album_file')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_published" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} style="width: auto;">
                    Publier l'album immédiatement
                </label>
            </div>


            <!-- Section Morceaux -->
            <div class="tracks-section">
                <h3>🎵 Morceaux de l'album</h3>
                <div id="tracksContainer">
                    <!-- Les morceaux seront ajoutés dynamiquement ici -->
                </div>
                <button type="button" class="btn-add-track" onclick="addTrack()">+ Ajouter un morceau</button>
            </div>
            
            <button type="submit" class="btn-submit">Créer l'album</button>
            <a href="{{ route('admin.albums.index') }}" class="btn-cancel">Annuler</a>
        </form>
    </div>
</div>

    </div>
</div>

<script>
// Gestion de l'affichage du nom de fichier ZIP
const albumFileInput = document.getElementById('album_file');
const filePlaceholder = document.getElementById('filePlaceholder');

if(albumFileInput) {
    albumFileInput.addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            const file = e.target.files[0];
            filePlaceholder.innerHTML = '📦 ' + file.name;
            filePlaceholder.style.color = '#27ae60';
            filePlaceholder.style.fontWeight = 'bold';
        }
    });
}


let trackCount = 0;

function addTrack() {
    trackCount++;
    const tracksContainer = document.getElementById('tracksContainer');
    const trackItem = document.createElement('div');
    trackItem.className = 'track-item';
    trackItem.id = 'track-' + trackCount;
    trackItem.innerHTML = `
        <div>
            <input type="text" name="tracks[${trackCount}][title]" placeholder="Titre du morceau" required style="width: 100%;">
        </div>
        <div>
            <input type="number" name="tracks[${trackCount}][duration]" placeholder="Durée (sec)" min="1" required style="width: 100%;">
        </div>
        <button type="button" class="btn-remove-track" onclick="removeTrack(${trackCount})">✕ Supprimer</button>
    `;
    tracksContainer.appendChild(trackItem);
}

function removeTrack(id) {
    const trackItem = document.getElementById('track-' + id);
    if (trackItem) {
        trackItem.remove();
    }
}

// Ajouter un premier morceau par défaut
document.addEventListener('DOMContentLoaded', function() {
    addTrack();
});

const imageInput = document.getElementById('cover_image');
const imagePreview = document.getElementById('imagePreview');
const previewImage = document.getElementById('previewImage');
const imageInputWrapper = document.querySelector('.image-input-wrapper');

// Gestion du changement de fichier
imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImage.src = event.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Gestion du drag and drop
imageInputWrapper.addEventListener('dragover', function(e) {
    e.preventDefault();
    imageInputWrapper.style.backgroundColor = 'rgba(102, 126, 234, 0.1)';
});

imageInputWrapper.addEventListener('dragleave', function(e) {
    e.preventDefault();
    imageInputWrapper.style.backgroundColor = '';
});

imageInputWrapper.addEventListener('drop', function(e) {
    e.preventDefault();
    imageInputWrapper.style.backgroundColor = '';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        imageInput.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
