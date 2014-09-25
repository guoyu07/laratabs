<?php
namespace Fish\Tabs;

use Fish\Tabs\HTML\TabBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use \Artisan;

class TabsServiceProvider extends ServiceProvider {

    /**
     * boot up the service provicer
     */
    public function boot() {
        // register package
        $this->package('fish/laravel-tabs','tabs');

        // bind artisan command to the IoC container
        $this->app->bind('fish::command.tabs', function() {
            return $this->app->make('Fish\Tabs\Console\Command\GenerateTabsCommand');
        });

        $this->commands(array(
            'fish::command.tabs'
        ));

        // Generate alias for the Tabs facade
        AliasLoader::getInstance()->alias('Tabs','Fish\Tabs\Facade\Tabs');
    }

    /**
     * register the binding in the IoC container
     */
    public function register()
    {
        $this->app->bind('tabs', function () {

        return new TabBuilder();
        });
    }
}