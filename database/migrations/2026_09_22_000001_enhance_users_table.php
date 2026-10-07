<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('email'); // admin, reviewer, employee
            $table->string('department')->nullable()->after('role');
            $table->string('site')->nullable()->after('department');
            $table->string('phone')->nullable()->after('site');
            $table->string('job_title')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('job_title');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'department', 'site', 'phone', 'job_title', 'is_active', 'last_login_at']);
        });
    }
};
