<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscription_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_demande');
            $table->string('nom_complet');
            $table->string('telephone', 40);
            $table->string('email');
            $table->string('ville');
            $table->string('activite');
            $table->string('statut')->default('en_attente'); // en_attente, reporte, refuse, valide
            $table->timestamp('traite_at')->nullable();
            $table->timestamps();
        });

        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_request_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nom');
            $table->string('email');
            $table->string('telephone', 40);
            $table->string('ville');
            $table->string('activite');
            $table->string('statut')->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boutiques');
        Schema::dropIfExists('inscription_requests');
    }
};
