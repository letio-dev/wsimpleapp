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
        DB::unprepared("
            CREATE FUNCTION uuid_v4()
            RETURNS CHAR(36)
            DETERMINISTIC
            BEGIN
              DECLARE h1 CHAR(8);
              DECLARE h2 CHAR(4);
              DECLARE h3 CHAR(4);
              DECLARE h4 CHAR(4);
              DECLARE h5 CHAR(12);

              SET h1 = LPAD(CONV(FLOOR(RAND()*4294967296), 10, 16), 8, '0');
              SET h2 = LPAD(CONV(FLOOR(RAND()*65536), 10, 16), 4, '0');
              SET h3 = CONCAT('4', LPAD(CONV(FLOOR(RAND()*4096), 10, 16), 3, '0'));
              SET h4 = CONCAT(
                LPAD(CONV(FLOOR(RAND()*4)+8, 10, 16), 1, '0'),
                LPAD(CONV(FLOOR(RAND()*4096), 10, 16), 3, '0')
              );
              SET h5 = LPAD(CONV(FLOOR(RAND()*281474976710656), 10, 16), 12, '0');

              RETURN LOWER(CONCAT(h1, '-', h2, '-', h3, '-', h4, '-', h5));
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS uuid_v4;");
    }
};
