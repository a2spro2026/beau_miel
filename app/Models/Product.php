<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'ref',
        'titre',
        'designation',
        'description',
        'categorie',
        'partenaire',
        'prix_achat',
        'prix_vente',
        'qte',
        'photo',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'prix_achat' => 'decimal:2',
            'prix_vente' => 'decimal:2',
            'qte' => 'integer',
        ];
    }

    public const CATEGORIES = [
        'miel' => 'Miel',
        'fruits_secs' => 'Fruits Secs',
        'dattes' => 'Dattes',
    ];

    public const STATUTS = [
        'actif' => 'Actif',
        'inactif' => 'Inactif',
    ];

    public static function nextRef(): string
    {
        $last = static::query()
            ->where('ref', 'like', 'BM-%')
            ->orderByDesc('id')
            ->value('ref');

        $n = 1;
        if ($last && preg_match('/BM-(\d+)/', $last, $m)) {
            $n = ((int) $m[1]) + 1;
        }

        return 'BM-'.str_pad((string) $n, 4, '0', STR_PAD_LEFT);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->categorie] ?? $this->categorie;
    }

    public function statutLabel(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function stockLabel(): string
    {
        return $this->qte > 0 ? 'Dispo' : 'Rupture';
    }

    public function isAvailable(): bool
    {
        return $this->statut === 'actif' && $this->qte > 0;
    }

    public function photoUrl(): string
    {
        if ($this->photo) {
            return asset('storage/'.$this->photo);
        }

        return match ($this->categorie) {
            'fruits_secs' => asset('images/products/fruits-secs.jpg'),
            'dattes' => asset('images/products/dattes.jpg'),
            default => asset('images/products/miel.jpg'),
        };
    }

    public function adminPayload(): array
    {
        return [
            'ref' => $this->ref,
            'titre' => $this->titre,
            'designation' => $this->designation,
            'description' => $this->description,
            'categorie' => $this->categoryLabel(),
            'categorie_value' => $this->categorie,
            'partenaire' => $this->partenaire,
            'prix_achat' => (string) $this->prix_achat,
            'prix_vente' => (string) $this->prix_vente,
            'qte' => $this->qte,
            'statut' => $this->statutLabel(),
            'statut_value' => $this->statut,
            'photo' => $this->photoUrl(),
            'stock' => $this->stockLabel(),
            'update_url' => route('admin.products.update', $this),
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }
}
