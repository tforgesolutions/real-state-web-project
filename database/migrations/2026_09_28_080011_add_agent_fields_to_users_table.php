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
        Schema::table('users', function (Blueprint $table) {
            // Profile & Contact
            $table->string('profile_photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            
            // Professional Info
            $table->string('agency')->nullable();
            $table->string('designation')->nullable();
            $table->text('bio')->nullable();
            $table->integer('experience_years')->nullable();
            
            // Location
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            
            // Social Links
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            
            // Status & Featured
            $table->string('status')->default('active'); // active, inactive, suspended
            $table->boolean('is_featured')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'phone',
                'whatsapp',
                'agency',
                'designation',
                'bio',
                'experience_years',
                'address',
                'city',
                'country',
                'facebook_url',
                'instagram_url',
                'linkedin_url',
                'website_url',
                'status',
                'is_featured'
            ]);
        });
    }
};
