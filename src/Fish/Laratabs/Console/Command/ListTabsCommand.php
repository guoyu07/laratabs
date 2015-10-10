<?php

namespace Fish\Laratabs\Console\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Fish\Laratabs\Console\Exceptions\InvalidFormatException;
use Fish\Laratabs\Retriever\Retriever;
use App;

class ListTabsCommand extends Command {


  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'tabs:list';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Lists all the saved tabs';


  protected $retriever;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(Retriever $retriever)
  {
    parent::__construct();
    $this->retriever = $retriever;

  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function fire()
  {

    $key = $this->argument('key');

    $keys = $this->retriever->getKeys($key);

    if (!$keys):
      $key?
      $this->error("Key '{$key}' doesn't exists"):
      $this->info('No tabs were found.');
      return false;
    endif;

    foreach ($keys as $key):

      $tabs = $this->retriever->retrieve($key);

      $this->info($key);
      $this->info('--------');

      foreach ($tabs as $tab):

       $this->info("- " . $tab['tab']);

         if (isset($tab['subtabs'])):
          foreach ($tab['subtabs'] as $subtab):
            $this->info("  - " . $subtab);
          endforeach;
         endif;

    endforeach;

    $this->info('');

    endforeach;

   }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return [
      ['key', InputArgument::OPTIONAL, 'list tabs for a specific key.']
    ];
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return [];
  }

}
