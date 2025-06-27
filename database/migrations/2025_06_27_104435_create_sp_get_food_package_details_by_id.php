<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_food_package_details_by_id');

        DB::unprepared('
            CREATE PROCEDURE sp_get_food_package_details_by_id(
                IN in_food_package_id INT
            )
            BEGIN
                SELECT 
                    FP.id AS food_package_id,
                    FP.customer_id,
                    FP.package_number,
                    FP.date_composed,
                    FP.date_issued,

                    C.id AS customer_id,
                    C.amount_adults,
                    C.amount_children,
                    C.amount_babies,
                    C.special_wishes,
                    C.family_name,
                    C.address,

                    FCP.id AS family_contact_person_id,
                    FCP.first_name,
                    FCP.infix,
                    FCP.last_name,
                    FCP.relation,
                    FCP.email AS family_email,
                    FCP.phone AS family_phone

                FROM food_packages FP
                JOIN customers C ON FP.customer_id = C.id
                JOIN family_contact_persons FCP ON C.family_contact_persons_id = FCP.id
                WHERE FP.id = in_food_package_id;

                


                SELECT 
                    FPP.id AS food_package_product_id,
                    FPP.food_package_id,
                    FPP.product_id,
                    FPP.amount,
                    P.product_name,
                    P.barcode
                FROM food_package_products FPP
                JOIN products P ON FPP.product_id = P.id
                WHERE FPP.food_package_id = in_food_package_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DROP PROCEDURE IF EXISTS sp_get_food_package_details_by_id');
    }
};
