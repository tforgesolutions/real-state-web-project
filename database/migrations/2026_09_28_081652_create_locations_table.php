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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Country, Province/State, City, Area/Locality
            $table->foreignId('parent_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('status')->default('Active'); // Active, Inactive
            $table->timestamps();
            
            // Allow same name in different parents (e.g., City of London in UK vs Canada)
            $table->unique(['name', 'parent_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
