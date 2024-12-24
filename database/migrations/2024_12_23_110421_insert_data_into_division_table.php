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
        DB::statement("INSERT INTO `division` (`name`, `created_at`, `updated_at`)
        VALUES 
        ('Colombo 1', NOW(), NOW()),
        ('Colombo 2', NOW(), NOW()),
        ('Colombo 3', NOW(), NOW())
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
