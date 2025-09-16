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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->string('title');
            $table->text('service_details')->nullable();
            $table->date('preferred_date_1')->nullable();
            $table->date('preferred_date_2')->nullable();
            $table->json('preferred_times')->nullable(); // ['anytime', 'morning', 'afternoon', 'evening']
            $table->boolean('onsite_assessment')->default(false);
            $table->text('onsite_instructions')->nullable();
            $table->boolean('onsite_schedule_later')->default(false);
            $table->boolean('onsite_anytime')->default(false);
            $table->date('onsite_date')->nullable();
            $table->time('onsite_time')->nullable();
            $table->time('onsite_start_time')->nullable();
            $table->time('onsite_end_time')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
