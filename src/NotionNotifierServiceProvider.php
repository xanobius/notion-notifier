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

        $this->publishes([
            __DIR__ . '/../config/notion-notifier.php' => base_path('config/notion-notifier.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('notion-notifier',function () {
            return new LaravelNotionNotifier();
        });

        $this->mergeConfigFrom(__DIR__. '/../config/notion-notifier.php',
            'notion-notifier');
    }
}