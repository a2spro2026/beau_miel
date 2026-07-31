<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFamily extends Model
{
    protected $fillable = [
        'titre',
        'photo',
        'description',
        'statut',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ProductFamilyItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function photoUrl(): string
    {
        if ($this->photo) {
            return asset('storage/'.$this->photo);
        }

        $first = $this->items->first();

        return $first?->photoUrl() ?? asset('images/products/miel.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }

    public function publicPayload(): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'photo' => $this->photoUrl(),
            'items' => $this->items->map(fn (ProductFamilyItem $item) => [
                'id' => $item->id,
                'titre' => $item->titre,
                'mesure' => $item->mesure,
                'prix_u' => (float) $item->prix_u,
                'photo' => $item->photoUrl(),
            ])->values()->all(),
        ];
    }
}
