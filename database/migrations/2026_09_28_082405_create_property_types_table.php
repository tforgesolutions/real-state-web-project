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
        Schema::create('property_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Can be icon class or image path
            $table->string('status')->default('Active'); // Active, Inactive
            $table->timestamps();
        });
        
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('property_type_id')->nullable()->constrained('property_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['property_type_id']);
            $table->dropColumn('property_type_id');
        });
        
        Schema::dropIfExists('property_types');
    }
};
