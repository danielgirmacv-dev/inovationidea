<?php

namespace App\Providers;

use App\Models\IdeaSubmission;
use App\Policies\IdeaSubmissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register policy
        Gate::policy(IdeaSubmission::class, IdeaSubmissionPolicy::class);

        // Extra gate for export (no model instance needed)
        Gate::define('export-submissions', function ($user) {
            return $user->isAdmin();
        });

        // Super-admin gate bypass
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
