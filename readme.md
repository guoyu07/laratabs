[![Latest Stable Version](https://poser.pugx.org/fish/laratabs/v/stable.svg)](https://packagist.org/packages/fish/laratabs) [![Total Downloads](https://poser.pugx.org/fish/laratabs/downloads.svg)](https://packagist.org/packages/fish/laratabs) [![Latest Unstable Version](https://poser.pugx.org/fish/laratabs/v/unstable.svg)](https://packagist.org/packages/fish/laratabs) [![License](https://poser.pugx.org/fish/laratabs/license.svg)](https://packagist.org/packages/fish/laratabs)

### Note: this version is for laravel 5 only. For laravel 4 specify in your composer version `^1.0` instead of `^2.0`.

# Generate Bootstrap tabs in your Laravel app

This Laravel package provides an artisan command to easily generate bootstrap tabs.
The package creates a unique view for each tab, and allows you to embed the tabs wherever you need in your HTML.
This makes for a clean uncluttered code, and allows you to skip the tedious process of writing the HTML yourself and focus on the content of the tabs.

- [Installation](#installation)
- [Usage](#usage)
    - [Generate the tabs](#generate-the-tabs)
    - [Fill the views with content](#fill-the-views-with-content)
    - [Pull the tabs into your view](#pull-the-tabs-into-your-view)
        - [Syntax](#syntax)
        - [Usage](#usage-1)
- [Config](#config)

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `fish/laratabs`.

	"require": {
		"fish/laratabs": "^2.0"
	}

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    Fish\Laratabs\LaratabsServiceProvider::class

On the client-side remember to include bootstrap's CSS and JavaScript files. The quickest way is using a CDN:

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `tabs` command.

    php artisan

## Usage

### Generate the tabs

On the first time you use the package run the following to build the database tables: (unless you choose 'file' for storage)

    php artisan tabs:init

Now create the tabs:

    php artisan tabs:generate [key] [--tabs="list-of-tabs"]

First provide the key, which you will use later to grab the tabs, and then list the tabs.
The tabs should be entered as a comma separated list. The words are spearated by default with an underscore.
Of course, when presented in the view they will be separated by spaces. As for capitaliztion, by default the first word will be uppercase.

if you want to create a tab with dropdown menu the syntax is `main_tab:sub_tab1|sub_tab2`.

Example:

    php artisan tabs:generate article --tabs="section1, section2, section3:sub_section1|sub_section2"

Note that the key is also used by default to set the name of the folder, where the tabs partials will be created.

### Fill the views with content

The views will reside by default under `app/views/[key]`.

### Pull the tabs into your view

#### Syntax
    Tabs::get($key, $data = [], $options = []);

`$key`
(string)(required) The key used while generating the tabs.

`$data`
(assoc. array)(optional) data to be passed to the views.

`$options`
(assoc. array)(optional) customization [options](#options).

#### Usage

In your controller pass the returned value to the main view, e.g:

    return View::make('main.view', ['tabs'=>Tabs::get('article')]);

Then in your view echo {!! $tabs !!} wherever you want the tabs to appear.

## Config

The package allows you to config a few options, each of which is applicable either globally (G) - i.e for all sets of tabs, locally (L) - i.e for the current set of tabs, or both.
local options are passed as the third argument to the `get` method, while global options are set in the pacakage `config.php` file.

To change the global configuration you need to publish it to your project first:

     php artisan vendor:publish

The path to the published file is:

    config/laratabs.php

### Options

| Option         | Description                     | Scope   | Values               | Default             |
|:-------------  |:-------------                   |:-----   |:-----                |:-------             |
| type           |                                 | GL      | tabs,pills           | tabs                |
| storage        |                                 | G       | database, file       | database            |
| direction      |                                 | GL      | horizontal, vertical | horizontal          |
| views_path     | The path where the              |  G      |                      | the key used when
|                |  tabs partials will be created      |        |                        |  creating the tabs
|                |  relative to the views folder.   |        |                        |                      |                                                               |                     |
| fade           | use fade effect?                | GL      | true, false          | true                |            |
|                |  in the artisan command         |          |                      |                     |
| display        | Display of the titles           | GL      |  uc_first_word,      | uc_first_word       |
|                |                                 |         |   uc_all_words,       |                     |
|                |                                 |         |   uc_no_words,        |                     |
|                |                                 |         |   [locale](#locale)              |                     |
| except         | black-list of tabs              | L       |  [array, of, tabs]   |                     |
|                | not to be presented             |         |                      |                     |
| only           | white-list of tabs              | L       |  [array, of, tabs]   |                     |
|                | to be presented                 |         |                      |                     |

#### Locale

The locale option will look for the translation in a `tabs.php` file under the current locale.
The array returned from the file should be constructed as follows:

    [
        'some-key'=> [
           'tab1' => 'Tab no. 1'
           'tab2' => 'Tab no. 2'
           'tab3' => 'Tab no. 3'
        ]

        'some-other-key'=> [
           'tab4' => 'Tab no. 4'
           'tab5' => 'Tab no. 5'
           'tab6' => 'Tab no. 6'
        ]
    ]

If no translation is found it will fallback to `uc_first_word`.



