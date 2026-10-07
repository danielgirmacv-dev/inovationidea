<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idea_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_submission_id')->constrained('idea_submissions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment');
            $table->boolean('is_internal')->default(false); // Internal = admin only; false = visible to submitter
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idea_comments');
    }
};
