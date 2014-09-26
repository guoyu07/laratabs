<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 11:15 AM
 */

namespace Fish\LaravelTabs\Console;

use Fish\LaravelTabs\Tabs;

class ViewsGenerator extends Tabs {

    /**
     * @var
     */
    protected $key;
    /**
     * @var
     */
    protected $tabs;

    /**
     * @param $key
     * @param array $tabs
     */
    public function __construct($key, Array $tabs) {
        $this->key = $key;
        $this->tabs = $tabs;
    }

    public function generate() {

        $success = [];

        $tabs = $this->convertTabNamesToSimpleArray();
        $path = $this->getViewsPath($this->key);

        if (!is_dir($path)) {
            $this->recursiveMkdir($path);
        }

        foreach ($tabs as $tab):
            $fileName= "$tab.blade.php";
            $fullPath = "{$path}/{$fileName}";
            if (!file_exists($fullPath)):
            $success[] = file_put_contents($fullPath,$fileName);
            endif;
        endforeach;

     return !in_array(false, $success);

    }



} 