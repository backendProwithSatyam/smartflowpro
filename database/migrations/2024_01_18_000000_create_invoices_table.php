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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->string('invoice_subject');
            $table->string('invoice_number')->unique();
            $table->date('issued_date')->nullable();
            $table->enum('payment_due', ['upon_receipt', 'net_15', 'net_30', 'net_45', 'custom'])->default('net_30');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('salesperson')->nullable();
            $table->json('line_items')->nullable(); // Array of line items
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->unsignedBigInteger('tax_rate_id')->nullable();
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->text('client_message')->nullable();
            $table->text('contract_disclaimer')->nullable();
            $table->text('internal_notes')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('salesperson')->references('id')->on('users')->onDelete('set null');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
