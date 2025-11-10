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
        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->boolean('is_public')->default(false);
            $t->enum('status', ['active', 'planning', 'completed', 'hold'])->default('active');
            $t->timestamp('starts_at')->nullable();
            $t->timestamp('ends_at')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['organization_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
