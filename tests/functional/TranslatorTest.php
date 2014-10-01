<?php

use Fish\LaravelTabs\HTML\Presenter\Translator;

class TranslatorTest extends \Codeception\TestCase\Test
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /** @test */
    public function translate_tabs()
    {
        $translator = new Translator('tabs');
        $trans = $translator->trans(['tab','number','one']);
        $this->assertEquals("snake case",$trans);

        $trans = $translator->trans(['tab','number','two']);
        $this->assertEquals("dash",$trans);

        $trans = $translator->trans(['tab','number','three']);
        $this->assertEquals("camel case",$trans);

        $trans = $translator->trans(['tab','number','four']);
        $this->assertEquals("camel case - including first word",$trans);
    }

}
