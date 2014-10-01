<?php
use Fish\LaravelTabs\Console\ViewsGenerator;

class ViewGeneratorTest extends TabsTester
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;

    /**
     * @var
     */
    protected $generator;

    /**
     * @var
     */
    protected $dir;

    /**
     * initialize the variables
     */
    public function __construct() {

        $this->generator = new ViewsGenerator();
        $this->dir = app_path() ."/views/tabs";
        parent::__construct();
    }

    protected function _before()
    {
        if (is_dir($this->dir))
         rrmdir($this->dir);
    }


    /** @test */
    public function generate_views()
    {

       $this->generator->generate('tabs', $this->data['tabs']);

       $this->assertTrue(is_dir($this->dir));
       $this->assertTrue(file_exists($this->dir . "/tab1.blade.php"));


    }



}