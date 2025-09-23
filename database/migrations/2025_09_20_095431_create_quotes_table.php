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
         Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->string('title')->nullable();
            $table->string('quote_number')->unique();
            $table->decimal('rate_opportunity', 10, 2)->nullable();
            $table->string('salesperson')->nullable();

            $table->json('line_items')->nullable(); // product/service details

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();

            $table->unsignedBigInteger('tax_rate_id')->nullable();
            $table->decimal('tax_amount', 10, 2)->default(0);

            $table->decimal('required_deposit', 10, 2)->nullable();
            $table->enum('deposit_type', ['fixed', 'percent'])->nullable();

            $table->decimal('total', 10, 2)->default(0);

            $table->text('client_message')->nullable();
            $table->text('contract_disclaimer')->nullable();
            $table->text('internal_notes')->nullable();

            $table->json('attachments')->nullable();

            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected'])->default('draft');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
