<?php

use Fish\Laratabs\Console\FieldsParser;
use Fish\Laratabs\Console\Exceptions\InvalidFormatException;
class FieldsParserTest extends TabsTester
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;

    /**
     * @var FieldsParser
     */
    protected $parse;

    /**
     * instatiate fields parser
     */
    public function __construct() {
        $this->parse = new FieldsParser();
        parent::__construct();
    }


    /** @test */
    public function parse_fields_into_an_array()
    {
        $parsed = $this->parse->parse("tab1,tab2,tab3:subtab1|subtab2,tab4");
        $this->assertEquals($this->data['tabs'], $parsed);
    }

    /** @test
     *  @expectedException Fish\Laratabs\Console\Exceptions\InvalidFormatException
     */
    public function throw_an_exception_when_invalid_tabs_are_entered() {
         $this->parse->parse('firstTab:secondTab:thirdTab|foruthTab,fifthTab');

    }

    /** @test
     *  @expectedException Fish\Laratabs\Console\Exceptions\InvalidFormatException
     */
    public function throw_an_exception_when_invalid_subtabs_are_entered() {
        $this->parse->parse('firstTab, secondTab,thirdTab:foruthTab||ad,fifthTab');
    }

}

