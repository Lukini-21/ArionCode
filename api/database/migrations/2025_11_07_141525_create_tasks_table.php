<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('description')->nullable();
            $t->enum('status', ['todo', 'in_progress', 'done', 'backlog', 'review', 'blocked'])->default('todo');
            $t->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $t->dateTimeTz('due_at')->nullable();
            $t->uuid('assignee_id')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['project_id', 'status']);
            $t->index(['project_id', 'priority']);
            $t->index(['assignee_id']);
            $t->index(['due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
