<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Using string for reviewable_id since our current dummy data relies on string slugs
            $table->string('reviewable_type');
            $table->string('reviewable_id');
            $table->index(['reviewable_type', 'reviewable_id']);
            
            $table->integer('rating')->unsigned(); // 1-5
            $table->string('title')->nullable();
            $table->text('body');
            $table->string('review_context')->nullable();
            $table->string('status')->default('published'); // default published for public UX (no admin yet)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
