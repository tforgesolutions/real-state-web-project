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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reference_id')->unique();
            $table->string('slug')->unique();
            
            // Purpose & Type
            $table->string('purpose'); // buy, rent
            $table->string('property_category'); // Residential, Commercial, Plot
            $table->string('property_type'); // House, Apartment, Villa, etc.
            
            // Details
            $table->string('title');
            $table->decimal('price', 15, 2);
            $table->string('price_unit')->nullable();
            $table->boolean('negotiable')->default(false);
            $table->decimal('area', 10, 2);
            $table->string('area_unit');
            
            $table->integer('bedrooms')->nullable();
            $table->decimal('bathrooms', 4, 1)->nullable();
            $table->string('furnished')->nullable();
            $table->string('condition')->nullable();
            $table->string('parking')->nullable();
            $table->integer('construction_year')->nullable();
            
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            
            // Location
            $table->string('country')->nullable();
            $table->string('city');
            $table->string('area_locality');
            $table->string('society')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            
            // Media
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->string('floor_plan_image')->nullable();
            
            // Contact
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('contact_whatsapp')->nullable();
            $table->string('preferred_contact_method')->default('Phone');
            
            // Status
            $table->string('status')->default('pending_review'); // draft, pending_review, approved, rejected, sold, rented, inactive
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for search performance
            $table->index(['purpose', 'status', 'city']);
            $table->index(['property_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
