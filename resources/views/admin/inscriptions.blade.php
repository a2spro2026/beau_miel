@extends('layouts.admin')

@section('title', 'Nouveaux Inscrits — BEAUMIEL')
@section('page_title', 'Nouveaux Inscrits')
@section('nav_eboutique', 'is-open')
@section('nav_inscriptions', 'is-active')

@section('content')
<section class="products-admin">
    <div class="products-admin-head">
        <div>
            <p class="admin-welcome-kicker">Demandes</p>
            <h2>Nouveaux Inscrits</h2>
            <p>Consultez les demandes d’inscription et validez, reportez ou refusez.</p>
        </div>
        <div class="products-admin-actions">
            <a href="{{ route('admin.dashboard') }}" class="settings-cancel">Fermer</a>
        </div>
    </div>

    <div class="products-table-wrap">
        <table class="products-table inscriptions-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nom Complet</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Activité</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inscriptions as $item)
                    <tr class="inscription-row {{ $item->rowClass() }}">
                        <td data-label="Date">{{ $item->date_demande->format('d/m/Y') }}</td>
                        <td data-label="Nom">{{ $item->nom_complet }}</td>
                        <td data-label="Téléphone">{{ $item->telephone }}</td>
                        <td data-label="Email">{{ $item->email }}</td>
                        <td data-label="Ville">{{ $item->ville }}</td>
                        <td data-label="Activité">{{ $item->activite }}</td>
                        <td data-label="Statut">
                            <span class="inscription-badge">{{ $item->statutLabel() }}</span>
                        </td>
                        <td data-label="Actions">
                            <div class="inscription-actions">
                                @if ($item->statut !== 'valide')
                                    <form action="{{ route('admin.inscriptions.validate', $item) }}" method="post">
                                        @csrf
                                        <button type="submit" class="inscription-btn is-ok" title="Valider">Valider</button>
                                    </form>
                                @endif
                                @if ($item->statut !== 'reporte')
                                    <form action="{{ route('admin.inscriptions.postpone', $item) }}" method="post">
                                        @csrf
                                        <button type="submit" class="inscription-btn is-wait" title="Reporté">Reporté</button>
                                    </form>
                                @endif
                                @if ($item->statut !== 'refuse')
                                    <form action="{{ route('admin.inscriptions.refuse', $item) }}" method="post">
                                        @csrf
                                        <button type="submit" class="inscription-btn is-no" title="Refuser">Refuser</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="products-empty">Aucune demande d’inscription pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
