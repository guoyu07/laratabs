<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 9:40 PM
 */

namespace Fish\LaravelTabs\HTML;

use Fish\LaravelTabs\Tabs;
use Fish\LaravelTabs\HTML\Exceptions\UndefinedKeyException;
use Fish\LaravelTabs\HTML\Exceptions\MissingTabTemplateException;
use Exception;

class TabBuilder extends Tabs {

    /**
     * @var array
     */
    public $tabs;

    /**
    * @var
     */
    protected $key;

    /**
     * @var array of variables to pass to the view
     */
    protected $data;


    /**
     * @return mixed
     */
    public function get($key, $data = []) {

        $this->key = $key;
        $this->data = $data;

        $file = $this->tabsFile();

        if (!file_exists($file)) throw new Exception("Can not find tabs.json in the path {$file}");

        $tabs = json_decode(file_get_contents($file),true);

        if (!isset($tabs[$key]))
            throw new UndefinedKeyException("undefined key '{$key}'");

        $this->tabs = $tabs[$key];

        if ($view = $this->missingView())
            throw new MissingTabTemplateException("The view {$view} for the key '{$key}' could not be found");

        $tabs = $this->convertTabsToPresenters($tabs[$key]);

        $this->tabs = $tabs;

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

           $parsed[$i]['tab'] = $this->app->make("Fish\\LaravelTabs\\HTML\\Presenter\\TabPresenter",
               [$this->key,$tab['tab']]);


           if (isset($tab['subtabs'])):
               foreach ($tab['subtabs'] as $subtab):
                   $parsed[$i]['subtabs'][] =  $this->app->make("Fish\\LaravelTabs\\HTML\\Presenter\\TabPresenter",
                   [$this->key,$subtab]);

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

        $viewsPath = $this->conf->get("tabs::views_path","{{KEY}}");
        $viewsPath = preg_replace("/{{KEY}}/i",$this->key,$viewsPath);

        $viewData =  ['folder' => $viewsPath,
            'tabs' => $this->tabs,
            'type' => $this->config('type', 'tabs'),
            'direction' => $this->config('direction', 'horizontal') == 'vertical'?"nav-stacked":"",
            'fade' => $this->config('fade',true,true)?"fade":""];
        $viewData = array_merge($viewData, $this->data);

        $html =  $this->app['view']->make('tabs::tabs',$viewData)
                                             ->render();
        return $html;

    }

}