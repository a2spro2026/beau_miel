@extends('layouts.admin')

@section('title', 'Fiche Partenaire — BEAUMIEL')
@section('page_title', 'Fiche Partenaire')
@section('nav_eboutique', 'is-open')
@section('nav_eboutique_partners', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">E-Boutique</p>
            <h2>Fiche Partenaire</h2>
            <p>Partenaires validés ayant une E-Boutique.</p>
        </div>
        <div class="products-admin-actions">
            <a href="{{ route('admin.dashboard') }}" class="settings-cancel">Fermer</a>
        </div>
    </div>

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
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Ville</th>
                    <th>Activité</th>
                    <th>Login</th>
                    <th>Mot de passe</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($boutiques as $boutique)
                    <tr>
                        <td data-label="Nom">{{ $boutique->nom }}</td>
                        <td data-label="Email">{{ $boutique->email }}</td>
                        <td data-label="Téléphone">{{ $boutique->telephone }}</td>
                        <td data-label="Ville">{{ $boutique->ville }}</td>
                        <td data-label="Activité">{{ $boutique->activite }}</td>
                        <td data-label="Login">{{ $boutique->login ?: '—' }}</td>
                        <td data-label="Mot de passe">{{ $boutique->mot_de_passe ?: '—' }}</td>
                        <td data-label="Statut">{{ $boutique->statut === 'actif' ? 'Actif' : 'Inactif' }}</td>
                        <td data-label="Actions">
                            <div class="products-actions">
                                <button
                                    type="button"
                                    class="products-action-btn"
                                    title="Voir"
                                    aria-label="Voir {{ $boutique->nom }}"
                                    data-partner-view="{{ e(json_encode($boutique->adminPayload(), JSON_UNESCAPED_UNICODE)) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button
                                    type="button"
                                    class="products-action-btn"
                                    title="Modifier"
                                    aria-label="Modifier {{ $boutique->nom }}"
                                    data-partner-edit="{{ e(json_encode($boutique->adminPayload(), JSON_UNESCAPED_UNICODE)) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z"/></svg>
                                </button>
                                <form action="{{ route('admin.eboutique.partners.destroy', $boutique) }}" method="post" onsubmit="return confirm('Supprimer le partenaire {{ $boutique->nom }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="products-action-btn is-danger" title="Supprimer" aria-label="Supprimer {{ $boutique->nom }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="products-empty">Aucun partenaire E-Boutique. Validez une demande dans Nouveaux Inscrits.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Voir --}}
<div class="product-modal" id="partnerViewModal" hidden>
    <div class="product-modal-backdrop" data-close-partner-view></div>
    <div class="product-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="partnerViewTitle">
        <header class="product-modal-head">
            <div>
                <p class="settings-kicker">Consultation</p>
                <h3 id="partnerViewTitle">Fiche partenaire</h3>
            </div>
            <button type="button" class="settings-close-link" data-close-partner-view>Fermer</button>
        </header>
        <div class="product-view-grid">
            <div><span>Nom</span><strong id="pvNom">—</strong></div>
            <div><span>Email</span><strong id="pvEmail">—</strong></div>
            <div><span>Téléphone</span><strong id="pvTel">—</strong></div>
            <div><span>Ville</span><strong id="pvVille">—</strong></div>
            <div><span>Activité</span><strong id="pvActivite">—</strong></div>
            <div><span>Login</span><strong id="pvLogin">—</strong></div>
            <div><span>Mot de passe</span><strong id="pvPass">—</strong></div>
            <div><span>Statut</span><strong id="pvStatut">—</strong></div>
        </div>
        <div class="settings-actions">
            <button type="button" class="settings-cancel" data-close-partner-view>Fermer</button>
        </div>
    </div>
</div>

{{-- Modifier --}}
<div class="product-modal" id="partnerEditModal" @if(!$errors->any()) hidden @endif>
    <div class="product-modal-backdrop" data-close-partner-edit></div>
    <div class="product-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="partnerEditTitle">
        <header class="product-modal-head">
            <div>
                <p class="settings-kicker">Modification</p>
                <h3 id="partnerEditTitle">Modifier le partenaire</h3>
            </div>
            <button type="button" class="settings-close-link" data-close-partner-edit>Fermer</button>
        </header>
        <form class="product-form" id="partnerEditForm" method="post" action="">
            @csrf
            @method('PUT')
            <div class="product-form-grid">
                <div class="settings-field">
                    <label for="pe_nom">Nom Complet</label>
                    <input type="text" id="pe_nom" name="nom" required maxlength="160" value="{{ old('nom') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_email">Email</label>
                    <input type="email" id="pe_email" name="email" required maxlength="160" value="{{ old('email') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_tel">Téléphone</label>
                    <input type="text" id="pe_tel" name="telephone" required maxlength="40" value="{{ old('telephone') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_ville">Ville</label>
                    <input type="text" id="pe_ville" name="ville" required maxlength="120" value="{{ old('ville') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_activite">Activité</label>
                    <input type="text" id="pe_activite" name="activite" required maxlength="160" value="{{ old('activite') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_login">Login</label>
                    <input type="text" id="pe_login" name="login" required maxlength="120" value="{{ old('login') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_pass">Mot de passe</label>
                    <input type="text" id="pe_pass" name="mot_de_passe" required maxlength="120" value="{{ old('mot_de_passe') }}">
                </div>
                <div class="settings-field">
                    <label for="pe_statut">Statut</label>
                    <select id="pe_statut" name="statut">
                        <option value="actif" @selected(old('statut', 'actif') === 'actif')>Actif</option>
                        <option value="inactif" @selected(old('statut') === 'inactif')>Inactif</option>
                    </select>
                </div>
            </div>
            <div class="settings-actions">
                <button type="submit" class="settings-validate">Valider</button>
                <button type="button" class="settings-cancel" data-close-partner-edit>Fermer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const viewModal = document.getElementById('partnerViewModal');
        const editModal = document.getElementById('partnerEditModal');
        const editForm = document.getElementById('partnerEditForm');
        const setText = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '—';
        };

        const openView = (data) => {
            setText('pvNom', data.nom);
            setText('pvEmail', data.email);
            setText('pvTel', data.telephone);
            setText('pvVille', data.ville);
            setText('pvActivite', data.activite);
            setText('pvLogin', data.login);
            setText('pvPass', data.mot_de_passe);
            setText('pvStatut', data.statut_label);
            document.getElementById('partnerViewTitle').textContent = data.nom || 'Fiche partenaire';
            if (viewModal) {
                viewModal.hidden = false;
                document.body.classList.add('product-modal-open');
            }
        };

        const openEdit = (data) => {
            if (!editForm) return;
            editForm.action = data.update_url || '';
            document.getElementById('pe_nom').value = data.nom || '';
            document.getElementById('pe_email').value = data.email || '';
            document.getElementById('pe_tel').value = data.telephone || '';
            document.getElementById('pe_ville').value = data.ville || '';
            document.getElementById('pe_activite').value = data.activite || '';
            document.getElementById('pe_login').value = data.login || '';
            document.getElementById('pe_pass').value = data.mot_de_passe || '';
            document.getElementById('pe_statut').value = data.statut || 'actif';
            document.getElementById('partnerEditTitle').textContent = 'Modifier — ' + (data.nom || 'partenaire');
            if (editModal) {
                editModal.hidden = false;
                document.body.classList.add('product-modal-open');
            }
        };

        const closeView = () => {
            if (!viewModal) return;
            viewModal.hidden = true;
            if (editModal?.hidden !== false) document.body.classList.remove('product-modal-open');
        };
        const closeEdit = () => {
            if (!editModal) return;
            editModal.hidden = true;
            if (viewModal?.hidden !== false) document.body.classList.remove('product-modal-open');
        };

        document.querySelectorAll('[data-partner-view]').forEach((btn) => {
            btn.addEventListener('click', () => {
                try { openView(JSON.parse(btn.getAttribute('data-partner-view'))); } catch (e) {}
            });
        });
        document.querySelectorAll('[data-partner-edit]').forEach((btn) => {
            btn.addEventListener('click', () => {
                try { openEdit(JSON.parse(btn.getAttribute('data-partner-edit'))); } catch (e) {}
            });
        });
        viewModal?.querySelectorAll('[data-close-partner-view]').forEach((el) => el.addEventListener('click', closeView));
        editModal?.querySelectorAll('[data-close-partner-edit]').forEach((el) => el.addEventListener('click', closeEdit));

        @if ($errors->any())
            if (editModal) {
                editModal.hidden = false;
                document.body.classList.add('product-modal-open');
            }
        @endif
    })();
</script>
@endpush
