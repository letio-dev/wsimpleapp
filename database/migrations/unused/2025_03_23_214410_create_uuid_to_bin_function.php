<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS BIN_TO_UUID;");
        DB::unprepared("DROP FUNCTION IF EXISTS UUID_TO_BIN;");

        DB::unprepared("
            CREATE FUNCTION BIN_TO_UUID(bin BINARY(16)) RETURNS CHAR(36)
            DETERMINISTIC
            BEGIN
              RETURN LOWER(CONCAT_WS('-',
                HEX(SUBSTRING(bin, 1, 4)),
                HEX(SUBSTRING(bin, 5, 2)),
                HEX(SUBSTRING(bin, 7, 2)),
                HEX(SUBSTRING(bin, 9, 2)),
                HEX(SUBSTRING(bin, 11))
              ));
            END;
        ");

        DB::unprepared("
            CREATE FUNCTION UUID_TO_BIN(uuid CHAR(36)) RETURNS BINARY(16)
            DETERMINISTIC
            BEGIN
              RETURN UNHEX(CONCAT(
                SUBSTRING(uuid, 1, 8),
                SUBSTRING(uuid, 10, 4),
                SUBSTRING(uuid, 15, 4),
                SUBSTRING(uuid, 20, 4),
                SUBSTRING(uuid, 25)
              ));
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS BIN_TO_UUID;");
        DB::unprepared("DROP FUNCTION IF EXISTS UUID_TO_BIN;");
    }
};
