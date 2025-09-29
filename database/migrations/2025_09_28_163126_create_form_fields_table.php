<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_xx_xx_create_form_fields_table.php
public function up()
{
    Schema::create('form_fields', function (Blueprint $table) {
        $table->id();
        $table->string('label_name');
        $table->string('field_type'); // text, select, checkbox, radio
        $table->text('options')->nullable(); // store comma separated options
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
