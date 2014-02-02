<?php namespace Tcql\Powerloader\Loaders;


interface LoaderInterface
{
	public function registerClasses(array $classmap = []);

	public function detectMatch($classname);

}