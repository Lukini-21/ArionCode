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
        Schema::create('notifications', function (Blueprint $t) {
            $t->id();
            $t->uuid('user_id');
            $t->text('message');
            $t->enum('type', ['common', 'project', 'task', 'personal', 'organization']);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
            $t->index(['user_id','read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificationss');
    }
};
