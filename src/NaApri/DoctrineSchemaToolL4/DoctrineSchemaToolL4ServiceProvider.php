<?php namespace NaApri\DoctrineSchemaToolL4;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DoctrineSchemaToolL4ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('na-apri/doctrine-schema-tool-l4');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['doctrine'] = $this->app->share(function($app){
			return new DoctrineSchemaToolL4Manager();
		});

		$this->app['schematool.update'] = $this->app->share(function($app)
		{
			return new DoctrineSchemaToolL4Command();
		});
		$this->commands('schematool.update');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('doctrine', 'schematool.update');
	}

}