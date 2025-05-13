<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        Model::shouldBeStrict($this->app->isLocal());
        Model::unguard();

        Gate::define('belongs-to-user', function (User $authUser, $model) {
            return $authUser->id === $model->user_id
                ? Response::allow()
                : Response::denyAsNotFound();
        });
    }
}
