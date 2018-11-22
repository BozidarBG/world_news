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
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {

        Schema::defaultStringLength(191);

        $categories=Cache::remember('categories', 1440, function(){
            return Category::orderBy('importance', 'asc')->get();
        });

        $sidebar_articles=Cache::remember('sidebar_articles', 15, function(){
            return Article::with('user','category', 'comments')->orderBy('hits', 'desc')->take(6)->get();
        });

        $fr_slider=Cache::remember('fr_slider', 15, function(){
           return Important::with('article.category', 'article.user')->get();
        });

        $aside_slider=Cache::remember('aside_slider', 15,function(){
            return Article::with('user.comments.replies', 'category')->where('category_id', 2)->orderBy('updated_at', 'desc')->take(4)->get();
        });

        $settings=Cache::remember('settings', 1440, function(){
            return Setting::first();
        });

        View::share('categories',$categories);
        View::share('sidebar_articles',$sidebar_articles);
        view::share('fr_slider', $fr_slider);
        View::share('asideslider', $aside_slider);
        View::share('settings', $settings);

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
