<?php return [

    // database or file?

    'storage' => 'database',

    // tabs or pills styling?
    'type' => 'tabs',

    // horizontal or vertical tabs?
    'direction' => 'horizontal',

    // where should the tab generated views be stored?
    // the {{KEY}} placeholder will be replaced by the key you provide for each set of tabs
    // you can remove it if you want to save all sets of tabs in one place
    // the root is the app/views folder
    'views_path' => "{{KEY}}",

    // should the tabs have a fade effect?
    'fade' => true,

    // how should the tab names be displayed?
    // options: uc_first_word
    //          uc_all_words
    //          uc_no_words
    //          locale

    'display' => "uc_first_word"

];
