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
            $table->string('nama')->after('user_id');
            $table->string('telepon')->after('nama');
            $table->string('alamat')->after('telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            $table->dropColumn(['nama', 'alamat', 'telepon']);
        });
    }
};
