<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // CREATE
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_create_customer;
            CREATE PROCEDURE sp_create_customer(
                IN p_family_contact_persons_id INT,
                IN p_amount_adults INT,
                IN p_amount_children INT,
                IN p_amount_babies INT,
                IN p_special_wishes VARCHAR(255),
                IN p_family_name VARCHAR(100),
                IN p_address VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                INSERT INTO customers (
                    family_contact_persons_id,
                    amount_adults,
                    amount_children,
                    amount_babies,
                    special_wishes,
                    family_name,
                    address,
                    is_active,
                    date_created,
                    updated_at
                ) VALUES (
                    p_family_contact_persons_id,
                    p_amount_adults,
                    p_amount_children,
                    p_amount_babies,
                    p_special_wishes,
                    p_family_name,
                    p_address,
                    p_is_active,
                    NOW(),
                    NOW()
                );
            END
        ');

        // READ
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_get_customers;
            CREATE PROCEDURE sp_get_customers()
            BEGIN
                SELECT c.*, f.first_name as family_contact_first_name, f.infix as family_contact_infix, f.last_name as family_contact_last_name
                FROM customers c
                LEFT JOIN family_contact_persons f ON c.family_contact_persons_id = f.id
                ORDER BY c.date_created DESC;
            END
        ');

        // UPDATE
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_update_customer;
            CREATE PROCEDURE sp_update_customer(
                IN p_id INT,
                IN p_family_contact_persons_id INT,
                IN p_amount_adults INT,
                IN p_amount_children INT,
                IN p_amount_babies INT,
                IN p_special_wishes VARCHAR(255),
                IN p_family_name VARCHAR(100),
                IN p_address VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                UPDATE customers SET
                    family_contact_persons_id = p_family_contact_persons_id,
                    amount_adults = p_amount_adults,
                    amount_children = p_amount_children,
                    amount_babies = p_amount_babies,
                    special_wishes = p_special_wishes,
                    family_name = p_family_name,
                    address = p_address,
                    is_active = p_is_active,
                    updated_at = NOW()
                WHERE id = p_id;
            END
        ');

        // DELETE
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_delete_customer;
            CREATE PROCEDURE sp_delete_customer(
                IN p_id INT
            )
            BEGIN
                DELETE FROM customers WHERE id = p_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_create_customer;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_customers;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_update_customer;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_customer;');
    }
}
