<?php

namespace Fish\Laratabs\Console\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Fish\Laratabs\Console\FieldsParser;
use Fish\Laratabs\Console\Exceptions\InvalidFormatException;
use App;
class GenerateTabsCommand extends Command {

    /**
     * @var FieldsParser
     */
    protected $parser;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'tabs:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate bootstrap tabs.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(FieldsParser $parser)
	{
		parent::__construct();

        $this->parser = $parser;


	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        if (!$tabs = $this->option('tabs')) throw new InvalidFormatException("Please provide a list of tabs, e.g. --tabs='first,second,third'");

        $key = $this->argument('key');

        $parsed = $this->parser->parse($tabs);

        $saver  = App::make('Fish\\Laratabs\\Console\\TabsSaver\\TabsSaver');

        $saver->save($key, $parsed);

        $viewGenerator = App::make('Fish\\Laratabs\\Console\\ViewsGenerator');

        $viewGenerator->generate($key, $parsed);

        $this->info("Tabs were generated successfully with the key '$key'.\nTo fetch the HTML assign Tabs::get('$key') to a variable, pass it to the main view and echo it.");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['key', InputArgument::REQUIRED, 'key to pull the tabs.']
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['tabs', null, InputOption::VALUE_REQUIRED, 'list of tabs.', null]
		];
	}

}
