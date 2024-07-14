<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('task_status_uuid');
            $table->timestamp('deadline_at')->nullable();
            $table->timestamps();

            $table->index('deadline_at');
            $table->index('task_status_uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
