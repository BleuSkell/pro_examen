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
        // Drop procedure if exists (avoid errors)
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertSupplier');

        // Create the stored procedure
        DB::unprepared('
            CREATE PROCEDURE InsertSupplier(
                IN p_contact_person_id BIGINT,
                IN p_company_name VARCHAR(100),
                IN p_address VARCHAR(255),
                IN p_next_delivery_date DATE,
                IN p_next_delivery_time TIME,
                OUT p_success BOOLEAN,
                OUT p_error_msg VARCHAR(255)
            )
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    SET p_success = FALSE;
                    SET p_error_msg = "Er is een fout opgetreden bij het toevoegen van de leverancier.";
                END;

                INSERT INTO suppliers (contact_person_id, company_name, address, next_delivery_date, next_delivery_time, date_created, is_active)
                VALUES (p_contact_person_id, p_company_name, p_address, p_next_delivery_date, p_next_delivery_time, NOW(), TRUE);

                SET p_success = TRUE;
                SET p_error_msg = NULL;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertSupplier');
    }
};
// This migration creates a stored procedure named InsertSupplier that inserts a new supplier into the suppliers table.
// It takes parameters for contact person ID, company name, address, next delivery date, and next delivery time.
// It also has output parameters for success status and error message.