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
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_all_foodpackages');

        DB::unprepared('
            CREATE PROCEDURE sp_get_all_foodpackages()
            BEGIN
                SELECT  FP.id AS foodpackage_id
                        ,FP.package_number
                        ,FP.date_composed
                        ,FP.date_issued
                        ,FP.date_updated
                        ,FP.date_created
                
                FROM food_packages AS FP

                ORDER BY FP.date_created DESC;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DROP PROCEDURE IF EXISTS sp_get_all_foodpackages');
    }
};
