<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 10:18 AM
 */

namespace Fish\LaravelTabs\Console;

use Fish\LaravelTabs\Tabs;

class TabsSaver extends Tabs {


    /**
     * updates the tabs in tabs.json
     * @return mixed
     */
    public function save($key, $parsed) {

        $tabs = file_exists($this->tabsFile())?$this->getTabsFile():[];
        $tabs[$key] = $parsed;

        $this->updateTabsFile($tabs);

        return $this->getTabsFile();

    }

    /**
     * @return mixed
     */
    private  function getTabsFile() {
       return json_decode(file_get_contents($this->tabsFile()), true);
    }

    /**
     * @param $tabs
     */
    private function updateTabsFile($tabs) {
        file_put_contents($this->tabsFile(),json_encode($tabs));
    }
} 