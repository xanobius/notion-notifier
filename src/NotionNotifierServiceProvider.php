<?php


namespace Xanobius\NotionNotifier;


use Illuminate\Support\ServiceProvider;
use Xanobius\NotionNotifier\Console\NotionNotifierVersion;

class NotionNotifierServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ( $this->app->runningInConsole() ) {
            $this->commands([
                NotionNotifierVersion::class
            ]);
        }
    }

    public function register()
    {
        $this->app->bind('notion-notifier',function () {
            return new LaravelNotionNotifier();
        });
    }
}