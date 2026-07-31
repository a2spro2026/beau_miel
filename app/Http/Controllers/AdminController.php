<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\CompanyProfile;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    private array $accounts = [
        'manager' => [
            'login' => 'admin@beaumiel.com',
            'password' => 'password',
            'label' => 'Manager',
        ],
        'commercial' => [
            'login' => 'commercial@beaumiel.com',
            'password' => 'password',
            'label' => 'Commercial',
        ],
        'facturation' => [
            'login' => 'facturation@beaumiel.com',
            'password' => 'password',
            'label' => 'Facturation',
        ],
    ];

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'statut' => 'required|in:manager,commercial,facturation',
            'login' => 'required|email',
            'password' => 'required|string',
        ]);

        $account = $this->accounts[$data['statut']];

        if (
            strcasecmp($data['login'], $account['login']) !== 0
            || $data['password'] !== $account['password']
        ) {
            return back()->withErrors([
                'login' => 'Identifiants incorrects pour ce statut.',
            ])->withInput($request->except('password'));
        }

        $request->session()->put('admin', [
            'statut' => $data['statut'],
            'label' => $account['label'],
            'login' => $account['login'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.dashboard', [
            'admin' => $request->session()->get('admin'),
        ]);
    }

    public function products(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.products', [
            'admin' => $request->session()->get('admin'),
            'products' => Product::query()->orderByDesc('id')->get(),
            'categories' => Product::CATEGORIES,
            'nextRef' => Product::nextRef(),
            'openCreate' => $request->boolean('ajouter') || $request->session()->get('open_product_modal'),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'titre' => 'required|string|max:120',
            'designation' => 'nullable|string|max:160',
            'description' => 'nullable|string|max:2000',
            'categorie' => 'required|in:miel,fruits_secs,dattes',
            'partenaire' => 'nullable|string|max:120',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'qte' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:5120',
            'statut' => 'nullable|in:actif,inactif',
        ], [], [
            'titre' => 'titre',
            'prix_achat' => 'prix d’achat',
            'prix_vente' => 'prix de vente',
            'qte' => 'quantité',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        Product::create([
            'ref' => Product::nextRef(),
            'titre' => $data['titre'],
            'designation' => $data['designation'] ?? null,
            'description' => $data['description'] ?? null,
            'categorie' => $data['categorie'],
            'partenaire' => $data['partenaire'] ?? null,
            'prix_achat' => $data['prix_achat'],
            'prix_vente' => $data['prix_vente'],
            'qte' => $data['qte'],
            'photo' => $photoPath,
            'statut' => $data['statut'] ?? 'actif',
        ]);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produit ajouté avec succès.');
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'titre' => 'required|string|max:120',
            'designation' => 'nullable|string|max:160',
            'description' => 'nullable|string|max:2000',
            'categorie' => 'required|in:miel,fruits_secs,dattes',
            'partenaire' => 'nullable|string|max:120',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'qte' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:5120',
            'statut' => 'nullable|in:actif,inactif',
        ], [], [
            'titre' => 'titre',
            'prix_achat' => 'prix d’achat',
            'prix_vente' => 'prix de vente',
            'qte' => 'quantité',
        ]);

        if ($request->hasFile('photo')) {
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->fill([
            'titre' => $data['titre'],
            'designation' => $data['designation'] ?? null,
            'description' => $data['description'] ?? null,
            'categorie' => $data['categorie'],
            'partenaire' => $data['partenaire'] ?? null,
            'prix_achat' => $data['prix_achat'],
            'prix_vente' => $data['prix_vente'],
            'qte' => $data['qte'],
            'statut' => $data['statut'] ?? $product->statut,
        ])->save();

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produit modifié avec succès.');
    }

    public function destroyProduct(Request $request, Product $product): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $product->delete();

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produit supprimé.');
    }

    public function updateProductStatus(Request $request, Product $product): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'statut' => 'required|in:actif,inactif',
        ]);

        $product->update(['statut' => $data['statut']]);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Statut mis à jour.');
    }

    public function commerciaux(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.commerciaux', [
            'admin' => $request->session()->get('admin'),
        ]);
    }

    public function categories(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $counts = [];
        foreach (array_keys(Product::CATEGORIES) as $key) {
            $counts[$key] = Product::query()->where('categorie', $key)->count();
        }

        return view('admin.categories', [
            'admin' => $request->session()->get('admin'),
            'categories' => Product::CATEGORIES,
            'counts' => $counts,
        ]);
    }

    public function company(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.company', [
            'admin' => $request->session()->get('admin'),
            'company' => CompanyProfile::all(),
        ]);
    }

    public function updateCompany(Request $request): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'nom_societe' => 'required|string|max:160',
            'nom_gerant' => 'nullable|string|max:120',
            'contact' => 'nullable|string|max:120',
            'whatsapp' => 'nullable|string|max:40',
            'whatsapp_indicatif' => 'nullable|string|max:5',
            'ville' => 'nullable|string|max:120',
            'frais_livraison' => 'nullable|numeric|min:0',
        ]);

        CompanyProfile::put([
            'nom_societe' => $data['nom_societe'],
            'nom_gerant' => $data['nom_gerant'] ?? '',
            'contact' => $data['contact'] ?? '',
            'whatsapp' => $data['whatsapp'] ?? '',
            'whatsapp_indicatif' => $data['whatsapp_indicatif'] ?? CompanyProfile::DEFAULT_COUNTRY_CODE,
            'ville' => $data['ville'] ?? '',
            'frais_livraison' => $data['frais_livraison'] ?? 30,
        ]);

        return redirect()
            ->route('admin.company')
            ->with('success', 'Fiche société enregistrée.');
    }

    public function settings(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.settings', [
            'admin' => $request->session()->get('admin'),
            'settings' => SiteSettings::all(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'titre' => 'nullable|string|max:120',
            'description' => 'nullable|string|max:255',
            'video_url' => 'nullable|url|max:500',
            'use_url' => 'nullable|boolean',
            'habillage' => 'nullable|image|max:5120',
            'video_file' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:51200',
        ]);

        $settings = SiteSettings::all();
        $settings['titre'] = $data['titre'] ?? $settings['titre'];
        $settings['description'] = $data['description'] ?? $settings['description'];
        $settings['use_url'] = $request->boolean('use_url');

        if ($request->boolean('use_url')) {
            $settings['video_url'] = $data['video_url'] ?? $settings['video_url'];
        } elseif (array_key_exists('video_url', $data) && $data['video_url'] !== null) {
            $settings['video_url'] = $data['video_url'];
        }

        if ($request->hasFile('habillage')) {
            $settings['habillage'] = $request->file('habillage')->store('habillages', 'public');
        }

        if ($request->hasFile('video_file')) {
            $settings['video_file'] = $request->file('video_file')->store('videos', 'public');
            if (! $settings['use_url']) {
                $settings['video_url'] = '';
            }
        }

        SiteSettings::put($settings);

        return redirect()
            ->route('admin.settings')
            ->with('success', 'Paramètres enregistrés avec succès.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin');

        return redirect('/');
    }

    private function guard(Request $request): ?RedirectResponse
    {
        if (! $request->session()->has('admin')) {
            return redirect('/')->with('admin_open', true);
        }

        return null;
    }
}
