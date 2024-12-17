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
            $table->string('jasa_pengiriman')->nullable();
            $table->string('biaya_pengiriman')->default(15000);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            $table->dropColumn(['jasa_pengiriman', 'biaya_pengiriman']);
        });
    }
};
