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
        Schema::create('family_contact_persons', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('infix', 20)->nullable();
            $table->string('last_name', 50);
            $table->date('birth_date')->nullable();
            $table->string('relation', 50);
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();
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
        Schema::dropIfExists('family_members');
    }
};
