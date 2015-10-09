<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/24/14
 * Time: 10:18 AM
 */

namespace Fish\LaravelTabs\Console\TabsSaver;

use Fish\LaravelTabs\Console\TabsSaver;
use Fish\LaravelTabs\Console\Exceptions\NoTablesFoundException;
use Fish\LaravelTabs\Tabs;
use Fish\LaravelTabs\Models\Key;
use Fish\LaravelTabs\Models\Tab;
use Fish\LaravelTabs\Models\Subtab;
use Schema;

class DatabaseTabsSaver extends Tabs implements TabsSaver {


    /**
     * updates the tabs in DB tables
     * @return mixed
     */
    public function save($key, $data) {

        if (!$this->tablesExist()) {
            throw new NoTablesFoundException("please run 'php artisan tabs:init' first");
        }

        $key = $this->generateKey($key);
        $keyTabs = $key->tabs();

        foreach ($data as $tabs):

            $tab = new Tab(['name'=>$tabs['tab']]);
            $mainTab = $keyTabs->save($tab);

            if (isset($tabs['subtabs'])):

            foreach ($tabs['subtabs'] as $msubtab):
                $subtab = new Subtab(['name'=>$msubtab]);
                $mainTab->subtabs()->save($subtab);
            endforeach;
            endif;

        endforeach;

        return true;

    }

    private function generateKey($key) {

        $keyData = Key::where('key',$key)->first();

        if ($keyData) $keyData->delete();

            $keyData = new Key;
            $keyData->key = $key;
            $keyData->save();

        return $keyData;

    }

private function tablesExist() {
    return Schema::hasTable('mfet_keys') &&
           Schema::hasTable('mfet_keys') &&
           Schema::hasTable('mfet_keys');
}


}


