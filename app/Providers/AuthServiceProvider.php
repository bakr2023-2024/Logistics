<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('admin', function ($user) {
            return $user instanceof Admin;
        });
        Gate::define('customer', function ($user) {
            return $user instanceof Customer;
        });
        ResetPassword::createUrlUsing(function ($user, string $token) {
            if ($user instanceof Admin) {
                return URL::to("/admin/reset-password/$token?email=$user->email");
            } elseif ($user instanceof Customer) {
                return URL::to("/reset-password/$token?email=$user->email");
            }
        });
    }
}
