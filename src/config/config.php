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

    // capitaliztion while view the pretty name
    // options: first_word
    //          all_words
    //          non_words
  'capitalization' => 'first_word',

    // where will the tabs info be stored?
    'tabs_file_path'=> app_path(). "/.."

];