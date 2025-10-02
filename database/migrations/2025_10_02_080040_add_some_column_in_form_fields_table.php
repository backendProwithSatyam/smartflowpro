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
        Schema::table('form_fields', function (Blueprint $table) {
            $table->string('current_page_name')->after('label_name')->nullable();
            $table->boolean('transferrable')->after('options')->default(false);
            $table->string('default_value')->after('transferrable')->nullable();
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropColumn(['current_page_name', 'transferrable', 'default_value', 'user_id']);
        });
    }
};
