<div class="inscription-modal" id="inscriptionModal" hidden>
    <div class="inscription-modal-backdrop" data-inscription-close></div>
    <div class="inscription-panel" role="dialog" aria-modal="true" aria-labelledby="inscriptionTitle">
        <header class="inscription-panel-head">
            <div>
                <p class="settings-kicker">Inscription partenaire</p>
                <h3 id="inscriptionTitle">Demande d’inscription</h3>
            </div>
            <button type="button" class="settings-close-link" data-inscription-close>Fermer</button>
        </header>

        @if (session('inscription_sent'))
            <div class="inscription-thanks">
                <div class="inscription-thanks-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 13 4 4L19 7"/></svg>
                </div>
                <p>Nous vous remercions de nous avoir contactés. Votre demande est en cours de traitement. L’un de nos conseillers commerciaux reviendra vers vous dans les plus brefs délais.</p>
                <button type="button" class="settings-validate" data-inscription-close>Fermer</button>
            </div>
        @else
            @if ($errors->has('nom_complet') || $errors->has('telephone') || $errors->has('email') || $errors->has('ville') || $errors->has('activite'))
                <div class="settings-flash settings-flash-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="inscription-form" action="{{ route('inscription.store') }}" method="post">
                @csrf
                <div class="inscription-form-grid">
                    <div class="settings-field">
                        <label for="insc_date">Date</label>
                        <input type="text" id="insc_date" value="{{ now()->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="settings-field">
                        <label for="insc_nom">Nom Complet</label>
                        <input type="text" id="insc_nom" name="nom_complet" value="{{ old('nom_complet') }}" required maxlength="160" placeholder="Votre nom complet">
                    </div>
                    <div class="settings-field">
                        <label for="insc_tel">N° Téléphone</label>
                        <input type="tel" id="insc_tel" name="telephone" value="{{ old('telephone') }}" required maxlength="40" placeholder="Ex. 06 12 34 56 78">
                    </div>
                    <div class="settings-field">
                        <label for="insc_email">Email</label>
                        <input type="email" id="insc_email" name="email" value="{{ old('email') }}" required maxlength="160" placeholder="vous@email.com">
                    </div>
                    <div class="settings-field">
                        <label for="insc_ville">Ville</label>
                        <input type="text" id="insc_ville" name="ville" value="{{ old('ville') }}" required maxlength="120" placeholder="Votre ville">
                    </div>
                    <div class="settings-field">
                        <label for="insc_activite">Activité</label>
                        <input type="text" id="insc_activite" name="activite" value="{{ old('activite') }}" required maxlength="160" placeholder="Ex. Épicerie fine">
                    </div>
                </div>
                <div class="settings-actions">
                    <button type="submit" class="settings-validate">Envoyer</button>
                    <button type="button" class="settings-cancel" data-inscription-close>Fermer</button>
                </div>
            </form>
        @endif
    </div>
</div>
