<?php
namespace Fish\LaravelTabs;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use \Artisan;
use Config;

class LaravelTabsServiceProvider extends ServiceProvider {

    /**
     * boot up the service provicer
     */
    public function boot() {

        // bind artisan command to the IoC container
        $this->app->bind('fish::command.tabs', function() {
            return $this->app->make('Fish\LaravelTabs\Console\Command\GenerateTabsCommand');
        });

             // bind artisan command to the IoC container
        $this->app->bind('fish::command.list', function() {
            return $this->app->make('Fish\LaravelTabs\Console\Command\ListTabsCommand');
        });

           $this->app->bind('fish::command.init', function() {
            return $this->app->make('Fish\LaravelTabs\Console\Command\BuildDatabaseTablesCommand');
        });

            $this->app->bind('fish::command.destroy', function() {
            return $this->app->make('Fish\LaravelTabs\Console\Command\DropDatabaseTablesCommand');
        });

        $this->commands(array(
            'fish::command.tabs',
            'fish::command.list',
            'fish::command.init',
            'fish::command.destroy'
        ));

        // Generate alias for the Tabs facade
        AliasLoader::getInstance()->alias('Tabs','Fish\LaravelTabs\Facade\Tabs');


    }

    /**
     * register the binding in the IoC container
     */
    public function register()
    {

        // register package
        $this->package('fish/laravel-tabs','tabs');

        $storage = $this->getStorage();

        $this->app->bind('tabs', function () {

        return $this->app->make("Fish\\LaravelTabs\\HTML\\TabBuilder");
        });

        $this->app->bind('Fish\\LaravelTabs\\Console\\TabsSaver\\TabsSaver', function() use ($storage){

            return $this->app->make("Fish\\LaravelTabs\\Console\\TabsSaver\\{$storage}TabsSaver");
        });

        $this->app->bind('Fish\LaravelTabs\Retriever\Retriever',function() use ($storage) {

            return $this->app->make("Fish\\LaravelTabs\\Retriever\\{$storage}Retriever");
        });


    }

    private function getStorage() {

         $storage = Config::get("laratabs.storage");

         return (strtolower($storage)=='file')?ucfirst($storage):'Database';


    }
}
