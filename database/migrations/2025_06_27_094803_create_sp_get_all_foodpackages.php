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
        if (config('database.default') !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_all_foodpackages');

        DB::unprepared('
            CREATE PROCEDURE sp_get_all_foodpackages()
            BEGIN
                SELECT  FP.id AS foodpackage_id
                        ,FP.package_number
                        ,FP.date_composed
                        ,FP.date_issued
                
                FROM food_packages AS FP

                ORDER BY FP.date_composed DESC;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        if (config('database.default') !== 'mysql') {
            return;
        }
        Schema::dropIfExists('DROP PROCEDURE IF EXISTS sp_get_all_foodpackages');
    }
};
