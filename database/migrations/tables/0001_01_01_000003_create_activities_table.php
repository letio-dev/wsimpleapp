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

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->uuid('sf_id')->unique()->default(DB::raw('uuid_generate_v4()')); // UUID type for PostgreSQL
            $table->string('tracking_number', 50);
            $table->string('courier_service', 50)->nullable();
            $table->string('recipient_name', 100)->nullable();
            $table->string('tower', 50)->nullable();
            $table->string('floor', 10)->nullable();
            $table->string('unit', 20)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_checkin_id')->nullable();
            $table->unsignedBigInteger('user_checkout_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('checkout_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Trigger updated_at column on update
        DB::unprepared('
            CREATE TRIGGER update_at_timestamp
            BEFORE UPDATE ON activities
            FOR EACH ROW
            EXECUTE FUNCTION trigger_update_timestamp();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_at_timestamp ON activities;');

        Schema::dropIfExists('activities');
    }
};
