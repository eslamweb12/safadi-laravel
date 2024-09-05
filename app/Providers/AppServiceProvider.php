<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepository::class, CartModelRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale(request('locale','en'));
        // Validator::extend('filter',function($attribute,$value,$params){
        //    return in_array(strtolower($value),$params);
        // },'this is value prohited');
        Paginator::useBootstrapFour();
    //   Paginator::defaultView('pagination.custom');
    }
}
