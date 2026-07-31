@extends('layouts.admin')

@section('title', 'Tableau de bord — BEAUMIEL')
@section('page_title', 'Tableau de bord')
@section('nav_dashboard', 'is-active')

@section('content')
<section class="admin-welcome">
    <div>
        <p class="admin-welcome-kicker">Bienvenue</p>
        <h2>Bonjour, {{ $admin['label'] }}</h2>
        <p class="admin-welcome-text">
            Gérez vos produits, commandes et équipes depuis cet espace sécurisé BEAUMIEL.
        </p>
    </div>
    <div class="admin-welcome-badge">{{ $admin['label'] }}</div>
</section>

<section class="admin-stats" aria-label="Indicateurs">
    <article class="admin-stat-card">
        <span class="admin-stat-label">Commandes du jour</span>
        <strong>24</strong>
        <span class="admin-stat-hint">+12% vs hier</span>
    </article>
    <article class="admin-stat-card">
        <span class="admin-stat-label">Produits actifs</span>
        <strong>86</strong>
        <span class="admin-stat-hint">Miel • Fruits secs • Dattes</span>
    </article>
    <article class="admin-stat-card">
        <span class="admin-stat-label">Partenaires</span>
        <strong>18</strong>
        <span class="admin-stat-hint">Réseau commercial</span>
    </article>
    <article class="admin-stat-card">
        <span class="admin-stat-label">CA du mois</span>
        <strong>42,8 k</strong>
        <span class="admin-stat-hint">Objectif 50 k</span>
    </article>
</section>

<section class="admin-panels">
    <article class="admin-panel-card">
        <header>
            <h3>Activité récente</h3>
            <span>Aujourd'hui</span>
        </header>
        <ul class="admin-activity">
            <li>
                <span class="dot"></span>
                <div>
                    <strong>Nouvelle commande #BM-1042</strong>
                    <p>3 pots de miel + dattes Medjool</p>
                </div>
                <time>10:24</time>
            </li>
            <li>
                <span class="dot"></span>
                <div>
                    <strong>Partenaire validé</strong>
                    <p>Maison Nature — Lyon</p>
                </div>
                <time>09:12</time>
            </li>
            <li>
                <span class="dot"></span>
                <div>
                    <strong>Stock mis à jour</strong>
                    <p>Fruits secs — amandes 5 kg</p>
                </div>
                <time>08:45</time>
            </li>
        </ul>
    </article>

    <article class="admin-panel-card">
        <header>
            <h3>Raccourcis</h3>
            <span>Actions rapides</span>
        </header>
        <div class="admin-shortcuts">
            <a href="{{ route('admin.products') }}">Ajouter un produit</a>
            <a href="#commandes">Voir les commandes</a>
            <a href="#facturation">Créer une facture</a>
            <a href="#partenaires">Gérer les partenaires</a>
        </div>
    </article>
</section>
@endsection
