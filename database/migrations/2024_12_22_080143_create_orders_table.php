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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            //service
            $table->string('service');
            // price
            $table->integer('price');
            // payment url
            $table->string('payment_url')->nullable();
            // status[waiting, paid, cancel]
            $table->string('status')->default('waiting');
            // duration
            $table->integer('duration');
            //clinic_id
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            // schedule
            $table->dateTime('schedule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
