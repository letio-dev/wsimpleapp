<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aktifkan ekstensi UUID jika belum aktif
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('activities_history', function (Blueprint $table) {
            $table->id();
            $table->uuid('sf_id')->unique()->default(DB::raw('uuid_generate_v4()')); // UUID type for PostgreSQL
            $table->unsignedBigInteger('activity_id');
            $table->jsonb('data_before');
            $table->string('action', 20); // INSERT, UPDATE, DELETE
            $table->unsignedBigInteger('changed_user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities_history');
    }
};
