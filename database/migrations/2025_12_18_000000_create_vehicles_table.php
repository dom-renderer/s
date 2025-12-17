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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->unsignedBigInteger('vehicle_class_id')->nullable();
            $table->unsignedBigInteger('transmission_id')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('doors')->nullable();
            $table->integer('passengers')->nullable();
            $table->string('luggage_capacity')->nullable();
            $table->text('other')->nullable();
            $table->decimal('base_cost_per_day', 10, 2)->default(0.00);
            $table->decimal('vat_percentage', 5, 2)->default(0.00);
            $table->json('images')->nullable();
            $table->unsignedBigInteger('primary_pickup_location_id')->nullable();
            $table->string('alternate_pickup_location')->nullable();
            $table->boolean('status')->default(1)->comment('0 = Inactive | 1 = Active');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('vehicle_class_id')->references('id')->on('vehicle_classes')->onDelete('set null');
            $table->foreign('transmission_id')->references('id')->on('vehicle_transmissions')->onDelete('set null');
            $table->foreign('primary_pickup_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->index('vehicle_name');
            $table->index('make');
            $table->index('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
