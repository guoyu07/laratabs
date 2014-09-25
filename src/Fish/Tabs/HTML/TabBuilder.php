<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 9:40 PM
 */

namespace Fish\Tabs\HTML;

use Fish\Tabs\Tabs;
use Fish\Tabs\HTML\Exceptions\UndefinedKeyException;
use Fish\Tabs\HTML\Exceptions\MissingTabTemplateException;
use \View;
use \Config;
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
     * @return mixed
     */
    public function get($key) {

        $this->key = $key;

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

           $parsed[$i]['tab'] = new TabPresenter($tab['tab']);

           if (isset($tab['subtabs'])):
               foreach ($tab['subtabs'] as $subtab):
                   $parsed[$i]['subtabs'][] = new TabPresenter($subtab);
               endforeach;
           endif;
           $i++;
        endforeach;

       return $parsed;
    }

    private function missingView() {

        $tabs = $this->convertTabNamesToSimpleArray();

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

        $html =  View::make('tabs::tabs', ['folder' => $this->key,
                                            'tabs' => $this->tabs,
                                            'type' => $this->config('type', 'tabs'),
                                            'direction' => $this->config('direction', 'horizontal') == 'vertical'?"nav-stacked":"",
                                            'fade' => $this->config('fade',true,true)?"fade":""])
                                             ->render();
        $html = htmlentities($html);
        return $html;

    }

}