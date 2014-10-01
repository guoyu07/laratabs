<?php

use Fish\LaravelTabs\Console\TabsSaver;
use Illuminate\Config\Repository as Config;
use \App;

class TabSaverTest extends TabsTester
{
   /**
    * @var \UnitTester
    */
    protected $tester;
    protected $saver;

    public function __construct() {

        $this->saver = new TabsSaver();
    }
    protected function _before()
    {

    }

    protected function _after()
    {
    }

    // tests

    /** @test */
    public function persist_the_tabs_to_a_file()
    {

        $this->saver->save('tabs',$this->data);

        $file = json_decode(file_get_contents(base_path()."/tabs.json"), true)['tabs'];

        $this->assertEquals($this->data, $file);

    }

}

