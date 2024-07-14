<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('title');
            $table->timestamps();

            $table->index('uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
