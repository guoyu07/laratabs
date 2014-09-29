<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 12:25 PM
 */

namespace Fish\LaravelTabs;

use Illuminate\Support\Facades\Config;

abstract class Tabs {

   /**
    * @var Config
    */
    protected $conf;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;



    /**
     * converts the nested associative array of name to a simple index array
     * @return array
     */
    protected function convertTabNamesToSimpleArray($tabs) {

        $parsed = [];

        foreach ($tabs as $tab):
           if (!isset($tab['subtabs'])):
            $parsed[] = $tab['tab'];
          else:
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

        $viewsPath = Config::get("tabs::laravel_version",4)==5? base_path()."/resources/views/": base_path(). "/app/views/";
        $path = COnfig::get("tabs::views_path","{{KEY}}");

        $path = $viewsPath . preg_replace("/{{KEY}}/i",$key, $path);

        return $path;
    }

    /**
    * @param $key
    * @param $default
     * @return mixed
     */
    protected function config($key,$default, $bool = false) {

        $conf = Config::get("tabs::{$key}");

        return ($conf || (!$conf && $bool))?$conf:$default;

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