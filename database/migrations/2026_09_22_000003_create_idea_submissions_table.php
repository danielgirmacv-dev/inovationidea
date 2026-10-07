<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idea_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique(); // EEC-IDEA-2026-00001
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_reviewer_id')->nullable()->constrained('users')->nullOnDelete();

            // Contact Information (Step 1)
            $table->string('submitter_name');
            $table->string('submitter_job_title')->nullable();
            $table->string('submitter_department')->nullable();
            $table->string('submitter_site')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_phone');

            // Innovative Idea Description (Step 2)
            $table->string('title');
            $table->text('description');
            $table->text('problem_addressed');
            $table->text('company_benefits');
            $table->text('risks_challenges');
            $table->json('supporting_links')->nullable(); // array of links
            $table->date('submission_date');

            // Workflow
            $table->enum('status', [
                'Submitted',
                'Under Review',
                'Need More Information',
                'Approved',
                'Rejected',
                'Implemented',
            ])->default('Submitted');

            // Admin / Review Notes
            $table->text('rejection_reason')->nullable();
            $table->text('approval_notes')->nullable();
            $table->text('reviewer_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('submitter_department');
            $table->index('submitter_site');
            $table->index('submission_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idea_submissions');
    }
};
