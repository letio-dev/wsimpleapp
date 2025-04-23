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
        DB::unprepared('
            CREATE OR REPLACE FUNCTION ViewActivitiesReport(
                p_year VARCHAR(4),
                p_month VARCHAR(2),
                p_timezone VARCHAR(50)
            )
            RETURNS TABLE (
                tracking_number VARCHAR,
                courier_service VARCHAR,
                recipient_name VARCHAR,
                tower VARCHAR,
                floor VARCHAR,
                unit VARCHAR,
                recipient_phone VARCHAR,
                notes TEXT,
                user_checkin VARCHAR,
                user_checkout VARCHAR,
                status SMALLINT,
                created_at TIMESTAMP,
                checkout_at TIMESTAMP,
                updated_at TIMESTAMP
            )
            AS $$
            DECLARE
                v_timezone VARCHAR(50) := COALESCE(NULLIF(p_timezone, \'\'), \'UTC\');
            BEGIN
                RETURN QUERY
                SELECT 
                    a.tracking_number,
                    a.courier_service,
                    a.recipient_name,
                    a.tower,
                    a.floor,
                    a.unit,
                    a.recipient_phone,
                    a.notes,
                    (SELECT u.name FROM users u WHERE u.id = a.user_checkin_id LIMIT 1) AS user_checkin,
                    (SELECT u.name FROM users u WHERE u.id = a.user_checkout_id LIMIT 1) AS user_checkout,
                    a.status,
                    a.created_at AT TIME ZONE \'UTC\' AT TIME ZONE v_timezone,
                    a.checkout_at AT TIME ZONE \'UTC\' AT TIME ZONE v_timezone,
                    a.updated_at AT TIME ZONE \'UTC\' AT TIME ZONE v_timezone
                FROM activities a
                WHERE TO_CHAR(a.created_at, \'YYYY\') = p_year
                    AND (p_month = \'00\' OR TO_CHAR(a.created_at, \'MM\') = p_month)
                ORDER BY a.id ASC;
            END;
            $$
            LANGUAGE plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP FUNCTION IF EXISTS ViewActivitiesReport');
    }
};
