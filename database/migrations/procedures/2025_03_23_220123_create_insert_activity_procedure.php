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
            CREATE OR REPLACE FUNCTION InsertActivity(
                p_tracking_number VARCHAR,
                p_courier_service VARCHAR,
                p_recipient_name VARCHAR,
                p_tower VARCHAR,
                p_floor VARCHAR,
                p_unit VARCHAR,
                p_recipient_phone VARCHAR,
                p_notes TEXT,
                p_user_checkin_id BIGINT
            )
            RETURNS UUID
            AS $$
            DECLARE
                new_sf_id UUID;
            BEGIN
                INSERT INTO activities (
                    tracking_number,
                    courier_service,
                    recipient_name,
                    tower,
                    floor,
                    unit,
                    recipient_phone,
                    notes,
                    user_checkin_id,
                    status
                )
                VALUES (
                    p_tracking_number,
                    p_courier_service,
                    p_recipient_name,
                    p_tower,
                    p_floor,
                    p_unit,
                    p_recipient_phone,
                    p_notes,
                    p_user_checkin_id,
                    1
                )
                RETURNING sf_id INTO new_sf_id;

                RETURN new_sf_id;
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
        DB::statement("DROP FUNCTION IF EXISTS InsertActivity");
    }
};
