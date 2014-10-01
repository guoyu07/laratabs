<?php
/**
 * Created by PhpStorm.
 * User: matanya
 * Date: 9/29/14
 * Time: 5:08 PM
 */

class TabsTester extends \Codeception\TestCase\Test {

    protected $data;

    public function __construct() {
        $this->data = [
            'tabs'=>[
                ['tab'=>'tab1'],
                ['tab'=>'tab2'],
                ['tab'=>'tab3',
                    'subtabs'=>['subtab1', 'subtab2']],
                ['tab'=>'tab4']
            ]
        ];

    }


} 