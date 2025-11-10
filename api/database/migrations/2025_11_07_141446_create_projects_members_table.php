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
        Schema::create('project_members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->constrained()->cascadeOnDelete();
            $t->uuid('user_id');
            $t->enum('role', ['member','manager'])->default('member');
            $t->timestamps();
            $t->unique(['project_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_members');
    }
};
