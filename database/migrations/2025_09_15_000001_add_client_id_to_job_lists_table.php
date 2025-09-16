<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('job_lists', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('user_id');
                $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_lists', function (Blueprint $table) {
            if (Schema::hasColumn('job_lists', 'client_id')) {
                $table->dropForeign(['client_id']);
                $table->dropColumn('client_id');
            }
        });
    }
};


