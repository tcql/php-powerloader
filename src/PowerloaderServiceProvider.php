<?php namespace Tcql\Powerloader;

use Illuminate\Support\ServiceProvider;
use LoaderManager;
use Loaders as L;


class PowerloaderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app["powerloader"] = $this->app->share(function ($app) {

			$manager = new LoaderManager;
			$manager->extend("psr0", new L\PSR0Loader);
			$manager->extend("psr4", new L\PSR4Loader);
			$manager->extend("plain", new L\PlainClassLoader);


			return $manager;

		});


		// todo: register spl_autoload
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array("powerloader");
	}

}