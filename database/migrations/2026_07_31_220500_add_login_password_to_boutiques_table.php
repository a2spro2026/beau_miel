<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('login')->nullable()->after('activite');
            $table->string('mot_de_passe')->nullable()->after('login');
        });

        $rows = \Illuminate\Support\Facades\DB::table('boutiques')->whereNull('login')->orderBy('id')->get();
        foreach ($rows as $row) {
            \Illuminate\Support\Facades\DB::table('boutiques')->where('id', $row->id)->update([
                'login' => $row->email,
                'mot_de_passe' => strtoupper(\Illuminate\Support\Str::random(3)).random_int(10, 99).strtolower(\Illuminate\Support\Str::random(3)),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['login', 'mot_de_passe']);
        });
    }
};
