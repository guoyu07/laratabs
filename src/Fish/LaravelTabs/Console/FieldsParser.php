<?php

namespace Fish\LaravelTabs\Console;

use Fish\LaravelTabs\Console\Exceptions\InvalidFormatException;

class FieldsParser
{
    /**
    *   @param $tabs
    * @return array
     */

    public function parse($tabs)
    {
        $tabs = $this->splitByCharAndIgnoreSpaces(",",$tabs);
        $parsed = [];

        foreach ($tabs as $tab):

            $tab = $this->splitByCharAndIgnoreSpaces(":",$tab);

            if (!$this->hasSubtabs($tab)):
                 $parsed[] = ['tab'=>$tab[0]];
             else:
                 $mainTab = $tab[0];
                 $subtabs = $tab[1];
                 $subtabs = $this->splitByCharAndIgnoreSpaces("|",$subtabs);
                 $parsed[] =['tab'=>$mainTab,
                             'subtabs'=>$subtabs];
            endif;
        endforeach;

        $this->validateTabs($parsed);

        return $parsed;
    }

    /**
     * @param $char
     * @param $tabs
     * @return array
     */
    private function splitByCharAndIgnoreSpaces($char,$tabs)
    {
        $tabs = preg_split("/(\s*)\\" . $char . "(\s*)/", $tabs);

        return $tabs;
    }

    /**
     * @param $tab
     * @return bool
     */
    private function hasSubtabs($tab)
    {
        if (count($tab)>2) throw new InvalidFormatException("Invalid subtabs format.");
        return count($tab) == 2;
    }

    private function validateTabs($tabs) {

        foreach ($tabs as $tab):

            $this->validateTab($tab['tab']);

            if (isset($tab['subtabs'])) {
                foreach ($tab['subtabs'] as $subtab) {
                   $this->validateTab($subtab);
                }
            }

        endforeach;
    }

    private function validateTab($tab) {
        if (trim($tab)=='')
            throw new InvalidFormatException("Invalid tabs format.");
    }
}
