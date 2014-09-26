<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 10:31 PM
 */

namespace Fish\LaravelTabs\HTML;

use Fish\LaravelTabs\Tabs;

class TabPresenter extends Tabs {

    /**
     * @var string
     */
    protected $tab;

    /**
    * @var string
     */
    protected $key;

    /**
     * @param $tab
     * #@param $key
     */
    public function __construct($tab, $key) {

        $this->tab = $tab;
        $this->key = $key;

        $this->format = $this->config('display',"first_word_uc");
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
                    $title = $this->trans($pieces);
                    break;
            endswitch;

            if (!isset($title))
            $title = join(" ", $pieces);

        return $title;

    }


    /**
    * translate the tab name. fall back to ucfirst
     */
    private function trans($pieces) {

        // get default title
        $piecesTemp = $pieces;
        $piecesTemp[0] = ucfirst($pieces[0]);
        $title = join(" ", $piecesTemp);

        $localePath = "tabs.{$this->key}";

        $lookups = $this->getLookups($pieces);

        foreach ($lookups as $lookup):
            $handle = $localePath . "." . $lookup;
            $trans = trans($handle);

            if ($trans!=$handle) // no translation
                $title = $trans;
        endforeach;

    return $title;

    }

    /**
    * @param $pieces
     * @return array
     */
    private function getLookups($pieces) {
        $lookups = [join("-",$pieces),
                    join("_",$pieces)];

        $camelCase = $this->getCamelCase($pieces);

        $lookups = array_merge($lookups, $camelCase);

        return $lookups;
    }

    /**
    * @param $pieces
     * @return array
     */
    private function getCamelCase($pieces) {

        $ucArray = array_map("ucfirst", $pieces);

        $CamelCase = join("",$ucArray);

        $ucArray[0] = lcfirst($ucArray[0]);
        $camelCase = join("",$ucArray);

        return [$camelCase, $CamelCase];
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->tab;
    }

} 