<?php namespace NaApri\DoctrineSchemaToolL4;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\App;

class DoctrineSchemaToolL4Command extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'schematool:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Doctrine SchemaTool SchemaUpdate.';

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
	 * @return void
	 */
	public function fire()
	{
		$em = App::make('doctrine')->getEntityManager(
			$this->option('connection')
		);

		$driver = $em->getConfiguration()->getMetadataDriverImpl();

		(new \Doctrine\ORM\Tools\SchemaTool($em))
			->updateSchema(array_map(function($className) use ($driver, $em){
			$class = new \Doctrine\ORM\Mapping\ClassMetadata(
				$className,
				$em->getConfiguration()->getNamingStrategy()
			);
			$driver->loadMetadataForClass($className, $class);
			return $class;
		}, $driver->getAllClassNames()));

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('connection', null, InputOption::VALUE_OPTIONAL, 'connection name', null),
		);
	}

}