<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFamilyItem extends Model
{
    protected $fillable = [
        'product_family_id',
        'titre',
        'mesure',
        'prix_u',
        'photo',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'prix_u' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class, 'product_family_id');
    }

    public function photoUrl(): string
    {
        if ($this->photo) {
            return asset('storage/'.$this->photo);
        }

        return $this->family?->photo
            ? asset('storage/'.$this->family->photo)
            : asset('images/products/miel.jpg');
    }
}
