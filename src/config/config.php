<?php return [

    // select laravel version (4 or 5)
    'laravel_version' => 4,

    // tabs or pills styling?
    'type' => 'tabs',

    // horizontal or vertical tabs?
    'direction' => 'horizontal',

    // where should the tab generated views be stored?
    // the {{KEY}} placeholder will be replaced
    // by the key you provide for each set of tabs
    // you can remove it if you want to save all sets of tabs in one place
    // the root is the app/views folder
    'views_path' => "{{KEY}}",

    // should the tabs have a fade effect?
    'fade' => true,

    // which words separator to use in the artisan command?
    'separator'=> "_",

    // how should the tab names be displayed?
    // options: uc_first_word
    //          uc_all_words
    //          uc_no_words
    //          locale

    'display' => "uc_first_word"

];