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
        Schema::create('organization_users', function (Blueprint $t) {
            $t->id();
            $t->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $t->uuid('user_id');
            $t->enum('role', ['member','manager','admin'])->default('member');
            $t->timestamps();
            $t->unique(['organization_id','user_id']);
            $t->index(['organization_id','role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_users');
    }
};
