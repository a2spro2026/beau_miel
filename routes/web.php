<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\InscriptionController;
use App\Models\Product;
use App\Support\CompanyProfile;
use App\Support\SiteSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = SiteSettings::all();
    $player = SiteSettings::videoPlayer($settings);
    $company = CompanyProfile::all();

    return view('home', [
        'settings' => $settings,
        'videoPlayer' => $player,
        'videoSrc' => $player['src'] ?? null,
        'habillageSrc' => SiteSettings::habillageSrc($settings),
        'products' => Product::query()->active()->orderByDesc('id')->get(),
        'company' => $company,
        'whatsappUrl' => CompanyProfile::whatsappUrl($company),
        'whatsappNumber' => CompanyProfile::whatsappDigits($company),
        'whatsappDisplay' => CompanyProfile::whatsappDisplay($company),
    ]);
});

Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

Route::get('/boutique/produit/{product}', [FamilyController::class, 'showProduct'])->name('shop.product');
Route::get('/boutique/{family}', [FamilyController::class, 'show'])->name('family.show');

Route::post('/administration/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/administration', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/administration/produits', [AdminController::class, 'products'])->name('admin.products');
Route::post('/administration/produits', [AdminController::class, 'storeProduct'])->name('admin.products.store');
Route::put('/administration/produits/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/administration/produits/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
Route::post('/administration/produits/{product}/statut', [AdminController::class, 'updateProductStatus'])->name('admin.products.status');
Route::get('/administration/familles', [FamilyController::class, 'index'])->name('admin.families');
Route::post('/administration/familles', [FamilyController::class, 'store'])->name('admin.families.store');
Route::delete('/administration/familles/{family}', [FamilyController::class, 'destroy'])->name('admin.families.destroy');
Route::get('/administration/nouveaux-inscrits', [InscriptionController::class, 'index'])->name('admin.inscriptions');
Route::post('/administration/nouveaux-inscrits/{inscription}/valider', [InscriptionController::class, 'validateRequest'])->name('admin.inscriptions.validate');
Route::post('/administration/nouveaux-inscrits/{inscription}/reporter', [InscriptionController::class, 'postpone'])->name('admin.inscriptions.postpone');
Route::post('/administration/nouveaux-inscrits/{inscription}/refuser', [InscriptionController::class, 'refuse'])->name('admin.inscriptions.refuse');
Route::get('/administration/e-boutique/fiche-partenaire', [BoutiqueController::class, 'partners'])->name('admin.eboutique.partners');
Route::put('/administration/e-boutique/fiche-partenaire/{boutique}', [BoutiqueController::class, 'updatePartner'])->name('admin.eboutique.partners.update');
Route::delete('/administration/e-boutique/fiche-partenaire/{boutique}', [BoutiqueController::class, 'destroyPartner'])->name('admin.eboutique.partners.destroy');
Route::get('/administration/e-boutique/produits', [BoutiqueController::class, 'products'])->name('admin.eboutique.products');
Route::get('/administration/e-boutique/balance-ventes', [BoutiqueController::class, 'sales'])->name('admin.eboutique.sales');
Route::get('/administration/parametres/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::get('/administration/parametres/commerciaux', [AdminController::class, 'commerciaux'])->name('admin.commerciaux');
Route::get('/administration/parametres/societe', [AdminController::class, 'company'])->name('admin.company');
Route::post('/administration/parametres/societe', [AdminController::class, 'updateCompany'])->name('admin.company.update');
Route::get('/administration/parametres', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/administration/parametres', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
Route::post('/administration/logout', [AdminController::class, 'logout'])->name('admin.logout');
