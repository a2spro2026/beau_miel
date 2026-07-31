@extends('layouts.admin')

@section('title', 'Paramètres — BEAUMIEL')
@section('page_title', 'Paramètres')
@section('nav_settings', 'is-active')
@section('nav_params', 'is-open')

@section('content')
<section class="settings-page">
    <div class="settings-intro">
        <p class="admin-welcome-kicker">Configuration</p>
        <h2>Paramètres vidéo &amp; habillage</h2>
        <p>Personnalisez le cadre vidéo de la page d’accueil : habillage, titre, description et source.</p>
    </div>

    @if (session('success'))
        <p class="settings-flash">{{ session('success') }}</p>
    @endif

    <div class="settings-modal-card" role="dialog" aria-labelledby="settingsTitle">
        <header class="settings-modal-head">
            <div>
                <p class="settings-kicker">Espace média</p>
                <h3 id="settingsTitle">Paramètres du cadre vidéo</h3>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="settings-close-link">Fermer</a>
        </header>

        <form
            class="settings-form"
            action="{{ route('admin.settings.update') }}"
            method="post"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="settings-field">
                <label for="habillage">Habillage</label>
                <div class="settings-habillage">
                    <div class="settings-habillage-preview">
                        <img
                            src="{{ \App\Support\SiteSettings::habillageSrc($settings) }}"
                            alt="Aperçu habillage"
                            id="habillagePreview"
                        >
                    </div>
                    <label class="settings-file-btn">
                        <input type="file" id="habillage" name="habillage" accept="image/*">
                        Choisir une image
                    </label>
                </div>
                @error('habillage') <p class="settings-error">{{ $message }}</p> @enderror
            </div>

            <div class="settings-field">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" value="{{ old('titre', $settings['titre']) }}" maxlength="120" placeholder="Ex. Notre histoire">
                @error('titre') <p class="settings-error">{{ $message }}</p> @enderror
            </div>

            <div class="settings-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" maxlength="255" placeholder="Courte description affichée sur le cadre">{{ old('description', $settings['description']) }}</textarea>
                @error('description') <p class="settings-error">{{ $message }}</p> @enderror
            </div>

            <div class="settings-field">
                <label for="video_file">Importer</label>
                <label class="settings-file-btn settings-file-btn-wide">
                    <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm,video/quicktime">
                    <span id="videoFileLabel">
                        @if (!empty($settings['video_file']))
                            Fichier actuel : {{ basename($settings['video_file']) }}
                        @else
                            Importer une vidéo (mp4, webm)
                        @endif
                    </span>
                </label>
                @error('video_file') <p class="settings-error">{{ $message }}</p> @enderror
            </div>

            <div class="settings-field settings-url-block">
                <label class="settings-check">
                    <input type="checkbox" name="use_url" value="1" id="useUrl" {{ old('use_url', $settings['use_url']) ? 'checked' : '' }}>
                    <span>Coller URL ?</span>
                </label>
                <input
                    type="url"
                    id="video_url"
                    name="video_url"
                    value="{{ old('video_url', $settings['video_url']) }}"
                    placeholder="https://..."
                    {{ old('use_url', $settings['use_url']) ? '' : 'disabled' }}
                >
                @error('video_url') <p class="settings-error">{{ $message }}</p> @enderror
            </div>

            <div class="settings-actions">
                <button type="submit" class="settings-validate">Valider</button>
                <a href="{{ route('admin.dashboard') }}" class="settings-cancel">Fermer</a>
            </div>
        </form>
    </div>
</section>

<script>
    (() => {
        const useUrl = document.getElementById('useUrl');
        const videoUrl = document.getElementById('video_url');
        const habillage = document.getElementById('habillage');
        const preview = document.getElementById('habillagePreview');
        const videoFile = document.getElementById('video_file');
        const videoFileLabel = document.getElementById('videoFileLabel');

        useUrl?.addEventListener('change', () => {
            if (!videoUrl) return;
            videoUrl.disabled = !useUrl.checked;
            if (useUrl.checked) videoUrl.focus();
        });

        document.querySelector('.settings-form')?.addEventListener('submit', () => {
            if (videoUrl) videoUrl.disabled = false;
        });

        habillage?.addEventListener('change', () => {
            const file = habillage.files?.[0];
            if (!file || !preview) return;
            preview.src = URL.createObjectURL(file);
        });

        videoFile?.addEventListener('change', () => {
            const file = videoFile.files?.[0];
            if (file && videoFileLabel) videoFileLabel.textContent = file.name;
        });
    })();
</script>
@endsection
