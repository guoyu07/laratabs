<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 10:31 PM
 */

namespace Fish\LaravelTabs\HTML\Presenter;

use Fish\LaravelTabs\Tabs;
use Illuminate\Config\Repository as Config;
class TabPresenter extends Tabs {

    /**
    * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $tab;

    protected $app;

    /**
     * @param $tab
     * #@param $key
     */

    public function __construct($key ,$tab, Config $config) {
        $this->tab = $tab;
        $this->key = $key;
        parent::__construct($config);

    }

    /**
     * convert tab string to a readable title
     * @return string
     */
    public function toName() {

        $separator = $this->config('separator',"_");
        $format = $this->config('display',"first_word_uc");
        $pieces = explode($separator, $this->tab);

            switch ($format):
                case "uc_first_word":
                default:
                    $pieces[0] = ucfirst($pieces[0]);
                    break;
                case "uc_all_words":
                    $pieces = array_map("ucfirst",$pieces);
                    break;
                case "uc_no_words":
                    // do nothing
                    break;
                case "locale":
                    $translator = new Translator($this->key);
                    $title = $translator->trans($pieces);
                    break;
            endswitch;

            if (!isset($title))
            $title = join(" ", $pieces);

        return $title;

    }



    /**
     * @return string
     */
    public function __toString() {
        return $this->tab;
    }

} 