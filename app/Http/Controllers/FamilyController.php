<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ProductFamilyItem;
use App\Support\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FamilyController extends Controller
{
    private function guard(Request $request): ?RedirectResponse
    {
        if (! $request->session()->has('admin')) {
            return redirect('/')->with('admin_open', true);
        }

        return null;
    }

    public function index(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        return view('admin.families', [
            'admin' => $request->session()->get('admin'),
            'families' => ProductFamily::query()->withCount('items')->orderByDesc('id')->get(),
            'openCreate' => $request->boolean('ajouter'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $data = $request->validate([
            'titre' => 'required|string|max:160',
            'description' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|max:5120',
            'statut' => 'nullable|in:actif,inactif',
            'items' => 'required|array|min:1',
            'items.*.titre' => 'required|string|max:160',
            'items.*.mesure' => 'required|string|max:80',
            'items.*.prix_u' => 'required|numeric|min:0',
            'items.*.photo' => 'nullable|image|max:5120',
        ]);

        DB::transaction(function () use ($request, $data) {
            $familyPhoto = null;
            if ($request->hasFile('photo')) {
                $familyPhoto = $request->file('photo')->store('families', 'public');
            }

            $family = ProductFamily::create([
                'titre' => $data['titre'],
                'description' => $data['description'] ?? null,
                'photo' => $familyPhoto,
                'statut' => $data['statut'] ?? 'actif',
            ]);

            foreach ($data['items'] as $i => $item) {
                $itemPhoto = null;
                if ($request->hasFile("items.$i.photo")) {
                    $itemPhoto = $request->file("items.$i.photo")->store('families/items', 'public');
                }

                ProductFamilyItem::create([
                    'product_family_id' => $family->id,
                    'titre' => $item['titre'],
                    'mesure' => $item['mesure'],
                    'prix_u' => $item['prix_u'],
                    'photo' => $itemPhoto,
                    'sort_order' => $i,
                ]);
            }
        });

        return redirect()
            ->route('admin.families')
            ->with('success', 'Famille de produits créée.');
    }

    public function destroy(Request $request, ProductFamily $family): RedirectResponse
    {
        if ($redirect = $this->guard($request)) {
            return $redirect;
        }

        $family->delete();

        return redirect()
            ->route('admin.families')
            ->with('success', 'Famille supprimée.');
    }

    public function show(ProductFamily $family): View
    {
        abort_unless($family->statut === 'actif', 404);

        $family->load('items');
        $company = CompanyProfile::all();

        return view('family', [
            'family' => $family,
            'payload' => $family->publicPayload(),
            'company' => $company,
            'fraisLivraison' => (float) ($company['frais_livraison'] ?? 30),
            'whatsappUrl' => CompanyProfile::whatsappUrl($company),
            'whatsappDisplay' => CompanyProfile::whatsappDisplay($company),
        ]);
    }

    public function showProduct(Product $product): View
    {
        abort_unless($product->statut === 'actif', 404);

        $siblings = Product::query()
            ->active()
            ->where('categorie', $product->categorie)
            ->orderBy('titre')
            ->get();

        $company = CompanyProfile::all();
        $items = $siblings->map(fn (Product $p) => [
            'id' => $p->id,
            'titre' => $p->titre,
            'mesure' => $p->designation ?: $p->categoryLabel(),
            'prix_u' => (float) $p->prix_vente,
            'photo' => $p->photoUrl(),
        ])->values()->all();

        return view('shop-category', [
            'product' => $product,
            'siblings' => $siblings,
            'items' => $items,
            'categoryLabel' => $product->categoryLabel(),
            'company' => $company,
            'fraisLivraison' => (float) ($company['frais_livraison'] ?? 30),
            'whatsappUrl' => CompanyProfile::whatsappUrl($company),
            'whatsappDisplay' => CompanyProfile::whatsappDisplay($company),
        ]);
    }
}
