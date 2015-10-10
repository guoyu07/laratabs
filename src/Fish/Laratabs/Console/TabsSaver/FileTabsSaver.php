<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 10:18 AM
 */

namespace Fish\Laratabs\Console\TabsSaver;

use Fish\Laratabs\Tabs;

class FileTabsSaver extends Tabs implements TabsSaver {


    /**
     * updates the tabs in tabs.json
     * @return mixed
     */
    public function save($key, $parsed) {

        $tabs = file_exists($this->tabsPath())?$this->getTabsFile():[];
        $tabs[$key] = $parsed;

        $this->updateTabsFile($tabs);

        return $this->getTabsFile();

    }

    /**
     * @return mixed
     */
    private  function getTabsFile() {
       return json_decode(file_get_contents($this->tabsPath()), true);
    }

    /**
     * @param $tabs
     */
    private function updateTabsFile($tabs) {
        file_put_contents($this->tabsPath(),json_encode($tabs));
    }

    private function tabsPath() {
        return base_path() . '/tabs.json';
    }
}
