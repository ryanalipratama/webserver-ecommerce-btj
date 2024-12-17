<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending')->after('jumlah_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            //
        });
    }
};
