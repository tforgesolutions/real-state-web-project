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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('inquiry_type')->default('General Inquiry');
            
            // Relationships
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // The user who submitted it if logged in
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete(); // Assigned agent
            
            $table->text('message');
            
            // Status and Priority
            $table->string('status')->default('New'); // New, Contacted, In Progress, Follow Up, Converted, Closed, Spam
            $table->string('priority')->default('Medium'); // Low, Medium, High, Urgent
            
            $table->string('source')->nullable(); // Page where it was submitted
            
            // Follow Up fields directly in table (to keep it minimal as requested)
            $table->text('follow_up_note')->nullable();
            $table->date('follow_up_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
