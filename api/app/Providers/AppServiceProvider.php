<?php

namespace App\Providers;

use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Events\TaskAssigned;
use App\Listeners\LogActivity;
use App\Listeners\SendEntityNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(\App\Models\Organization::class, \App\Policies\OrganizationPolicy::class);
        Gate::policy(\App\Models\Project::class, \App\Policies\ProjectPolicy::class);
        Gate::policy(\App\Models\Task::class, \App\Policies\TaskPolicy::class);

        Event::listen(
            [
                EntityCreated::class,
                EntityUpdated::class,
                EntityDeleted::class,
            ],
            LogActivity::class
        );
    }
}
