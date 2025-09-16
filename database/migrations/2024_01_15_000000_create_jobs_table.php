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
        Schema::create('job_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->string('title')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('job_number')->nullable();
            $table->string('salesperson')->nullable();
            $table->enum('job_type', ['one-off', 'recurring'])->default('one-off');
            $table->date('schedule_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('schedule_later')->default(false);
            $table->boolean('anytime')->default(false);
            $table->string('repeats')->nullable();
            $table->string('repeat_end_type')->nullable();
            $table->integer('repeat_end_after_number')->nullable();
            $table->string('repeat_end_after_period')->nullable();
            $table->date('repeat_end_on_date')->nullable();
            $table->text('visit_instructions')->nullable();
            $table->boolean('email_team')->default(false);
            $table->boolean('send_invoice')->default(true);
            $table->json('product_items')->nullable();
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_lists');
    }
};
