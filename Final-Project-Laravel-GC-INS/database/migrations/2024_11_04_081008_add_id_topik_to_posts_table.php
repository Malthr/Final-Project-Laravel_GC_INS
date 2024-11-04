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
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('id_topik')->nullable();

            // Tentukan 'id_topik' sebagai foreign key yang merujuk ke 'id' di tabel 'topik'
            $table->foreign('id_topik')->references('id')->on('topik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['id_topik']);
            $table->dropColumn('id_topik');
        });
    }
};
