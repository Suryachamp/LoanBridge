<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile', 20)->unique();
            $table->string('email');
            $table->date('dob');
            $table->string('city');
            $table->string('pincode');
            $table->string('loan_type');
            $table->string('employment_type');
            $table->decimal('monthly_income', 15, 2);
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('property_value', 15, 2);
            $table->boolean('consent')->default(1);
            $table->integer('credit_score')->nullable();
            $table->string('bre_status')->nullable();
            $table->text('bre_reasons')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
