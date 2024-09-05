<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('categories.view',function($user){
            return true;
        });
        Gate::define('categories.create',function($user){
            return false;

        });
        Gate::define('categories.update',function($user){
            return true;
        });
        Gate::define('categories.delete',function(){
            return false;
        });
        Gate::define('products.view',function($user){
            return false;

        });
        Gate::define('orders.view',function($user){
            return false;

        });

    }
}
