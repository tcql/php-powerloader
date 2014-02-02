<?php namespace Tcql\Powerloader;

use Tcql\Powerloader\Loaders\LoaderInterface;

class LoaderManager
{
	protected $registrars = [];


	/**
	 * attempt to register a classmap through a particular registrar
	 * 
	 * @param  string $name     nickname of the registrar
	 * @param  array  $classmap array of classes/directories to be loaded. exact format depends on loader
	 * @return void
	 */
	public function registerWith($name, array $classmap)
	{
		if (isset($this->registrars[$name])) {

			$this->registrars[$name]->registerClasses($classmap);

		}
	}


	/**
	 * Add a custom registrar class. Can be used to override an existing
	 * registrar as well.
	 * 
	 * @param  [type]          $name   [description]
	 * @param  LoaderInterface $loader [description]
	 * @return [type]                  [description]
	 */
	public function extend($name, LoaderInterface $loader)
	{
		$this->registrars[$name] = $loader;
	}


	public function __call($method, $args)
	{
		// Handles shortcuts for calling (for example: 'registerPsr0()')
		if (starts_with($method, "register")) {
			$registrar = str_replace("register", "", $method);

			$this->registerWith(strtolower($registrar), $args[0]);

		}
	}
}