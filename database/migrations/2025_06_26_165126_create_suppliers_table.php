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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_person_id')->constrained('contact_persons')->onDelete('cascade');
            $table->string('company_name', 100);
            $table->string('address', 255);
            $table->date('next_delivery_date')->nullable();
            $table->time('next_delivery_time')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
