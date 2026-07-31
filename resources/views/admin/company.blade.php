@extends('layouts.admin')

@section('title', 'Fiche Société — BEAUMIEL')
@section('page_title', 'Fiche Société')
@section('nav_params', 'is-open')
@section('nav_company', 'is-active')

@section('content')
<section class="settings-page">
    <div class="settings-intro">
        <p class="admin-welcome-kicker">Paramètres</p>
        <h2>Fiche Société</h2>
        <p>Informations de contact affichées sur le site (WhatsApp sur les produits).</p>
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

    <div class="settings-modal-card">
        <header class="settings-modal-head">
            <div>
                <p class="settings-kicker">Identité</p>
                <h3>Coordonnées de la société</h3>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="settings-close-link">Fermer</a>
        </header>

        <form class="settings-form" action="{{ route('admin.company.update') }}" method="post">
            @csrf

            <div class="product-form-grid">
                <div class="settings-field">
                    <label for="nom_societe">Nom Société</label>
                    <input type="text" id="nom_societe" name="nom_societe" value="{{ old('nom_societe', $company['nom_societe']) }}" maxlength="160" required>
                </div>
                <div class="settings-field">
                    <label for="nom_gerant">Nom Gérant</label>
                    <input type="text" id="nom_gerant" name="nom_gerant" value="{{ old('nom_gerant', $company['nom_gerant']) }}" maxlength="120">
                </div>
                <div class="settings-field">
                    <label for="contact">Contact</label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $company['contact']) }}" maxlength="120" placeholder="Téléphone / e-mail">
                </div>
                <div class="settings-field">
                    <label for="whatsapp_indicatif">Indicatif pays</label>
                    <select id="whatsapp_indicatif" name="whatsapp_indicatif">
                        @php
                            $indicatifs = [
                                '212' => 'Maroc (+212)',
                                '213' => 'Algérie (+213)',
                                '216' => 'Tunisie (+216)',
                                '33' => 'France (+33)',
                                '1' => 'USA / Canada (+1)',
                            ];
                            $currentIndicatif = old('whatsapp_indicatif', $company['whatsapp_indicatif'] ?? '212');
                        @endphp
                        @foreach ($indicatifs as $code => $label)
                            <option value="{{ $code }}" @selected((string) $currentIndicatif === (string) $code)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="settings-field">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $company['whatsapp']) }}" maxlength="40" placeholder="Ex. 0772 49 45 44 ou +213...">
                    <p class="settings-hint">Si le numéro commence par 0, l’indicatif pays est ajouté automatiquement.</p>
                </div>
                <div class="settings-field product-form-span">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" value="{{ old('ville', $company['ville']) }}" maxlength="120">
                </div>
                <div class="settings-field product-form-span">
                    <label for="frais_livraison">Frais de livraison</label>
                    <input type="number" id="frais_livraison" name="frais_livraison" value="{{ old('frais_livraison', $company['frais_livraison'] ?? 30) }}" min="0" step="0.01">
                </div>
            </div>

            <div class="settings-actions">
                <button type="submit" class="settings-validate">Valider</button>
                <a href="{{ route('admin.dashboard') }}" class="settings-cancel">Fermer</a>
            </div>
        </form>
    </div>
</section>
@endsection
