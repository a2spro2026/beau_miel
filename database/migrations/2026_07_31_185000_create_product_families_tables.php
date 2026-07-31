<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_families', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->string('statut')->default('actif');
            $table->timestamps();
        });

        Schema::create('product_family_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_family_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->string('mesure');
            $table->decimal('prix_u', 10, 2)->default(0);
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_family_items');
        Schema::dropIfExists('product_families');
    }
};
