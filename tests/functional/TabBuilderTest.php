<?php

use Fish\Laratabs\HTML\TabBuilder;
class TabBuilderTest extends TabsTester
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;

    /**
     * @var
     */
    protected $builder;

    /**
     * instatiate the class under test
     */
    public function __construct() {

        $this->builder = new TabBuilder();
        parent::__construct();
    }

    protected function _before()
    {
        file_put_contents(base_path() . "/tabs.json",json_encode($this->data));

    }

    protected function _after()
    {
        file_put_contents(base_path() . "/tabs.json","");

    }

    /**
     * @test
     */
    public function generate_tabs_html()
    {

        $obj = $this->builder->get('tabs');
        $actualHtml = $obj->__toString();
        $expectedHtml = file_get_contents(__DIR__ ."/../_support/templates/tabs.txt");

        $actualHtml = preg_replace('/\s+/', '', $actualHtml);

        $this->assertEquals($expectedHtml, $actualHtml);

    }

    /**
     * @test
     */
    public function pass_variables_to_the_tabs() {

        file_put_contents(app_path() . "/views/tabs/tab1.blade.php","{{\$var}}");

        $obj = $this->builder->get('tabs',['var'=>'someTestVar'])->__toString();

        file_put_contents(app_path() . "/views/tabs/tab1.blade.php","tab1.blade.php");

        $this->assertTrue(strpos($obj,'someTestVar')!==false);

    }

    /**
     * @test
     */

    public function override_default_configuration() {

        $options = ['fade'=>false,
                    'direction'=>'vertical',
                    'type'=>'pills'];

        $obj = $this->builder->get('tabs',[],$options)->__toString();

        $this->assertTrue(strpos($obj,'fade')===false);
        $this->assertTrue(strpos($obj,'nav-pills')!==false);
        $this->assertTrue(strpos($obj,'nav-stacked')!==false);

        $obj = $this->builder->get('tabs')->__toString();

        $this->assertTrue(strpos($obj,'fade')!==false);
        $this->assertTrue(strpos($obj,'nav-pills')===false);
        $this->assertTrue(strpos($obj,'nav-stacked')===false);

    }


    /**
     *  @test
     *  @expectedException Fish\Laratabs\HTML\Exceptions\UndefinedKeyException
     */
    public function throw_an_exception_when_the_key_does_not_exist() {
       $this->builder->get('not-existant-key');
    }

    /**
     *  @test
     *  @expectedException Fish\Laratabs\HTML\Exceptions\MissingTabTemplateException
     */
    public function throw_an_exception_when_view_can_not_be_found() {
        $view = app_path()."/views/tabs/tab1.blade.php";
        unlink($view);
        $this->builder->get('tabs');
        file_put_contents($view, 'tab1.blade.php');
    }

    /**
     * @test
     */
    public function generate_tabs_except_for_the_excluded_ones() {

        $view = app_path()."/views/tabs/tab1.blade.php";
        file_put_contents($view, 'tab1.blade.php');
        $tabs = $this->builder->get('tabs',[],['except'=>['tab1','tab4']]);

        $html = $tabs->__toString();

        $includesTabs = strpos($html,'Tab2')!==false;
        $doesntIncludeTabs = strpos($html,'Tab4')===false;

        $this->assertTrue($doesntIncludeTabs);
        $this->assertTrue($includesTabs);
    }

    /**
     * @test
     */
    public function generate_only_included_tabs() {

        $view = app_path()."/views/tabs/tab1.blade.php";
        file_put_contents($view, 'tab1.blade.php');

        $tabs = $this->builder->get('tabs',[],['only'=>['tab4','tab3']]);

        $html = $tabs->__toString();

        $includesTabs = strpos($html,'Tab4')!==false;
        $doesntIncludeTabs = strpos($html,'Tab1')===false;

        $this->assertTrue($includesTabs);
        $this->assertTrue($doesntIncludeTabs);

    }

}
