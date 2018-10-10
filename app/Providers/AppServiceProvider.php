<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use App\Category;
use App\Article;
use App\Setting;
use Auth;
use App\Important;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        //
        //dd(Important::all()->toArray());
        Schema::defaultStringLength(191);
        View::share('categories',Category::orderBy('importance', 'asc')->get());
        View::share('sidebar_articles',Article::orderBy('hits', 'desc')->take(6)->get());
        view::share('fr_slider', Important::all());
        View::share('asideslider', Article::where('category_id', 2)->orderBy('updated_at', 'desc')->take(4)->get());
        View::share('settings', Setting::first());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
