<?php namespace Tcql\Powerloader;

use PHPUnit_Framework_TestCase;
use Mockery as m;

class LoaderManagerTest extends PHPUnit_Framework_TestCase
{

	public function tearDown()
	{
		m::close();
	}


	public function testExtendShouldAddRegistrar()
	{

		$registrar = m::mock("\Tcql\Powerloader\Loaders\LoaderInterface");

		$manager = new LoaderManager;

		$manager->extend("test", $registrar);

		$this->assertEquals($registrar, $manager->getRegistrar("test"));

	}


	public function testRegisterWithShouldTriggerRegistrar()
	{
		$classmap = ["test" => "/fake/path"];

		$registrar = m::mock("\Tcql\Powerloader\Loaders\LoaderInterface");
		$registrar->shouldReceive("registerClasses")->once()->with($classmap);

		$manager = new LoaderManager;

		$manager->extend("test", $registrar);

		$manager->registerWith("test", $classmap);
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRegisterWithThrowsExceptionForNonexistantRegistrar()
	{
		$manager = new LoaderManager;
		$manager->registerWith("fake", ["key" => "file"]);
	}



	public function testMagicRegisterCallTriggersRegistrar()
	{
		$classmap = ["test" => "/fake/path"];

		$registrar = m::mock("\Tcql\Powerloader\Loaders\LoaderInterface");
		$registrar->shouldReceive("registerClasses")->once()->with($classmap);

		$manager = new LoaderManager;

		$manager->extend("Test", $registrar);

		$manager->registerTest($classmap);
	}


	public function testTest()
	{
		$x = new Loaders\PSR4Loader;
		$x->registerClasses(["Grower\\Fake\\" => "/fake/bleh/blur"]);

		$path = $x->detectMatch('Grower\Fake\Meep\Blergh');
		dd($path);
		dd("herp");
	}
}