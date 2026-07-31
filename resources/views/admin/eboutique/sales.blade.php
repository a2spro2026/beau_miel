@extends('layouts.admin')

@section('title', 'Balance Ventes — BEAUMIEL')
@section('page_title', 'Balance Ventes')
@section('nav_eboutique', 'is-open')
@section('nav_eboutique_sales', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">E-Boutique</p>
            <h2>Balance Ventes</h2>
            <p>Suivi des ventes par partenaire E-Boutique.</p>
        </div>
    </div>

    <div class="products-table-wrap">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Partenaire</th>
                    <th>Ville</th>
                    <th>Activité</th>
                    <th>Ventes</th>
                    <th>CA</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($boutiques as $boutique)
                    <tr>
                        <td data-label="Partenaire">{{ $boutique->nom }}</td>
                        <td data-label="Ville">{{ $boutique->ville }}</td>
                        <td data-label="Activité">{{ $boutique->activite }}</td>
                        <td data-label="Ventes">0</td>
                        <td data-label="CA">0.00</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="products-empty">Aucune E-Boutique active pour afficher la balance.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
