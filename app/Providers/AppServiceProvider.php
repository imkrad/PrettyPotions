<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StaffService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StaffService::class, function ($app) {
            return new StaffService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);

        \Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            if($value != null){
                $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
                if (in_array($type, $parameters)) {
                    return true;
                }
                return false;
            }
        });

        \Validator::extend('greater', function ($attribute, $value, $parameters, $validator) {
            $value = trim(str_replace(',','',$value),'₱ ');
            if($value != null){
                if ($value > 0 && $value <= $parameters[0]) {
                    return true;
                }
                return false;
            }
        }, 'Funds not enough');
    }
}
