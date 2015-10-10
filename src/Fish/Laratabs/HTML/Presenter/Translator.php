<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/27/14
 * Time: 12:11 AM
 */

namespace Fish\Laratabs\HTML\Presenter;


class Translator {

    /**
    * @var string
     */
    protected $key;

    /**
    * @param $key
     */
    public function __construct($key) {
        $this->key = $key;
    }

    /**
     * translate the tab name. fall back to ucfirst
     */
    public function trans($pieces) {

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

}
