<?php
namespace Codeception\Module;

use Faker\Factory;
use Illuminate\Foundation\Application as App;


// here you can define custom actions
// all public methods declared in helper class will be available in $I

class AcceptanceHelper extends \Codeception\Module
{

    public function chooseRandomKey() {
        $faker = Factory::create();
        return $faker->word;
    }

    public function generateRandomTabs() {

        $faker = Factory::create();
        $numTabs = rand(2,6);
        $tabs = [];

        for ($i=0; $i<$numTabs;$i++):
            $tabs[] = $faker->word;
        endfor;

        return $tabs;
    }

    public function removeTheViews($key) {
        $dir = __DIR__ . "/../../../../../app/views/" . $key;
        rrmdir($dir);
    }

}