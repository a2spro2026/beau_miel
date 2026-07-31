<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InscriptionRequest extends Model
{
    protected $fillable = [
        'date_demande',
        'nom_complet',
        'telephone',
        'email',
        'ville',
        'activite',
        'statut',
        'traite_at',
    ];

    protected function casts(): array
    {
        return [
            'date_demande' => 'date',
            'traite_at' => 'datetime',
        ];
    }

    public const STATUTS = [
        'en_attente' => 'En attente',
        'reporte' => 'Reporté',
        'refuse' => 'Refusé',
        'valide' => 'Validé',
    ];

    public function boutique(): HasOne
    {
        return $this->hasOne(Boutique::class);
    }

    public function scopePending($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function statutLabel(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function rowClass(): string
    {
        return match ($this->statut) {
            'reporte' => 'is-reporte',
            'refuse' => 'is-refuse',
            'valide' => 'is-valide',
            default => 'is-attente',
        };
    }
}
