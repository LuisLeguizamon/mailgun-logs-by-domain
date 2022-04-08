<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('whereLike', function($key, $value) {
            return $this->where($key, 'LIKE', "%{$value}%");
        });

        Builder::macro('orWhereLike', function($key, $value) {
            return $this->orWhere($key, 'LIKE', "%{$value}%");
        });

        Builder::macro('whereBetweenDates', function($key, $from_value, $to_value) {
            return $this->whereDate($key, '>=', $from_value)
                        ->whereDate($key, '<=', $to_value);
        });
    }
}
