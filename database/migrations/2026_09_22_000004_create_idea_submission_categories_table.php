<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idea_submission_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_submission_id')->constrained('idea_submissions')->cascadeOnDelete();
            $table->foreignId('idea_category_id')->constrained('idea_categories')->cascadeOnDelete();
            $table->string('custom_value')->nullable(); // For "Other" category
            $table->timestamps();

            $table->unique(['idea_submission_id', 'idea_category_id'], 'idea_sub_cat_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idea_submission_categories');
    }
};
