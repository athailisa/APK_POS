<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('kategori', 'jenis');

        Schema::table('produk', function (Blueprint $table) {
            $table->renameColumn('kategori_id', 'jenis_id');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->renameColumn('jenis_id', 'kategori_id');
        });

        Schema::rename('jenis', 'kategori');
    }
};
