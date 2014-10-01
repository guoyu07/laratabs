<?php

use Fish\LaravelTabs\HTML\Presenter\TabPresenter;

class TabPresenterTest extends \Codeception\TestCase\Test
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;


    /** @test */
    public function present_a_pretty_tab_name() {
        $presenter = new TabPresenter('tabs','some_tab_to_present');
        $pretty = $presenter->toName();
        $this->assertEquals("Some tab to present",$pretty);
    }


}