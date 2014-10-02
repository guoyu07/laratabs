<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 9:40 PM
 */

namespace Fish\LaravelTabs\HTML;
use Illuminate\Support\Facades\Config;
use Fish\LaravelTabs\Tabs;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Application as App;
use Fish\LaravelTabs\HTML\Exceptions\UndefinedKeyException;
use Fish\LaravelTabs\HTML\Exceptions\MissingTabTemplateException;
use Exception;
use Fish\LaravelTabs\HTML\Presenter\TabPresenter;



class TabBuilder extends Tabs {

    /**
     * @var array associative array of tabs and subtabs
     */
    public $tabs;

    /**
    * @var array of tab presenter objects
     */
    public $tabsPresenters;

    /**
    * @var
     */
    protected $key;

    /**
     * @var array of variables to pass to the view
     */
    protected $data;

    /**
    * @var array of options (allows overriding the global config)
     */
    protected $options;

   /**
    * @var \Illuminate\View\Factory
    */
    protected $view;

    /**
    * @var
     */
    protected $config;

    /**
    * @var \Illuminate\Foundation\Application
     */
    protected $app;


    /**
     * @return mixed
     */
    public function get($key, $data = [], $options = []) {

        $this->key = $key;
        $this->data = $data;
        $this->options = $options;

        $file = $this->tabsFile();

        if (!file_exists($file)) throw new Exception("Can not find tabs.json in the path {$file}");

        $tabs = json_decode(file_get_contents($file),true);

        if (!isset($tabs[$key]))
            throw new UndefinedKeyException("undefined key '{$key}'");

        $this->tabs = $tabs[$key];

        if ($view = $this->missingView())
            throw new MissingTabTemplateException("The view {$view} for the key '{$key}' could not be found");

        $this->tabsPresenters =  $this->convertTabsToPresenters($tabs[$key]);

        return $this;
    }

    /**
    * @param $tabs
     * @return array
     */
    private function convertTabsToPresenters($tabs) {

        $parsed = [];
        $i=0;

       foreach ($tabs as $tab):

           $parsed[$i]['tab'] = new TabPresenter($this->key,$tab['tab']);

           if (isset($tab['subtabs'])):
               foreach ($tab['subtabs'] as $subtab):

                   $parsed[$i]['subtabs'][] = new TabPresenter($this->key,$subtab);

               endforeach;
           endif;
           $i++;
        endforeach;


       return $parsed;
    }

    private function missingView() {

        $tabs = $this->convertTabNamesToSimpleArray($this->tabs);

        $missing = false;

        $path = $this->getViewsPath($this->key);

        foreach ($tabs as $name):
            $file = "{$name}.blade.php";
            if (!file_exists("{$path}/{$file}"))
                $missing = $file;
        endforeach;

        return $missing;

    }

    /**
     * @return mixed
     */
    public function __toString() {

        $viewsPath = Config::get("tabs::views_path","{{KEY}}");
        $viewsPath = preg_replace("/{{KEY}}/i",$this->key,$viewsPath);

        $tabs = $this->convertTabNamesToSimpleArray($this->tabs, true);

        $viewData =  ['folder' => $viewsPath,
            'tabs' => $this->tabsPresenters,
            'type' => $this->config('type', 'tabs', $this->options),
            'direction' => $this->config('direction', 'horizontal',  $this->options) == 'vertical'?"nav-stacked":"",
            'fade' => $this->config('fade',true,$this->options)?"fade":""];

        if (is_array($this->data))
        $viewData = array_merge($viewData, $this->data);

        if (isset($this->options['except']) or isset($this->options['only'])):
            $only = isset($this->options['only'])?
                   $this->options['only']:
                   array_diff($tabs, $this->options['except']);

            $viewData = array_merge($viewData, ['only'=>$only]);
        endif;

        $html =  View::make('tabs::tabs',$viewData)->render();

        return $html;

    }

}