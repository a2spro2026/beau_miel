<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->string('titre');
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->string('categorie'); // miel, fruits_secs, dattes
            $table->string('partenaire')->nullable();
            $table->decimal('prix_achat', 10, 2)->default(0);
            $table->decimal('prix_vente', 10, 2)->default(0);
            $table->unsignedInteger('qte')->default(0);
            $table->string('photo')->nullable();
            $table->string('statut')->default('actif'); // actif, inactif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
