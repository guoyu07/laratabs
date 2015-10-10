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

class BuildDatabaseTablesCommand extends Command {


  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'tabs:init';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Builds the databse tables. Not necessary if you are using file storage';

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

    $this->createIfDoesNotExists('mfet_keys',function(Blueprint $table) {
      $table->increments('id');
      $table->string('key',50);
      $table->timestamps();
    });

    $this->createIfDoesNotExists('mfet_tabs',function(Blueprint $table) {
      $table->increments('id');
      $table->integer('key_id')->unsigned()->index();
      $table->string('name',50);
      $table->timestamps();

        $table->foreign('key_id')
            ->references('id')->on('mfet_keys')
            ->onDelete('cascade');
    });

    $this->createIfDoesNotExists('mfet_subtabs',function(Blueprint $table) {
          $table->increments('id');
          $table->integer('tab_id')->unsigned()->index();
          $table->string('name',50);
          $table->timestamps();

          $table->foreign('tab_id')
                ->references('id')->on('mfet_tabs')
                ->onDelete('cascade');

    });

    $this->info('Ran databse migrations. go ahead and create a new set of tabs');

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
