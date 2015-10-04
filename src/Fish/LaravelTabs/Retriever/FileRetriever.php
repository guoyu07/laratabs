<?php

namespace Fish\LaravelTabs\Retriever;
/**
* Retrieve tabs from File file
*/

use Exception;

class FileRetriever implements Retriever
{

    /**
     * @return mixed
     */
    public function retrieve($key) {

        $file = $this->filePath();
        $tabs = json_decode(file_get_contents($file),true);

        return isset($tabs[$key])?$tabs[$key]:false;
    }


    public function getKeys($key = null) {
        $file = $this->filePath();
        $tabs = json_decode(file_get_contents($file),true);

        if ($key && isset($tabs[$key]))
          return [$key];

        if (!$key)
        return array_keys($tabs);

        return false;
    }

    private function filePath() {

        $file =  base_path() . "/tabs.json";;

        if (!file_exists($file)) throw new Exception("Can not find tabs.json in the path {$file}");

        return $file;
    }
}
