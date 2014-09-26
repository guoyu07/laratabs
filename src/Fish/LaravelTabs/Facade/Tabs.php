<?php namespace Fish\LaravelTabs\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\View\Compilers\BladeCompiler
 */
class Tabs extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tabs';
    }

}
