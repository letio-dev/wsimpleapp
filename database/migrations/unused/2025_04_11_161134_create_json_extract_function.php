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
            CREATE FUNCTION json_extract_value(json_str TEXT, key_name VARCHAR(100)) RETURNS TEXT
            DETERMINISTIC
            BEGIN
                DECLARE start_pos INT;
                DECLARE end_pos INT;
                DECLARE key_pattern VARCHAR(200);
                DECLARE value TEXT;

                SET key_pattern = CONCAT('\"', key_name, '\":\"');
                SET start_pos = LOCATE(key_pattern, json_str);

                IF start_pos = 0 THEN
                    RETURN NULL;
                END IF;

                SET start_pos = start_pos + CHAR_LENGTH(key_pattern);
                SET end_pos = LOCATE('\"', json_str, start_pos);

                SET value = SUBSTRING(json_str, start_pos, end_pos - start_pos);
                RETURN value;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS json_extract_value;");
    }
};
