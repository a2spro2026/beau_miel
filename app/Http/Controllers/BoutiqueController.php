<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    private function guard(Request $request): ?RedirectResponse
    {
        if (! $request->session()->has('admin')) {
            return redirect('/')->with('admin_open', true);
        }

        return null;
    }

    public function partners(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.eboutique.partners', [
            'admin' => $request->session()->get('admin'),
            'boutiques' => Boutique::query()->with('inscription')->orderByDesc('id')->get(),
            'openEdit' => $request->boolean('modifier'),
        ]);
    }

    public function updatePartner(Request $request, Boutique $boutique): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'nom' => 'required|string|max:160',
            'email' => 'required|email|max:160',
            'telephone' => 'required|string|max:40',
            'ville' => 'required|string|max:120',
            'activite' => 'required|string|max:160',
            'login' => 'required|string|max:120',
            'mot_de_passe' => 'required|string|max:120',
            'statut' => 'nullable|in:actif,inactif',
        ]);

        $boutique->update([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'ville' => $data['ville'],
            'activite' => $data['activite'],
            'login' => $data['login'],
            'mot_de_passe' => $data['mot_de_passe'],
            'statut' => $data['statut'] ?? $boutique->statut,
        ]);

        return redirect()
            ->route('admin.eboutique.partners')
            ->with('success', 'Fiche partenaire mise à jour.');
    }

    public function destroyPartner(Request $request, Boutique $boutique): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $boutique->delete();

        return redirect()
            ->route('admin.eboutique.partners')
            ->with('success', 'Partenaire supprimé.');
    }

    public function products(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.eboutique.products', [
            'admin' => $request->session()->get('admin'),
            'boutiques' => Boutique::query()->where('statut', 'actif')->orderBy('nom')->get(),
            'products' => Product::query()->active()->orderBy('titre')->get(),
        ]);
    }

    public function sales(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.eboutique.sales', [
            'admin' => $request->session()->get('admin'),
            'boutiques' => Boutique::query()->where('statut', 'actif')->orderBy('nom')->get(),
        ]);
    }
}
