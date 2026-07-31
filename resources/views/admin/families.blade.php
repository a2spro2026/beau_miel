@extends('layouts.admin')

@section('title', 'Famille produits — BEAUMIEL')
@section('page_title', 'Famille produits')
@section('nav_families', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">Catalogue</p>
            <h2>Famille produits</h2>
            <p>Photo principale + plusieurs mesures (titre, mesure, prix/U, photo).</p>
        </div>
        <div class="products-admin-actions">
            <button type="button" class="settings-validate" id="openFamilyModal">Ajouter</button>
            <a href="{{ route('admin.dashboard') }}" class="settings-cancel">Fermer</a>
        </div>
    </div>

    @if (session('success'))
        <p class="settings-flash">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="settings-flash settings-flash-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="products-table-wrap">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Mesures</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($families as $family)
                    <tr>
                        <td data-label="Photo">
                            <img class="products-table-thumb" src="{{ $family->photoUrl() }}" alt="{{ $family->titre }}">
                        </td>
                        <td data-label="Titre">{{ $family->titre }}</td>
                        <td data-label="Mesures">{{ $family->items_count }}</td>
                        <td data-label="Statut">{{ $family->statut === 'actif' ? 'Actif' : 'Inactif' }}</td>
                        <td data-label="Actions">
                            <div class="products-actions">
                                <form action="{{ route('admin.families.destroy', $family) }}" method="post" onsubmit="return confirm('Supprimer cette famille ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="products-action-btn is-danger" title="Supprimer" aria-label="Supprimer">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="products-empty">Aucune famille. Cliquez sur <strong>Ajouter</strong>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="product-modal" id="familyModal" @if(!($openCreate || $errors->any())) hidden @endif>
    <div class="product-modal-backdrop" data-close-family-modal></div>
    <div class="product-modal-dialog family-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="familyModalTitle">
        <header class="product-modal-head">
            <div>
                <p class="settings-kicker">Nouvelle famille</p>
                <h3 id="familyModalTitle">Ajouter une famille</h3>
            </div>
            <button type="button" class="settings-close-link" data-close-family-modal>Fermer</button>
        </header>

        <form class="product-form" action="{{ route('admin.families.store') }}" method="post" enctype="multipart/form-data" id="familyForm">
            @csrf

            <div class="product-form-grid">
                <div class="settings-field">
                    <label for="family_titre">Titre famille</label>
                    <input type="text" id="family_titre" name="titre" value="{{ old('titre') }}" required maxlength="160" placeholder="Ex. Miel de lavande">
                </div>
                <div class="settings-field">
                    <label for="family_statut">Statut</label>
                    <select id="family_statut" name="statut">
                        <option value="actif" @selected(old('statut', 'actif') === 'actif')>Actif</option>
                        <option value="inactif" @selected(old('statut') === 'inactif')>Inactif</option>
                    </select>
                </div>
                <div class="settings-field product-form-span">
                    <label for="family_description">Description</label>
                    <textarea id="family_description" name="description" rows="2" maxlength="2000">{{ old('description') }}</textarea>
                </div>
                <div class="settings-field product-form-span">
                    <label for="family_photo">Photo de produit</label>
                    <div class="product-photo-row">
                        <div class="product-photo-preview">
                            <img src="{{ asset('images/products/miel.jpg') }}" alt="" id="familyPhotoPreview">
                        </div>
                        <label class="settings-file-btn">
                            <input type="file" id="family_photo" name="photo" accept="image/*">
                            Choisir une photo
                        </label>
                    </div>
                </div>
            </div>

            <div class="family-items-head">
                <h4>Produits / mesures</h4>
                <button type="button" class="settings-file-btn" id="addFamilyItem">+ Ajouter une ligne</button>
            </div>

            <div id="familyItems" class="family-items"></div>

            <div class="settings-actions">
                <button type="submit" class="settings-validate">Valider</button>
                <button type="button" class="settings-cancel" data-close-family-modal>Fermer</button>
            </div>
        </form>
    </div>
</div>

<template id="familyItemTemplate">
    <div class="family-item-row">
        <div class="settings-field">
            <label>Titre</label>
            <input type="text" name="items[__I__][titre]" required maxlength="160" placeholder="Titre">
        </div>
        <div class="settings-field">
            <label>Mesure</label>
            <input type="text" name="items[__I__][mesure]" required maxlength="80" placeholder="Ex. 500 g">
        </div>
        <div class="settings-field">
            <label>Prix/U</label>
            <input type="number" name="items[__I__][prix_u]" required min="0" step="0.01" value="0">
        </div>
        <div class="settings-field">
            <label>Photo</label>
            <label class="settings-file-btn settings-file-btn-wide">
                <input type="file" name="items[__I__][photo]" accept="image/*">
                Photo
            </label>
        </div>
        <button type="button" class="products-action-btn is-danger family-item-remove" title="Retirer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18"/><path d="M19 6l-1 14H6L5 6"/></svg>
        </button>
    </div>
</template>
@endsection

@push('scripts')
<script>
    (() => {
        const modal = document.getElementById('familyModal');
        const openBtn = document.getElementById('openFamilyModal');
        const itemsBox = document.getElementById('familyItems');
        const tpl = document.getElementById('familyItemTemplate');
        const addBtn = document.getElementById('addFamilyItem');
        const familyPhoto = document.getElementById('family_photo');
        const preview = document.getElementById('familyPhotoPreview');
        let index = 0;

        const addRow = () => {
            if (!tpl || !itemsBox) return;
            const html = tpl.innerHTML.replaceAll('__I__', String(index++));
            const wrap = document.createElement('div');
            wrap.innerHTML = html.trim();
            const row = wrap.firstElementChild;
            row?.querySelector('.family-item-remove')?.addEventListener('click', () => row.remove());
            itemsBox.appendChild(row);
        };

        const open = () => {
            if (!modal) return;
            if (itemsBox && itemsBox.children.length === 0) addRow();
            modal.hidden = false;
            document.body.classList.add('product-modal-open');
        };
        const close = () => {
            if (!modal) return;
            modal.hidden = true;
            document.body.classList.remove('product-modal-open');
        };

        openBtn?.addEventListener('click', open);
        addBtn?.addEventListener('click', addRow);
        modal?.querySelectorAll('[data-close-family-modal]').forEach((el) => el.addEventListener('click', close));
        familyPhoto?.addEventListener('change', () => {
            const file = familyPhoto.files?.[0];
            if (file && preview) preview.src = URL.createObjectURL(file);
        });

        @if ($openCreate || $errors->any())
            open();
        @endif
    })();
</script>
@endpush
