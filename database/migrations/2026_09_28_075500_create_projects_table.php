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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->string('slug')->unique();
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('developer')->nullable();
            $table->string('project_type')->nullable(); // e.g. Residential, Commercial
            
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            
            $table->integer('total_units')->nullable();
            $table->integer('available_units')->nullable();
            $table->integer('sold_units')->nullable();
            
            $table->decimal('starting_price', 15, 2)->nullable();
            $table->decimal('maximum_price', 15, 2)->nullable();
            
            $table->date('completion_date')->nullable();
            
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed, on_hold, cancelled
            
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_url')->nullable();
            
            $table->boolean('is_featured')->default(false);
            
            $table->json('images')->nullable(); // Stores array of image paths. Index 0 is main image.
            $table->json('amenities')->nullable(); // Array of amenities
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
