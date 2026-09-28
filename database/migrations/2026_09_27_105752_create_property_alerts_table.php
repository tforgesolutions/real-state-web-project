<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('transaction_type')->nullable(); // buy, rent
            $table->string('property_type')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('min_price')->nullable();
            $table->unsignedBigInteger('max_price')->nullable();
            $table->integer('min_bedrooms')->nullable();
            $table->integer('max_bedrooms')->nullable();
            $table->integer('min_bathrooms')->nullable();
            $table->integer('max_bathrooms')->nullable();
            $table->integer('min_area')->nullable();
            $table->integer('max_area')->nullable();
            $table->string('frequency')->default('instant'); // instant, daily, weekly
            $table->string('status')->default('active'); // active, paused
            $table->timestamp('last_notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_alerts');
    }
};
