<?php namespace Tcql\Powerloader\Loaders;

class PSR4Loader implements LoaderInterface
{
	protected $paths = [];


	public function registerClasses(array $classmap = [])
	{
		$this->paths = array_merge($this->paths, $classmap);
	}


	public function detectMatch($classname)
	{
		foreach ($this->paths as $namespace => $path) {

			if (starts_with($classname, $namespace)) {

				$path = ends_with($path, "/") ? $path : $path."/";

				// TODO: Test file exists
				$fullpath = $path.$this->classtoPath($classname, $namespace);	
				return $fullpath;

			}

		}

		return false;

	}


	protected function classToPath($class, $base_namespace)
	{
		$subpath = str_replace([$base_namespace, "\\"], ["", "/"], $class);

		return $subpath.".php";
	}
}