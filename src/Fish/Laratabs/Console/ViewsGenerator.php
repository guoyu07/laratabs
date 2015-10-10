<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 11:15 AM
 */

namespace Fish\Laratabs\Console;

use Fish\Laratabs\Tabs;

class ViewsGenerator extends Tabs {


    public function generate($key, $tabs) {

        $success = [];

        $tabs = $this->convertTabNamesToSimpleArray($tabs);
        $path = $this->getViewsPath($key);

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
