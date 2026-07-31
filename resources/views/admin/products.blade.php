@extends('layouts.admin')

@section('title', 'Produits — BEAUMIEL')
@section('page_title', 'Produits')
@section('nav_products', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">Catalogue</p>
            <h2>Gestion des produits</h2>
            <p>Références, catégories, partenaires, prix et stocks.</p>
        </div>
        <div class="products-admin-actions">
            <button type="button" class="settings-validate" id="openProductModal">Ajouter</button>
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
                    <th>Réf</th>
                    <th>Catégorie</th>
                    <th>Partenaire</th>
                    <th>Prix Achat</th>
                    <th>Prix Ventes</th>
                    <th>Qte En Stock</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td data-label="Photo">
                            <img class="products-table-thumb" src="{{ $product->photoUrl() }}" alt="{{ $product->titre }}">
                        </td>
                        <td data-label="Réf">{{ $product->ref }}</td>
                        <td data-label="Catégorie">{{ $product->categoryLabel() }}</td>
                        <td data-label="Partenaire">{{ $product->partenaire ?: '—' }}</td>
                        <td data-label="Prix Achat">{{ number_format((float) $product->prix_achat, 2, ',', ' ') }}</td>
                        <td data-label="Prix Ventes">{{ number_format((float) $product->prix_vente, 2, ',', ' ') }}</td>
                        <td data-label="Qte En Stock">{{ $product->qte }}</td>
                        <td data-label="Statut">
                            <form action="{{ route('admin.products.status', $product) }}" method="post" class="products-status-form">
                                @csrf
                                <select name="statut" onchange="this.form.submit()" class="products-status-select {{ $product->statut === 'actif' ? 'is-actif' : 'is-inactif' }}">
                                    <option value="actif" @selected($product->statut === 'actif')>Actif</option>
                                    <option value="inactif" @selected($product->statut === 'inactif')>Inactif</option>
                                </select>
                            </form>
                        </td>
                        <td data-label="Actions">
                            <div class="products-actions">
                                <button
                                    type="button"
                                    class="products-action-btn"
                                    title="Voir"
                                    aria-label="Voir {{ $product->titre }}"
                                    data-action="view"
                                    data-product="{{ e(json_encode($product->adminPayload(), JSON_UNESCAPED_UNICODE)) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button
                                    type="button"
                                    class="products-action-btn"
                                    title="Modifier"
                                    aria-label="Modifier {{ $product->titre }}"
                                    data-action="edit"
                                    data-product="{{ e(json_encode($product->adminPayload(), JSON_UNESCAPED_UNICODE)) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z"/></svg>
                                </button>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="post" onsubmit="return confirm('Supprimer le produit {{ $product->ref }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="products-action-btn is-danger" title="Supprimer" aria-label="Supprimer {{ $product->titre }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="products-empty">Aucun produit. Cliquez sur <strong>Ajouter</strong> pour en créer un.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Modal voir --}}
<div class="product-modal" id="productViewModal" hidden>
    <div class="product-modal-backdrop" data-close-view-modal></div>
    <div class="product-modal-dialog product-view-dialog" role="dialog" aria-modal="true" aria-labelledby="productViewTitle">
        <header class="product-modal-head">
            <div>
                <p class="settings-kicker">Fiche produit</p>
                <h3 id="productViewTitle">Détail</h3>
            </div>
            <button type="button" class="settings-close-link" data-close-view-modal>Fermer</button>
        </header>
        <div class="product-view-body">
            <img src="" alt="" id="viewPhoto" class="product-view-photo">
            <dl class="product-view-meta">
                <div><dt>Réf</dt><dd id="viewRef">—</dd></div>
                <div><dt>Titre</dt><dd id="viewTitre">—</dd></div>
                <div><dt>Désignation</dt><dd id="viewDesignation">—</dd></div>
                <div class="product-view-span"><dt>Description</dt><dd id="viewDescription">—</dd></div>
                <div><dt>Catégorie</dt><dd id="viewCategorie">—</dd></div>
                <div><dt>Partenaire</dt><dd id="viewPartenaire">—</dd></div>
                <div><dt>Prix/A</dt><dd id="viewPrixA">—</dd></div>
                <div><dt>Prix/V</dt><dd id="viewPrixV">—</dd></div>
                <div><dt>Qte</dt><dd id="viewQte">—</dd></div>
                <div><dt>Statut</dt><dd id="viewStatut">—</dd></div>
                <div><dt>Stock</dt><dd id="viewStock">—</dd></div>
            </dl>
        </div>
        <div class="settings-actions">
            <button type="button" class="settings-cancel" data-close-view-modal>Fermer</button>
        </div>
    </div>
</div>

{{-- Modal créer / modifier --}}
<div class="product-modal" id="productModal" @if(!($openCreate || ($errors->any() && !old('_method')))) hidden @endif>
    <div class="product-modal-backdrop" data-close-product-modal></div>
    <div class="product-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="productModalTitle">
        <header class="product-modal-head">
            <div>
                <p class="settings-kicker" id="productModalKicker">Nouveau produit</p>
                <h3 id="productModalTitle">Ajouter un produit</h3>
            </div>
            <button type="button" class="settings-close-link" data-close-product-modal>Fermer</button>
        </header>

        <form class="product-form" id="productForm" action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="productMethod" value="POST" disabled>

            <div class="product-form-grid">
                <div class="settings-field">
                    <label for="ref">Réf</label>
                    <input type="text" id="ref" value="{{ $nextRef }}" readonly>
                </div>
                <div class="settings-field">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required maxlength="120" placeholder="Ex. Miel de lavande">
                </div>
                <div class="settings-field">
                    <label for="designation">Désignation</label>
                    <input type="text" id="designation" name="designation" value="{{ old('designation') }}" maxlength="160" placeholder="Désignation courte">
                </div>
                <div class="settings-field product-form-span">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" maxlength="2000" placeholder="Description affichée sur le site">{{ old('description') }}</textarea>
                </div>
                <div class="settings-field">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie" required>
                        @foreach ($categories as $value => $label)
                            <option value="{{ $value }}" @selected(old('categorie') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="settings-field">
                    <label for="partenaire">Partenaire</label>
                    <input type="text" id="partenaire" name="partenaire" value="{{ old('partenaire') }}" maxlength="120" placeholder="Nom du partenaire">
                </div>
                <div class="settings-field">
                    <label for="prix_achat">Prix/A</label>
                    <input type="number" id="prix_achat" name="prix_achat" value="{{ old('prix_achat', '0') }}" min="0" step="0.01" required>
                </div>
                <div class="settings-field">
                    <label for="prix_vente">Prix/V</label>
                    <input type="number" id="prix_vente" name="prix_vente" value="{{ old('prix_vente', '0') }}" min="0" step="0.01" required>
                </div>
                <div class="settings-field">
                    <label for="qte">Qte</label>
                    <input type="number" id="qte" name="qte" value="{{ old('qte', '0') }}" min="0" step="1" required>
                </div>
                <div class="settings-field">
                    <label for="statut">Statut</label>
                    <select id="statut" name="statut">
                        <option value="actif" @selected(old('statut', 'actif') === 'actif')>Actif</option>
                        <option value="inactif" @selected(old('statut') === 'inactif')>Inactif</option>
                    </select>
                </div>
                <div class="settings-field product-form-span">
                    <label for="photo">Photo</label>
                    <div class="product-photo-row">
                        <div class="product-photo-preview">
                            <img src="{{ asset('images/products/miel.jpg') }}" alt="" id="productPhotoPreview">
                        </div>
                        <label class="settings-file-btn">
                            <input type="file" id="photo" name="photo" accept="image/*">
                            Choisir une photo
                        </label>
                    </div>
                </div>
            </div>

            <div class="settings-actions">
                <button type="submit" class="settings-validate">Valider</button>
                <button type="button" class="settings-cancel" data-close-product-modal>Fermer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const modal = document.getElementById('productModal');
        const viewModal = document.getElementById('productViewModal');
        const openBtn = document.getElementById('openProductModal');
        const preview = document.getElementById('productPhotoPreview');
        const photo = document.getElementById('photo');
        const form = document.getElementById('productForm');
        const methodInput = document.getElementById('productMethod');
        const nextRef = @json($nextRef);
        const defaultPhoto = @json(asset('images/products/miel.jpg'));

        const setText = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '—';
        };

        const openCreate = () => {
            if (!modal || !form) return;
            form.action = @json(route('admin.products.store'));
            if (methodInput) {
                methodInput.value = 'POST';
                methodInput.disabled = true;
            }
            document.getElementById('productModalKicker').textContent = 'Nouveau produit';
            document.getElementById('productModalTitle').textContent = 'Ajouter un produit';
            form.reset();
            document.getElementById('ref').value = nextRef;
            document.getElementById('statut').value = 'actif';
            if (preview) preview.src = defaultPhoto;
            modal.hidden = false;
            document.body.classList.add('product-modal-open');
        };

        const openEdit = (btn) => {
            const data = JSON.parse(btn.getAttribute('data-product') || '{}');
            if (!modal || !form) return;
            form.action = data.update_url || btn.getAttribute('data-update-url');
            if (methodInput) {
                methodInput.disabled = false;
                methodInput.value = 'PUT';
            }
            document.getElementById('productModalKicker').textContent = 'Modification';
            document.getElementById('productModalTitle').textContent = 'Modifier le produit';
            document.getElementById('ref').value = data.ref || '';
            document.getElementById('titre').value = data.titre || '';
            document.getElementById('designation').value = data.designation || '';
            document.getElementById('description').value = data.description || '';
            document.getElementById('categorie').value = data.categorie_value || 'miel';
            document.getElementById('partenaire').value = data.partenaire || '';
            document.getElementById('prix_achat').value = data.prix_achat || '0';
            document.getElementById('prix_vente').value = data.prix_vente || '0';
            document.getElementById('qte').value = data.qte ?? 0;
            document.getElementById('statut').value = data.statut_value || 'actif';
            if (preview) preview.src = data.photo || defaultPhoto;
            if (photo) photo.value = '';
            modal.hidden = false;
            document.body.classList.add('product-modal-open');
        };

        const openView = (btn) => {
            const data = JSON.parse(btn.getAttribute('data-product') || '{}');
            if (!viewModal) return;
            document.getElementById('productViewTitle').textContent = data.titre || 'Détail';
            const img = document.getElementById('viewPhoto');
            if (img) {
                img.src = data.photo || defaultPhoto;
                img.alt = data.titre || '';
            }
            setText('viewRef', data.ref);
            setText('viewTitre', data.titre);
            setText('viewDesignation', data.designation);
            setText('viewDescription', data.description);
            setText('viewCategorie', data.categorie);
            setText('viewPartenaire', data.partenaire);
            setText('viewPrixA', data.prix_achat || '—');
            setText('viewPrixV', data.prix_vente || '—');
            setText('viewQte', String(data.qte ?? '—'));
            setText('viewStatut', data.statut);
            setText('viewStock', data.stock);
            viewModal.hidden = false;
            document.body.classList.add('product-modal-open');
        };

        const closeCreate = () => {
            if (!modal) return;
            modal.hidden = true;
            if (viewModal?.hidden !== false) document.body.classList.remove('product-modal-open');
        };

        const closeView = () => {
            if (!viewModal) return;
            viewModal.hidden = true;
            if (modal?.hidden !== false) document.body.classList.remove('product-modal-open');
        };

        openBtn?.addEventListener('click', openCreate);
        modal?.querySelectorAll('[data-close-product-modal]').forEach((el) => el.addEventListener('click', closeCreate));
        viewModal?.querySelectorAll('[data-close-view-modal]').forEach((el) => el.addEventListener('click', closeView));

        document.querySelectorAll('[data-action="view"]').forEach((btn) => {
            btn.addEventListener('click', () => openView(btn));
        });
        document.querySelectorAll('[data-action="edit"]').forEach((btn) => {
            btn.addEventListener('click', () => openEdit(btn));
        });

        photo?.addEventListener('change', () => {
            const file = photo.files?.[0];
            if (file && preview) preview.src = URL.createObjectURL(file);
        });

        @if ($openCreate || ($errors->any() && old('_method') !== 'PUT'))
            openCreate();
        @endif
    })();
</script>
@endpush
