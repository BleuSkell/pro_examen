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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('amount')->default(0);
            $table->dateTime('date_created')->useCurrent();
            $table->dateTime('date_updated')->useCurrent()->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

// SQL voor MySQL
//DELIMITER $$

//CREATE PROCEDURE add_product_and_stock(
//    IN p_product_name VARCHAR(100),
//    IN p_supplier_id BIGINT,
//    IN p_category_id BIGINT,
//    IN p_amount INT
//)
//BEGIN
//    DECLARE new_product_id BIGINT;

//    INSERT INTO products (product_name, supplier_id, product_category_id, barcode, date_created, date_updated, is_active)
//    VALUES (p_product_name, p_supplier_id, p_category_id, UUID(), NOW(), NOW(), TRUE);

//    SET new_product_id = LAST_INSERT_ID();

//    INSERT INTO stocks (product_id, amount, date_created, date_updated, is_active)
//    VALUES (new_product_id, p_amount, NOW(), NOW(), TRUE);
//END$$

//DELIMITER ;
