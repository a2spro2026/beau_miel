@extends('layouts.admin')

@section('title', 'Produits E-Boutique — BEAUMIEL')
@section('page_title', 'Produits')
@section('nav_eboutique', 'is-open')
@section('nav_eboutique_products', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">E-Boutique</p>
            <h2>Produits</h2>
            <p>Catalogue produits disponible pour les E-Boutiques partenaires.</p>
        </div>
    </div>

    <div class="products-table-wrap">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Réf</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Prix vente</th>
                    <th>Stock</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td data-label="Réf">{{ $product->ref }}</td>
                        <td data-label="Titre">{{ $product->titre }}</td>
                        <td data-label="Catégorie">{{ $product->categoryLabel() }}</td>
                        <td data-label="Prix">{{ number_format((float) $product->prix_vente, 2, '.', '') }}</td>
                        <td data-label="Stock">{{ $product->qte }}</td>
                        <td data-label="Statut">{{ $product->statutLabel() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="products-empty">Aucun produit actif.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
