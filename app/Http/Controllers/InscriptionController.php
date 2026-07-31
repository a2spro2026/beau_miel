<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\InscriptionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InscriptionController extends Controller
{
    private function guard(Request $request): ?RedirectResponse
    {
        if (! $request->session()->has('admin')) {
            return redirect('/')->with('admin_open', true);
        }

        return null;
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom_complet' => 'required|string|max:160',
            'telephone' => 'required|string|max:40',
            'email' => 'required|email|max:160',
            'ville' => 'required|string|max:120',
            'activite' => 'required|string|max:160',
        ]);

        InscriptionRequest::create([
            'date_demande' => now()->toDateString(),
            'nom_complet' => $data['nom_complet'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'ville' => $data['ville'],
            'activite' => $data['activite'],
            'statut' => 'en_attente',
        ]);

        return redirect('/')
            ->with('inscription_sent', true)
            ->with('inscription_open', true);
    }

    public function index(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.inscriptions', [
            'admin' => $request->session()->get('admin'),
            'inscriptions' => InscriptionRequest::query()->orderByDesc('id')->get(),
            'pendingCount' => InscriptionRequest::pending()->count(),
        ]);
    }

    public function validateRequest(Request $request, InscriptionRequest $inscription): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        if ($inscription->statut === 'valide' && $inscription->boutique) {
            return redirect()
                ->route('admin.inscriptions')
                ->with('success', 'Cette demande est déjà validée.');
        }

        DB::transaction(function () use ($inscription) {
            $inscription->update([
                'statut' => 'valide',
                'traite_at' => now(),
            ]);

            Boutique::query()->updateOrCreate(
                ['inscription_request_id' => $inscription->id],
                [
                    'nom' => $inscription->nom_complet,
                    'email' => $inscription->email,
                    'telephone' => $inscription->telephone,
                    'ville' => $inscription->ville,
                    'activite' => $inscription->activite,
                    'login' => $inscription->email,
                    'mot_de_passe' => Boutique::generatePassword(),
                    'statut' => 'actif',
                ]
            );
        });

        return redirect()
            ->route('admin.inscriptions')
            ->with('success', 'Demande validée — E-Boutique créée.');
    }

    public function postpone(Request $request, InscriptionRequest $inscription): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $inscription->update([
            'statut' => 'reporte',
            'traite_at' => now(),
        ]);

        return redirect()
            ->route('admin.inscriptions')
            ->with('success', 'Demande reportée.');
    }

    public function refuse(Request $request, InscriptionRequest $inscription): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $inscription->update([
            'statut' => 'refuse',
            'traite_at' => now(),
        ]);

        return redirect()
            ->route('admin.inscriptions')
            ->with('success', 'Demande refusée.');
    }
}
