<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 12:25 PM
 */

namespace Fish\LaravelTabs;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Application as App;

abstract class Tabs {

   /**
    * @var Config
    */
    protected $conf;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct() {
        $this->app = new App;
    }

    /**
     * converts the nested associative array of name to a simple index array
     * @param $tabs
     * @param $includeMain
     * @return array
     */
    protected function convertTabNamesToSimpleArray($tabs, $includeMain = false) {

        $parsed = [];

        foreach ($tabs as $tab):
           if ((!isset($tab['subtabs'])) || ($includeMain)):
            $parsed[] = $tab['tab'];
          endif;
          if (isset($tab['subtabs'])):
            $arr = array_values($tab['subtabs']);
            $parsed = array_merge($parsed, $arr);
          endif;

        endforeach;

        return $parsed;

    }

    /**
    * @param $key
    * @return string
     */
    protected function getViewsPath($key) {

        $viewsPath = $this->getLaravelVersion()==5? base_path()."/resources/views/": base_path(). "/app/views/";
        $path = Config::get("tabs::views_path","{{KEY}}");

        $path = $viewsPath . preg_replace("/{{KEY}}/i",$key, $path);

        return $path;
    }

    /**
    * @param $key
    * @param $default
     * @return mixed
     */
    protected function config($key, $default, $options = []) {

        $allowed = ['direction'=>['horizontal','vertical'],
                    'type'=>['tabs','pills'],
                    'fade'=>[true,false]];

        if (isset($options[$key]) && !in_array($options[$key],$allowed[$key]))
            return $default;

        $conf = isset($options[$key])?$options[$key]:Config::get("tabs::{$key}", $default);

        return $conf;

    }

    private function getLaravelVersion() {
        return substr(App::VERSION,0,1);
    }

    /**
     * recursively make directory
    * @param $path
     */
    protected function recursiveMkdir($path) {

        $path = explode("/",$path);

        $viewsIndex = array_search("views",$path);

        for ($i=$viewsIndex+1; $i<count($path); $i++):
            $folder = implode("/",array_slice($path,0,$i+1));

            if (!is_dir($folder)):
                mkdir($folder);
            endif;
        endfor;

        return true;
    }

    /**
     * get tabs file path
    * @return string
     */
    public function tabsFile() {

        $file =  base_path() . "/tabs.json";

        return $file;

    }

} 