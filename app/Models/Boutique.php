<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Boutique extends Model
{
    protected $fillable = [
        'inscription_request_id',
        'nom',
        'email',
        'telephone',
        'ville',
        'activite',
        'login',
        'mot_de_passe',
        'statut',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(InscriptionRequest::class, 'inscription_request_id');
    }

    public static function generatePassword(int $length = 8): string
    {
        return Str::upper(Str::random(3)).rand(10, 99).Str::lower(Str::random(3));
    }

    public function adminPayload(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'ville' => $this->ville,
            'activite' => $this->activite,
            'login' => $this->login,
            'mot_de_passe' => $this->mot_de_passe,
            'statut' => $this->statut,
            'statut_label' => $this->statut === 'actif' ? 'Actif' : 'Inactif',
            'update_url' => route('admin.eboutique.partners.update', $this),
        ];
    }
}
