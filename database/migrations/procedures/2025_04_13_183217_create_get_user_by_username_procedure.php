<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION GetUserByUsername(
                p_username VARCHAR
            )
            RETURNS TABLE (
                id BIGINT,
                sf_id UUID,
                username VARCHAR,
                name VARCHAR,
                email VARCHAR,
                email_verified_at TIMESTAMP,
                password VARCHAR,
                remember_token VARCHAR,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
            AS $$
            BEGIN
                RETURN QUERY
                SELECT 
                    u.id,
                    u.sf_id,
                    u.username,
                    u.name,
                    u.email,
                    u.email_verified_at,
                    u.password,
                    u.remember_token,
                    u.created_at,
                    u.updated_at
                FROM users u
                WHERE u.username = p_username
                LIMIT 1;
            END;
            $$
            LANGUAGE plpgsql;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS GetUserByUsername");
    }
};
