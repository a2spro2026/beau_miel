<div class="admin-modal" id="adminModal" hidden>
    <div class="admin-modal-backdrop" data-admin-close></div>

    <div class="admin-panel" role="dialog" aria-modal="true" aria-labelledby="adminPanelTitle">
        <div class="admin-panel-glow" aria-hidden="true"></div>

        <header class="admin-panel-head">
            <div class="admin-panel-brand">
                <img src="{{ asset('images/logo.svg') }}" alt="" width="44" height="44">
                <div>
                    <p class="admin-panel-kicker">Espace sécurisé</p>
                    <h2 id="adminPanelTitle">Administration</h2>
                </div>
            </div>
            <button type="button" class="admin-close" data-admin-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </header>

        <form class="admin-form" id="adminLoginForm" action="{{ route('admin.login') }}" method="post">
            @csrf
            <fieldset class="admin-statuts">
                <legend>Statut</legend>
                <div class="admin-statut-grid" role="radiogroup" aria-label="Statut">
                    <label class="admin-statut">
                        <input type="radio" name="statut" value="manager" {{ old('statut', 'manager') === 'manager' ? 'checked' : '' }}>
                        <span class="admin-statut-card">
                            <span class="admin-statut-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3 4 7v5c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V7l-8-4Z"/><path d="m9 12 2 2 4-4"/></svg>
                            </span>
                            <span class="admin-statut-name">Manager</span>
                        </span>
                    </label>
                    <label class="admin-statut">
                        <input type="radio" name="statut" value="commercial" {{ old('statut') === 'commercial' ? 'checked' : '' }}>
                        <span class="admin-statut-card">
                            <span class="admin-statut-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </span>
                            <span class="admin-statut-name">Commercial</span>
                        </span>
                    </label>
                    <label class="admin-statut">
                        <input type="radio" name="statut" value="facturation" {{ old('statut') === 'facturation' ? 'checked' : '' }}>
                        <span class="admin-statut-card">
                            <span class="admin-statut-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/><path d="M14 3v6h6M9 13h6M9 17h6"/></svg>
                            </span>
                            <span class="admin-statut-name">Facturation</span>
                        </span>
                    </label>
                </div>
            </fieldset>

            @error('login')
                <p class="admin-form-error">{{ $message }}</p>
            @enderror

            <div class="admin-field">
                <label for="adminLogin">Login</label>
                <div class="admin-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M4 6h16v12H4V6Z"/><path d="m4 7 8 6 8-6"/></svg>
                    <input
                        type="email"
                        id="adminLogin"
                        name="login"
                        autocomplete="username"
                        value="{{ old('login', 'admin@beaumiel.com') }}"
                        required
                    >
                </div>
            </div>

            <div class="admin-field">
                <label for="adminPassword">Mot de passe</label>
                <div class="admin-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                    <input
                        type="password"
                        id="adminPassword"
                        name="password"
                        autocomplete="current-password"
                        value="password"
                        required
                    >
                    <button type="button" class="admin-toggle-pass" id="adminTogglePass" aria-label="Afficher le mot de passe">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="admin-submit">
                Se connecter
                <span aria-hidden="true">→</span>
            </button>
        </form>
    </div>
</div>
