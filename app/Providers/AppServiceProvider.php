<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Topic;
use App\Observers\TopicObserver;
use App\Models\Reply;
use App\Observers\ReplyObserver;
use App\Models\Link;
use App\Observers\LinkObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
    }
}
