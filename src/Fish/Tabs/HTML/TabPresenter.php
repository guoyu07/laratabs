<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/23/14
 * Time: 10:31 PM
 */

namespace Fish\Tabs\HTML;

use Fish\Tabs\Tabs;

class TabPresenter extends Tabs {

    /**
     * @var string
     */
    protected $tab;

    /**
     * @param $tab
     */
    public function __construct($tab) {
        $this->tab = $tab;
    }

    /**
     * convert tab string to a readable title
     * @return string
     */
    public function toName() {

        $separator = $this->config('separator',"_");

        $format = $this->config('capitalization',"first_word");

        $pieces = explode($separator, $this->tab);
        $pieces  = $this->format($pieces, $format);

        $tab = join(" ", $pieces);

        return $tab;

    }

    private function format($pieces, $format) {

        switch ($format):
            case "first_word":
            default:
                $pieces[0] = ucfirst($pieces[0]);
                break;
            case "all_words":
                $pieces = array_map("ucfirst",$pieces);
                break;
            case "no_words":
                break;
        endswitch;

        return $pieces;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->tab;
    }

} 