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
        Schema::create('task_comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('task_id')->constrained()->cascadeOnDelete();
            $t->uuid('author_id');
            $t->text('body');
            $t->timestamps();
            $t->index(['task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_comments');
    }
};
