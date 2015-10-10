<?php
namespace Fish\Laratabs;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use \Artisan;
use Config;
use View;

class LaratabsServiceProvider extends ServiceProvider {

    /**
     * boot up the service provicer
     */
    public function boot() {

            $this->publishes([
        __DIR__.'/../../config/config.php' => config_path('laratabs.php'),
    ]);

        // bind artisan command to the IoC container
        $this->app->bind('fish::command.tabs', function() {
            return $this->app->make('Fish\Laratabs\Console\Command\GenerateTabsCommand');
        });

             // bind artisan command to the IoC container
        $this->app->bind('fish::command.list', function() {
            return $this->app->make('Fish\Laratabs\Console\Command\ListTabsCommand');
        });

           $this->app->bind('fish::command.init', function() {
            return $this->app->make('Fish\Laratabs\Console\Command\BuildDatabaseTablesCommand');
        });

            $this->app->bind('fish::command.destroy', function() {
            return $this->app->make('Fish\Laratabs\Console\Command\DropDatabaseTablesCommand');
        });

        $this->commands(array(
            'fish::command.tabs',
            'fish::command.list',
            'fish::command.init',
            'fish::command.destroy'
        ));

        // Generate alias for the Tabs facade
        AliasLoader::getInstance()->alias('Tabs','Fish\Laratabs\Facade\Tabs');


    }

    /**
     * register the binding in the IoC container
     */
    public function register()
    {

        // register package

        View::addNamespace('laratabs', __DIR__.'/../../views');


        $storage = $this->getStorage();

        $this->app->bind('tabs', function () {

        return $this->app->make("Fish\\Laratabs\\HTML\\TabBuilder");
        });

        $this->app->bind('Fish\\Laratabs\\Console\\TabsSaver\\TabsSaver', function() use ($storage){

            return $this->app->make("Fish\\Laratabs\\Console\\TabsSaver\\{$storage}TabsSaver");
        });

        $this->app->bind('Fish\Laratabs\Retriever\Retriever',function() use ($storage) {

            return $this->app->make("Fish\\Laratabs\\Retriever\\{$storage}Retriever");
        });


    }

    private function getStorage() {

         $storage = Config::get("laratabs.storage");

         return (strtolower($storage)=='file')?ucfirst($storage):'Database';


    }
}
