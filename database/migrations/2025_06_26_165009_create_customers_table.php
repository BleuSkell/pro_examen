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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_contact_persons_id')->constrained('family_contact_persons')->onDelete('cascade');
            $table->integer('amount_adults');
            $table->integer('amount_children')->nullable();
            $table->integer('amount_babies')->nullable();
            $table->string('special_wishes', 255)->nullable();
            $table->string('family_name', 100);
            $table->string('address', 255);
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
        Schema::dropIfExists('customers');
    }
};
