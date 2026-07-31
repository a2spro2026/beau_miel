@extends('layouts.admin')

@section('title', 'Catégorie — BEAUMIEL')
@section('page_title', 'Catégorie')
@section('nav_params', 'is-open')
@section('nav_category', 'is-active')

@section('content')
<section class="settings-page">
    <div class="settings-intro">
        <p class="admin-welcome-kicker">Paramètres</p>
        <h2>Catégories produits</h2>
        <p>Les catégories utilisées pour le catalogue BEAUMIEL.</p>
    </div>

    <div class="categories-grid">
        @foreach ($categories as $key => $label)
            <article class="category-card">
                <h3>{{ $label }}</h3>
                <p>{{ $counts[$key] ?? 0 }} produit(s)</p>
            </article>
        @endforeach
    </div>
</section>
@endsection
