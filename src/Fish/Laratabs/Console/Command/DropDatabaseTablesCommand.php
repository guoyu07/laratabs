<?php

namespace Fish\Laratabs\Console\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Fish\Laratabs\Console\Exceptions\InvalidFormatException;
use App;
use Key;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDatabaseTablesCommand extends Command {


  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'tabs:destroy';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Drops the pacakge\'s database tables';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function fire()
  {

    $areYouSure = $this->ask('Are you sure you want to drop the package\'s table? (y/n)');

    if (!preg_match('/^y(es)?$/i',$areYouSure)):
      $this->info('Aborted.');
      return false;
    endif;

    Schema::dropIfExists('mfet_subtabs');
    Schema::dropIfExists('mfet_tabs');
    Schema::dropIfExists('mfet_keys');

    $this->info('Dropped pacakge\'s tables');

   }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return [];
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

  protected function createIfDoesNotExists($table, $callback) {
      if (Schema::hasTable($table)) {
        $this->info("table {$table} already exists");
        return false;
      }

      Schema::create($table, $callback);
  }

}
