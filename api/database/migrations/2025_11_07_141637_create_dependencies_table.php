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
        Schema::create('task_dependencies', function (Blueprint $t) {
            $t->id();
            $t->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $t->foreignId('depends_on_task_id')->constrained('tasks')->cascadeOnDelete();
            $t->timestamps();
            $t->unique(['task_id','depends_on_task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencies');
    }
};
