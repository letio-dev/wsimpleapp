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
            CREATE OR REPLACE FUNCTION AcceptActivity(
                p_activity_sf_id UUID,
                p_user_id BIGINT,
                p_timezone VARCHAR
            )
            RETURNS TABLE (
                status SMALLINT,
                user_checkout VARCHAR,
                updated_at TIMESTAMP
            )
            AS $$
            DECLARE
                v_activity_id BIGINT;
                v_data_before JSONB;
            BEGIN
                -- Ambil activity_id dan data sebelum diupdate dari tabel activities
                SELECT a.id, row_to_json(a.*)
                INTO v_activity_id, v_data_before
                FROM activities a
                WHERE a.sf_id = p_activity_sf_id;

                -- Update data
                UPDATE activities
                SET 
                    status = 2,
                    user_checkout_id = p_user_id,
                    checkout_at = CURRENT_TIMESTAMP
                WHERE sf_id = p_activity_sf_id;

                -- Insert ke activities_history
                INSERT INTO activities_history (activity_id, data_before, action, changed_user_id)
                VALUES (
                    v_activity_id,       -- Activity ID yang diambil dari tabel activities
                    v_data_before,       -- Data sebelum perubahan
                    'UPDATE',            -- Action jenis 'UPDATE'
                    p_user_id           -- ID user yang melakukan perubahan
                );

                -- Return hasil setelah update
                RETURN QUERY
                SELECT 
                    a.status,
                    (SELECT u.name FROM users u WHERE u.id = a.user_checkout_id LIMIT 1) AS user_checkout,
                    a.updated_at AT TIME ZONE 'UTC' AT TIME ZONE p_timezone
                FROM activities a
                WHERE a.sf_id = p_activity_sf_id;
            END;
            $$
            LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS AcceptActivity");
    }
};
