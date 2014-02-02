<?php namespace Tcql\Powerloader;

use Tcql\Powerloader\Loaders\LoaderInterface;
use InvalidArgumentException;

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
		$registrar = $this->getRegistrar($name);

		$this->registrars[$name]->registerClasses($classmap);
	}


	/**
	 * Returns all registrars
	 * 
	 * @return array
	 */
	public function getRegistrars()
	{
		return $this->registrars;
	}


	/**
	 * Returns registrar matching $name 
	 * 
	 * @param  string $name
	 * @return LoaderInterface
	 */
	public function getRegistrar($name)
	{
		if (isset($this->registrars[$name])) {
			return $this->registrars[$name];
		}

		throw new InvalidArgumentException("Powerloader: Registrar {$name} does not exist");
	}


	/**
	 * Add a custom registrar class. Can be used to override an existing
	 * registrar as well.
	 * 
	 * @param  string          $name   [description]
	 * @param  LoaderInterface $loader [description]
	 * @return void
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

			$this->registerWith($registrar, $args[0]);

		}
	}
}