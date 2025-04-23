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
            CREATE OR REPLACE FUNCTION EditActivity(
                p_activity_sf_id UUID,
                p_user_id BIGINT,
                p_json JSONB
            )
            RETURNS VOID
            AS $$
            DECLARE
                v_tracking_number VARCHAR(50);
                v_courier_service VARCHAR(50);
                v_recipient_name VARCHAR(100);
                v_recipient_phone VARCHAR(20);
                v_tower VARCHAR(50);
                v_floor VARCHAR(10);
                v_unit VARCHAR(20);
                v_notes TEXT;
                v_activity_id BIGINT;
                v_data_before JSONB;
            BEGIN
                -- Mengambil nilai dari JSONB
                v_tracking_number := p_json->>'tracking_number';
                v_courier_service := p_json->>'courier_service';
                v_recipient_name := p_json->>'recipient_name';
                v_recipient_phone := p_json->>'recipient_phone';
                v_tower := p_json->>'tower';
                v_floor := p_json->>'floor';
                v_unit := p_json->>'unit';
                v_notes := p_json->>'notes';

                -- Ambil data sebelum diupdate dari tabel activities
                SELECT a.id, row_to_json(a.*) 
                INTO v_activity_id, v_data_before
                FROM activities a
                WHERE a.sf_id = p_activity_sf_id;

                -- Update activities
                UPDATE activities
                SET 
                    tracking_number = COALESCE(NULLIF(v_tracking_number, ''), tracking_number),
                    courier_service = COALESCE(NULLIF(v_courier_service, ''), courier_service),
                    recipient_name = COALESCE(NULLIF(v_recipient_name, ''), recipient_name),
                    recipient_phone = COALESCE(NULLIF(v_recipient_phone, ''), recipient_phone),
                    tower = COALESCE(NULLIF(v_tower, ''), tower),
                    floor = COALESCE(NULLIF(v_floor, ''), floor),
                    unit = COALESCE(NULLIF(v_unit, ''), unit),
                    notes = COALESCE(NULLIF(v_notes, ''), notes)
                WHERE sf_id = p_activity_sf_id;

                -- Insert ke activities_history
                INSERT INTO activities_history (activity_id, data_before, action, changed_user_id)
                VALUES (
                    v_activity_id,  -- Ganti ke ID yang sesuai jika activity_id berbeda
                    v_data_before,             -- Data sebelum perubahan
                    'UPDATE',                  -- Action jenis 'UPDATE'
                    p_user_id                 -- ID user yang melakukan perubahan
                );

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
        DB::unprepared("DROP FUNCTION IF EXISTS EditActivity");
    }
};
